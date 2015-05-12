<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iDriID, CONCAT(cDriLic,' - ',cDriFirNam,' ',cDriLasNam) AS find FROM tm_driver WHERE cDriSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($driver_id, $driver);
            while($row = $stmt->fetch()) {
                if($sel==$driver_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$driver_id.'" '.$selected.'>'.$driver.'</option>';
            }            
        }
    }else{
        if($action=='select'){            
            if ($stmt = $mysqli->prepare("SELECT iDriID, cDriLic, cDriFirNam, cDriLasNam, cDriAdd, cDriPho, cDriDat, cDriDni, cDriBlo, cDriTyp, c.iCarID, c.cCarNam, cDriSta FROM tm_driver AS d LEFT JOIN tm_carrier AS c ON d.iCarID=c.iCarID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($driver_id, $driver_license, $driver_first_name, $driver_last_name, $driver_address, $driver_phone, $driver_date_birth, $driver_dni, $driver_blood_type, $driver_type, $carrier_id, $carrier_name, $driver_status);
                while($row = $stmt->fetch()) {
                    if($driver_type=='1'){$type="DEPENDIENTE";}if($driver_type=='2'){$type="INDEPENDIENTE"; $carrier_name="";}if($driver_type=='3'){$type="DEPENDIENTE-INDEPENDIENTE";}
                    
                    if($driver_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$driver_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$driver_id.'"></td>'.
                        '<td>'.$driver_id.$status.'</td>'.
                        '<td>'.$driver_license.'</td>'.    
                        '<td>'.$driver_first_name.' '.$driver_last_name.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&perp; '.$driver_address.'    &phone;'.$driver_phone.'    &bull;'.$driver_date_birth.'    &equiv;'.$driver_dni.'    &nearr;'.$driver_blood_type.'" title="'.$driver_first_name.' '.$driver_last_name.'" data-placement="left"><i class="glyphicon glyphicon-user"/></a></td>'.                            
                        '<td>'.$type.'</td>'.
                        '<td>'.$carrier_name.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$driver_id.'" data-license="'.$driver_license.'" data-fname="'.$driver_first_name.'" data-lname="'.$driver_last_name.'" data-address="'.$driver_address.'" data-phone="'.$driver_phone.'" data-date_birth="'.$driver_date_birth.'" data-dni="'.$driver_dni.'" data-blood_type="'.$driver_blood_type.'" data-type="'.$driver_type.'" data-carrier="'.$carrier_id.'" data-status="'.$driver_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $driver_id = $_POST['id'];
           $driver_license = $_POST['license'];
           $driver_first_name = $_POST['fname'];
           $driver_last_name = $_POST['lname'];
           $driver_address = $_POST['address'];
           $driver_phone = $_POST['phone'];
           $driver_date_birth = $_POST['date_birth'];
           $driver_dni = $_POST['dni'];
           $driver_blood_type = $_POST['blood_type'];
           $driver_type = $_POST['type'];
           $carrier_id = $_POST['carrier'];
           if($_POST['status']=='true'){$driver_status=1;}else{$driver_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_driver (cDriLic, cDriFirNam, cDriLasNam, cDriAdd, cDriPho, cDriDat, cDriDni, cDriBlo, cDriTyp, iCarID, cDriSta) VALUES ('".$driver_license."', '".$driver_first_name."', '".$driver_last_name."', '".$driver_address."', '".$driver_phone."', '".$driver_date_birth."', '".$driver_dni."', '".$driver_blood_type."', '".$driver_type."', '".$carrier_id."', '".$driver_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_driver SET cDriLic='".$driver_license."' , cDriFirNam='".$driver_first_name."', cDriLasNam='".$driver_last_name."', cDriAdd='".$driver_address."', cDriPho='".$driver_phone."', cDriDat='".$driver_date_birth."', cDriDni='".$driver_dni."', cDriBlo='".$driver_blood_type."', cDriTyp='".$driver_type."', iCarID='".$carrier_id."', cDriSta='".$driver_status."' WHERE iDriID='".$driver_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $driver_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_driver WHERE iDriID='".$_id[$i]."'");
               }
           }
        }
    }