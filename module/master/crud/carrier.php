<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $exclude = $_POST['task'];
        $sel = $_POST['sel'];
        if($exclude=='exclude'){
            if ($stmt = $mysqli->prepare("SELECT iCarID, CONCAT(cCarRuc,' - ',cCarNam) AS find FROM tm_carrier WHERE cCarSta='1'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($carrier_id, $carrier);
                while($row = $stmt->fetch()) {
                    if($sel==$carrier_id){$selected = " selected";}else{$selected = "";}
                        echo '<option value="'.$carrier_id.'">'.$carrier.'</option>';
                    }
                }            
            }
        }
        if($exclude=='dynu'){
            $active = $_POST['act'];
            $_names = explode("-", $sel);//clase,tipo,cat
            $_class = $_names[0];
            $_type = $_names[1];
            $_cat = $_names[2];
            $_active = explode(",", $active);
            //echo 'Clase: '.$_class.' Tipo: '.$_type.' Categoria: '.$_cat;
            if ($stmt = $mysqli->prepare("SELECT c.iCarID, CONCAT(c.cCarRuc,' - ',c.cCarNam) "
                    . " FROM tm_vehicle as v "
                    . " JOIN tm_vehicle_assignation as va ON va.iVehID = v.iVehID"
                    . " JOIN tm_carrier as c ON c.iCarID = va.iCarID"
                    . " WHERE v.cVehSta='1' AND v.iVehClaID='".$_class."' AND v.iVehTypID='".$_type."' AND v.iVehCatID='".$_cat."'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($carrier_id, $carrier);
                while($row = $stmt->fetch()) {
                    $selected = "";
                    for($i=0; $i< sizeof($_active) ;$i++){
                       if($_active[$i]==$carrier_id){$selected = " selected";}
                    }
                    echo '<option value="'.$carrier_id.'" '.$selected.'>'.$carrier.'</option>';
                }            
            }
        }
        if($exclude=='dyn'){
            $aux_names = explode("_", $sel);
            $_names = explode("-", $aux_names[1]);//id,clase,tipo,cat
            $indice = $_names[0];
            $_class = $_names[1];
            $_type = $_names[2];
            $_cat = $_names[3];
            if ($stmt = $mysqli->prepare("SELECT DISTINCT(c.iCarID), CONCAT(c.cCarRuc,' - ',c.cCarNam) "
                    . " FROM tm_vehicle as v "
                    . " JOIN tm_vehicle_assignation as va ON va.iVehID = v.iVehID"
                    . " JOIN tm_carrier as c ON c.iCarID = va.iCarID"
                    . " WHERE v.cVehSta='1' AND v.iVehClaID='".$_class."' AND v.iVehTypID='".$_type."' AND v.iVehCatID='".$_cat."'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($carrier_id, $carrier);
                while($row = $stmt->fetch()) {
                    echo '<option value="'.$carrier_id.'">'.$carrier.'</option>';
                }            
            }
        }
    else{
        if($action=='select'){
            //echo "SELECT iCarID, cCarNam, cCarAdd, cCarPhoNam, cCarEmaNam, cCarRuc, cCarAge, cCarPhoAge, cCarEmaAge, cCarCon, cCarPhoCon, cCarEmaCon, cCarSta FROM tm_carrier";
            if ($stmt = $mysqli->prepare("SELECT iCarID, cCarNam, cCarAdd, cCarPhoNam, cCarWebNam, cCarRuc, cCarAge, cCarPhoAge, cCarEmaAge, cCarCon, cCarPhoCon, cCarEmaCon, cCarUseGPS, cCarPasGPS, cCarSta FROM tm_carrier")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($carrier_id, $carrier_name, $carrier_address, $carrier_phone_name, $carrier_web_name, $carrier_ruc, $carrier_agent, $carrier_phone_agent, $carrier_email_agent, $carrier_contact, $carrier_phone_contact, $carrier_email_contact, $carrier_user_gps, $carrier_password_gps, $carrier_status);
                while($row = $stmt->fetch()) {
                    if($carrier_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$carrier_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$carrier_id.'"></td>'.
                        '<td>'.$carrier_id.$status.'</td>'.
                        '<td>'.$carrier_name.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&perp; '.$carrier_address.'    &phone;'.$carrier_phone_name.'    &bull;'.$carrier_web_name.'" title="'.$carrier_name.'" data-placement="left"><i class="glyphicon glyphicon-briefcase"/></a></td>'.
                        '<td>'.$carrier_ruc.'</td>'.
                        '<td>'.$carrier_agent.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&phone;'.$carrier_phone_agent.'    @&nbsp;'.$carrier_email_agent.'" title="'.$carrier_agent.'" data-placement="left"><i class="glyphicon glyphicon-user"/></a></td>'.
                        '<td>'.$carrier_contact.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&phone;'.$carrier_phone_contact.'    @&nbsp;'.$carrier_email_contact.'" title="'.$carrier_contact.'" data-placement="left"><i class="glyphicon glyphicon-user"/></a></td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$carrier_id.'" data-name="'.$carrier_name.'" data-address="'.$carrier_address.'" data-phone_name="'.$carrier_phone_name.'" data-web_name="'.$carrier_web_name.'" data-code="'.$carrier_ruc.'" data-agent="'.$carrier_agent.'" data-phone_agent="'.$carrier_phone_agent.'" data-email_agent="'.$carrier_email_agent.'" data-contact="'.$carrier_contact.'" data-phone_contact="'.$carrier_phone_contact.'" data-email_contact="'.$carrier_email_contact.'"  data-user_gps="'.$carrier_user_gps.'"  data-password_gps="'.$carrier_password_gps.'" data-status="'.$carrier_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $carrier_id = $_POST['id'];
           $carrier_name = $_POST['name'];
           $carrier_address = $_POST['address'];
           $carrier_phone_name = $_POST['phone_name'];
           $carrier_web_name = $_POST['web_name'];
           $carrier_ruc = $_POST['code'];
           $carrier_agent = $_POST['agent'];
           $carrier_phone_agent = $_POST['phone_agent'];
           $carrier_email_agent = $_POST['email_agent'];
           $carrier_contact = $_POST['contact'];
           $carrier_phone_contact = $_POST['phone_contact'];
           $carrier_email_contact = $_POST['email_contact'];
           $carrier_user_gps = $_POST['user_gps'];
           $carrier_password_gps = $_POST['password_gps'];
           if($_POST['status']=='true'){$carrier_status=1;}else{$carrier_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_carrier (cCarNam, cCarAdd, cCarPhoNam, cCarWebNam, cCarRuc, cCarAge, cCarPhoAge, cCarEmaAge, cCarCon, cCarPhoCon, cCarEmaCon, cCarUseGPS, cCarPasGPS, cCarSta) VALUES ('".$carrier_name."', '".$carrier_address."', '".$carrier_phone_name."', '".$carrier_web_name."', '".$carrier_ruc."', '".$carrier_agent."', '".$carrier_phone_agent."', '".$carrier_email_agent."', '".$carrier_contact."', '".$carrier_phone_contact."', '".$carrier_email_contact."', '".$carrier_user_gps."', '".$carrier_password_gps."', '".$carrier_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_carrier SET cCarNam='".$carrier_name."' , cCarAdd='".$carrier_address."', cCarPhoNam='".$carrier_phone_name."', cCarWebNam='".$carrier_web_name."', cCarRuc='".$carrier_ruc."', cCarAge='".$carrier_agent."', cCarPhoAge='".$carrier_phone_agent."', cCarEmaAge='".$carrier_email_agent."', cCarCon='".$carrier_contact."', cCarPhoCon='".$carrier_phone_contact."', cCarEmaCon='".$carrier_email_contact."', cCarUseGPS='".$carrier_user_gps."', cCarPasGPS='".$carrier_password_gps."', cCarSta='".$carrier_status."' WHERE iCarID='".$carrier_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $carrier_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_carrier WHERE iCarID='".$_id[$i]."'");
               }
           }
        }
    }