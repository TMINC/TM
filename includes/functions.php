<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'psl-config.php';

function sec_session_start() {
    $session_name = 'tm_session_id';   // Set a custom session name 
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function login($user, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT iUseID, cUseUse, cUseNam, cUsePas, cUseSal 
				  FROM tm_user 
                                  WHERE cUseUse = ? LIMIT 1")) 
    {
        $stmt->bind_param('s', $user);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        // get variables from result.
        $stmt->bind_result($user_id, $useractive, $username, $db_password, $salt);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked 
                return false;
            } else {
                // Check if the password in the database matches 
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $useractive = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $useractive);

                    $_SESSION['user'] = $useractive;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    if (!$mysqli->query("UPDATE tm_user SET cUseAct='1' WHERE iUseID='".$user_id."'")) {
                        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
                        exit();
                    }
                    // Login successful. 
                    return true;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    if (!$mysqli->query("INSERT INTO tm_login_attempts(iUseID, cLogAttTim) 
                                    VALUES ('$user_id', '$now')")) {
                        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
                        exit();
                    }$mysqli->query();                    
                    return false;
                }
            }
        } else {
            // No user exists. 
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
    if ($stmt = $mysqli->prepare("SELECT cLogAttTim 
                                  FROM tm_login_attempts 
                                  WHERE iUseID = ? AND cLogAttTim > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
        exit();
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT cUsePas FROM tm_user WHERE iUseID = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Could not prepare statement
            header("Location: ../error.php?err=Database Error: Cannot prepare statement");
            exit();
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {
    if ('' == $url) { return $url; }
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function measure_char($iMeaID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
    $stmt->bind_param('s', $iMeaID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure);
    $stmt->fetch();
    return $measure;
}

function center_char($iCenID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cCenNam FROM tm_center WHERE iCenID = ?");
    $stmt->bind_param('s', $iCenID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($center);
    $stmt->fetch();
    return $center;
}

function center_type_char($iCenID, $mysqli){
    $stmt = $mysqli->prepare("SELECT iCenTyp FROM tm_center WHERE iCenID = ?");
    $stmt->bind_param('i', $iCenID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($center);
    $stmt->fetch();
    return $center;
}

function customer_char($iCusID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cCusNam FROM tm_customer WHERE iCusID = ?");
    $stmt->bind_param('s', $iCusID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($customer);
    $stmt->fetch();
    return $customer;
}

function carrier_char($iCarID, $mysqli){
    $stmt = $mysqli->prepare("SELECT CONCAT(cCarRuc,' - ',cCarNam) AS carrier FROM tm_carrier WHERE iCarID = ?");
    $stmt->bind_param('s', $iCarID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($carrier);
    $stmt->fetch();
    return $carrier;
}

function user_char($iUseID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cUseNam FROM tm_user WHERE iUseID = ?");
    $stmt->bind_param('i', $iUseID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name);
    $stmt->fetch();
    return $name;
}

function detail_total($iOrdID, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_order_detail WHERE iOrdID = ?");
    $stmt->bind_param('s', $iOrdID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}

function order_total($cOrdSta, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_order WHERE cOrdSta = ?");
    $stmt->bind_param('s', $cOrdSta);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}

function get_vehicles_total($vehcla_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_vehicle WHERE cVehSta='1' AND iVehClaID = ?");
    $stmt->bind_param('s', $vehcla_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}
function get_vehicles_details($vehcla_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT DISTINCT(v.iVehTypID), v.iVehCatID, CONCAT(vt.cVehTypNam,' [',vc.cVehCatInf,']') "
            . "FROM tm_vehicle v "
            . "JOIN tm_vehicle_type vt ON v.iVehTypID = vt.iVehTypID  "
            . "JOIN tm_vehicle_category vc ON v.iVehCatID = vc.iVehCatID "
            . "WHERE v.cVehSta='1' AND v.iVehClaID = ?");
    $stmt->bind_param('i', $vehcla_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehtyp_id,$vehcat_id,$veh_dsc);
    $valor = "";$i=0;
    while($row = $stmt->fetch()) {
        $valor .= '<option value='.$i.'-'.$vehcla_id.'-'.$vehtyp_id.'-'.$vehcat_id.'>'.$veh_dsc.'</option>';
        $i++;
    }    
    return $valor;
}
function get_vehicles_details_adjudication($xi,$vehcla_id,$vehtyp_id,$vehcat_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT DISTINCT(at.iVehTypID), at.iVehCatID, CONCAT(vt.cVehTypNam,' [',vc.cVehCatInf,']') "
            . "FROM tm_allocation_transport at "
            . "JOIN tm_vehicle_type vt ON at.iVehTypID = vt.iVehTypID  "
            . "JOIN tm_vehicle_category vc ON at.iVehCatID = vc.iVehCatID "
            . "WHERE at.iAllTraStaVeh not in (1,2) AND at.iVehClaID=".$vehcla_id." AND at.iVehTypID=".$vehtyp_id." AND at.iVehCatID=".$vehcat_id." ");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehtyp_id,$vehcat_id,$veh_dsc);
    $valor = "";$i=0;
    while($row = $stmt->fetch()) {
        $valor .= '<option value='.$xi.'_'.$i.'-'.$vehcla_id.'-'.$vehtyp_id.'-'.$vehcat_id.'>'.$veh_dsc.'</option>';
        $i++;
    }    
    return $valor;
}

function get_dsc_cla_veh($vehcla_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT CONCAT(cVehClaInf,' - ',cVehClaNam) "
            . "FROM tm_vehicle_class "
            . "WHERE iVehClaID = ?");
    $stmt->bind_param('i', $vehcla_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($veh_dsc);
    $stmt->fetch();
    return $veh_dsc;
}
function get_order_details($order_id,$mysqli){
    $stmt = $mysqli->prepare("SELECT iOrdDetID "
            . "FROM tm_order_detail "
            . "WHERE iOrdID in ('".$order_id."')");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($detail_id);
    $order_detail_id = "";
    while($row = $stmt->fetch()) {
        $order_detail_id .= $detail_id.',';
    }
    $order_detail_id = trim($order_detail_id, ',');
    return $order_detail_id;
}
function get_Allocation_Transport_ID($vehcla_id,$vehtyp_id,$vehcat_id,$mysqli){
    $stmt = $mysqli->prepare("SELECT iAllTraID "
            . "FROM tm_allocation_transport "
            . "WHERE iAllTraStaVeh = 0 AND iVehClaID=".$vehcla_id." AND iVehTypID=".$vehtyp_id." AND iVehCatID=".$vehcat_id." "
            . "LIMIT 1");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($alltra_id);
    $stmt->fetch();
    return $alltra_id;    
}
function get_order_details_allocation($order_detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT iAllTraDetID FROM tm_allocation_transport_detail WHERE cAllTraDetOrdDet in ('".$order_detail_id."')");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($allocation_id);
    $allocation_detail_id = "";
    while($row = $stmt->fetch()) {
        $allocation_detail_id .= $allocation_id.',';
    }
    $allocation_detail_id = trim($allocation_detail_id, ',');
    return $allocation_detail_id;
}
function gps_all($order_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT iTraID, cTraLatLon, tm_track.iOrdDetID, cTraStaGps FROM tm_track, tm_order_detail WHERE tm_track.iOrdDetID = tm_order_detail.iOrdDetID AND iOrdID = ?");
    $stmt->bind_param('i', $order_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($track_id, $track_latitud_longitude, $track_detail_id, $track_gps);
    $gps = "";
    while($row = $stmt->fetch()) {
        $gps .= $track_latitud_longitude.'/';
    }
    $gps = trim($gps, '/');
    return $gps;
}

function gps_table($iOrdDetID, $mysqli){
    $stmt = $mysqli->prepare("SELECT iTraID, cTraLatLon, cTraStaGPS, cTraSta FROM tm_track WHERE iOrdDetID = ?");
    $stmt->bind_param('i', $iOrdDetID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($track_id, $track_latitud_longitude, $track_gps, $track_status);
    $gps = "";
    if($stmt->num_rows()>1){
        $coordinate = '<td>';
        $status = '<td>';
        $graphic = '<td class="center">';
        while($row = $stmt->fetch()) {
            $_coordinate = explode(",", $track_latitud_longitude);
            $coordinate .= '<div class="formSep">LAT: '.$_coordinate[0].' - LON:'.$_coordinate[1].'</div>';
            $status .= '<div class="formSep">'.$track_gps.'</div>';
            $graphic .= '<div class="formSep"><a style="cursor:pointer;" class="signal_gps gps_'.$track_id.' hint--left" data-hint="Ver en Mapa" data-coordinate="'.$track_latitud_longitude.'"><i class="glyphicon glyphicon-globe"></i></a></div>';
        }
        $coordinate .= '</td>';
        $status .= '</td>';
        $graphic .= '</td>';
        $gps .= $coordinate.$status.$graphic;
    }else{
        while($row = $stmt->fetch()) {
            $_coordinate = explode(",", $track_latitud_longitude);
            $gps .= '<td>LAT: '.$_coordinate[0].' - LON:'.$_coordinate[1].'</td>'.
                '<td>'.$track_gps.'</td>'.
                '<td class="center">'.
                    '<a style="cursor:pointer;" class="signal_gps gps_'.$track_id.' hint--left" data-hint="Ver en Mapa" data-coordinate="'.$track_latitud_longitude.'"><i class="glyphicon glyphicon-globe" /></a>'.
                '</td>';
        }
    }
    return $gps;
}
function views($help_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_help_reply WHERE iHelID = ?");
    $stmt->bind_param('s', $help_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}
function format($number){
    if($number<9){return "00000000".$number;}
    else if($number<99){return "0000000".$number;}
    else if($number<999){return "000000".$number;}
    else if($number<9999){return "00000".$number;}
    else if($number<99999){return "0000".$number;}
    else if($number<999999){return "000".$number;}
    else if($number<9999999){return "00".$number;}
    else if($number<99999999){return "0".$number;}
    else {return $number;}
 }
 
 function ship_char($detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT td.iAllTraID, CONCAT(vc.cVehClaInf,' ',vc.cVehClaNam) AS vClass, vt.cVehTypInf, va.cVehCatInf, td.cAllTraDetAdjTyp FROM tm_allocation_transport_detail AS td, tm_allocation_transport AS t, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS va WHERE vc.iVehClaID=t.iVehClaID AND vt.iVehTypID=t.iVehTypID AND va.iVehCatID=t.iVehCatID AND t.iAllTraID=td.iAllTraID AND td.cAllTraDetOrdDet = ?");
    $stmt->bind_param('i', $detail_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehicle_code, $vehicle_class, $vehicle_type, $vehicle_category, $vehicle_status);
    $ship = "";
    while($row = $stmt->fetch()) {
        if($vehicle_status=="1"){$status="S";$style="class='act-info' style='font-size:10px;bold:bolder;'";}else{$status="D";$style="class='act-success' style='font-size:10px;bold:bolder;'";}
        $ship.= "<span ".$style.">".$vehicle_code."[".$status."] - ".$vehicle_class." / ".$vehicle_type." / ".$vehicle_category."</span><br />";
    }
    return $ship;
 }
 
 function ship_carrier_char($detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT td.iAllTraID, ca.i, CONCAT(ca.cCarRuc,' ',ca.cCarNam) AS carrier, td.cAllTraDetAdjTyp FROM tm_allocation_transport_detail AS td, tm_allocation_transport AS t, tm_carrier AS ca WHERE t.iAllTraID=td.iAllTraID AND td.cAllTraDetCarrID=ca.iCarID AND td.cAllTraDetOrdDet= ?");
    $stmt->bind_param('i', $detail_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehicle_code, $carrier_id, $carrier_description, $order_status);
    $ship = "";
    while($row = $stmt->fetch()) {
        if($vehicle_status=="1"){$status="S";$style="class='act-info' style='font-size:10px;bold:bolder;'";}else{$status="D";$style="class='act-success' style='font-size:10px;bold:bolder;'";}
        $ship.= "<span ".$style.">".$vehicle_code."[".$status."] - ".$vehicle_class." / ".$vehicle_type." / ".$vehicle_category."</span><br />";
    }
    return $ship;
 }
 
 function get_ship_id($iAllTraDetID, $mysqli){
    $stmt = $mysqli->prepare("SELECT iAllTraID FROM tm_allocation_transport_detail WHERE cAllTraDetOrdDet = ?");
    $stmt->bind_param('s', $iAllTraDetID);
    $stmt->execute();
    $stmt->bind_result($allocation_transport_id);
    $ship_id = "";
    while($row = $stmt->fetch()) {
        $ship_id.= $allocation_transport_id;
    }
    return $ship_id;
}

function ship_char_extreme($detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT td.iAllTraID, CONCAT(vc.cVehClaInf,' ',vc.cVehClaNam) AS vClass, vt.cVehTypInf, va.cVehCatInf, td.cAllTraDetAdjTyp, td.cAllTraDetCarrID FROM tm_allocation_transport_detail AS td, tm_allocation_transport AS t, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS va WHERE vc.iVehClaID=t.iVehClaID AND vt.iVehTypID=t.iVehTypID AND va.iVehCatID=t.iVehCatID AND t.iAllTraID=td.iAllTraID AND td.cAllTraDetOrdDet = ?");
    $stmt->bind_param('i', $detail_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehicle_code, $vehicle_class, $vehicle_type, $vehicle_category, $vehicle_status, $current_id);
    $ship = "";
    if($stmt->num_rows()>1){
        $vehicle = '<td>';
        $graphic = '<td class="center">';
        while($row = $stmt->fetch()) {
            if($vehicle_status=='0'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Adjudicaci&oacute;n Directa"><i class="glyphicon glyphicon-ok"></i></a>';
                $class='reassign';
                $current_name = carrier_char($current_id, $mysqli);
            }
            if($vehicle_status=='1'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Proceso Subasta"><i class="glyphicon glyphicon-time"></i></a>';
                $class='no_reassign';
                $current_name = "";
            }            
            $order_detail_id ="";
            $vehicle .= '<div class="formSep">'.format($vehicle_code).' - '.$vehicle_class.' / '.$vehicle_type.' / '.$vehicle_category.$status.'</div>';
            $graphic .= '<div class="formSep"><a style="cursor:pointer;" class="'.$class.' hint--left" data-hint="Reasignar Servicio" data-id="'.$detail_id.'" data-ids="'.$order_detail_id.'" data-current_id="'.$current_id.'" data-current_name="'.$current_name.'"><i class="glyphicon glyphicon-transfer"></i></a></div>';
        }
        $vehicle .= '</td>';
        $graphic .= '</td>';
        $ship .= $vehicle.$graphic;
    }else{
        while($row = $stmt->fetch()) {
            if($vehicle_status=='0'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Adjudicaci&oacute;n Directa"><i class="glyphicon glyphicon-ok"></i></a>';
                $class='reassign';
                $current_name = carrier_char($current_id, $mysqli);
            }
            if($vehicle_status=='1'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Proceso Subasta"><i class="glyphicon glyphicon-time"></i></a>';
                $class='no_reassign';
                $current_name = "";
            }            
            $order_detail_id ="";
            $ship .= '<td>'.format($vehicle_code).' - '.$vehicle_class.' / '.$vehicle_type.' / '.$vehicle_category.$status.'</td>'.
                '<td class="center">'.
                    '<a style="cursor:pointer;" class="'.$class.' hint--left" data-hint="Reasignar Servicio" data-id="'.$detail_id.'" data-ids="'.$order_detail_id.'" data-current_id="'.$current_id.'" data-current_name="'.$current_name.'"><i class="glyphicon glyphicon-transfer"></i></a>'.
                '</td>';
        }
    }
    return $ship;
 }
 
 function ship_char_extreme_auction($detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT td.iAllTraID, CONCAT(vc.cVehClaInf,' ',vc.cVehClaNam) AS vClass, vt.cVehTypInf, va.cVehCatInf, td.cAllTraDetAdjTyp, td.cAllTraDetCarrID FROM tm_allocation_transport_detail AS td, tm_allocation_transport AS t, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS va WHERE vc.iVehClaID=t.iVehClaID AND vt.iVehTypID=t.iVehTypID AND va.iVehCatID=t.iVehCatID AND t.iAllTraID=td.iAllTraID AND td.cAllTraDetAdjTyp='1' AND td.cAllTraDetOrdDet = ?");
    $stmt->bind_param('i', $detail_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehicle_code, $vehicle_class, $vehicle_type, $vehicle_category, $vehicle_status, $current_id);
    $ship = "";
    while($row = $stmt->fetch()) {
        $ship .= format($vehicle_code).' - '.$vehicle_class.' / '.$vehicle_type.' / '.$vehicle_category.$status.'<br />';
    }
    return $ship;
 }
 
 function ship_char_full($detail_id, $mysqli){
    $stmt = $mysqli->prepare("SELECT td.iAllTraID, CONCAT(vc.cVehClaInf,' ',vc.cVehClaNam) AS vClass, vc.cVehClaInf, vt.cVehTypInf, va.cVehCatInf, td.cAllTraDetAdjTyp, td.cAllTraDetCarrID FROM tm_allocation_transport_detail AS td, tm_allocation_transport AS t, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS va WHERE vc.iVehClaID=t.iVehClaID AND vt.iVehTypID=t.iVehTypID AND va.iVehCatID=t.iVehCatID AND t.iAllTraID=td.iAllTraID AND td.cAllTraDetOrdDet = ?");
    $stmt->bind_param('i', $detail_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($vehicle_code, $vehicle_class_total, $vehicle_class, $vehicle_type, $vehicle_category, $vehicle_status, $current_id);
    $ship = "";
    if($stmt->num_rows()>1){
        $vehicle = '<td>';
        $graphic = '<td class="center">';
        while($row = $stmt->fetch()) {
            if($vehicle_status=='0'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Adjudicaci&oacute;n Directa"><i class="glyphicon glyphicon-ok"></i></a>';
                $class='';
                $current_name = carrier_char($current_id, $mysqli);
            }
            if($vehicle_status=='1'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Proceso Subasta"><i class="glyphicon glyphicon-time"></i></a>';
                $class='no_';
                $current_name = "";
            }
            $vehicletotal = $vehicle_class_total.' / '.$vehicle_type.' / '.$vehicle_category;
            $order_detail_id ="";
            $vehicle .= '<div class="formSep">'.format($vehicle_code).' - '.$vehicle_class.' / '.$vehicle_type.' / '.$vehicle_category.$status.'</div>';
            $graphic .= '<div class="formSep"><a style="cursor:pointer;" class="'.$class.'add_transport hint--left" data-hint="Datos Transporte" data-id="'.$detail_id.'" data-carrier_id="'.$current_id.'" data-carrier="'.$current_name.'" data-vehicle="'.$vehicletotal.'"><i class="glyphicon glyphicon-list"></i></a>'.
                        '<a style="cursor:pointer;margin-left:20px;" class="'.$class.'add_state hint--left" data-hint="Control de Estados" data-id="'.$detail_id.'"><i class="glyphicon glyphicon-check" /></a></div>';
        }
        $vehicle .= '</td>';
        $graphic .= '</td>';
        $ship .= $vehicle.$graphic;
    }else{
        while($row = $stmt->fetch()) {
            if($vehicle_status=='0'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Adjudicaci&oacute;n Directa"><i class="glyphicon glyphicon-ok"></i></a>';
                $class='';
                $current_name = carrier_char($current_id, $mysqli);
            }
            if($vehicle_status=='1'){
                $status='<a class="hint--left hint--info" style="float:right;cursor:pointer;" data-hint="Proceso Subasta"><i class="glyphicon glyphicon-time"></i></a>';
                $class='no_';
                $current_name = "";
            }   
            $vehicletotal = $vehicle_class_total.' / '.$vehicle_type.' / '.$vehicle_category;
            $order_detail_id ="";
            $ship .= '<td>'.format($vehicle_code).' - '.$vehicle_class.' / '.$vehicle_type.' / '.$vehicle_category.$status.'</td>'.
                '<td class="center">'.
                    '<a style="cursor:pointer;" class="'.$class.'add_transport hint--left" data-hint="Datos Transporte" data-id="'.$detail_id.'" data-carrier_id="'.$current_id.'" data-carrier="'.$current_name.'" data-vehicle="'.$vehicletotal.'"><i class="glyphicon glyphicon-list"></i></a>'.
                    '<a style="cursor:pointer;margin-left:20px;" class="'.$class.'add_state hint--left" data-hint="Control de Estados" data-id="'.$detail_id.'"><i class="glyphicon glyphicon-check" /></a>'.
                '</td>';
        }
    }
    return $ship;
 }