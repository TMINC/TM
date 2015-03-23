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
            if ($stmt = $mysqli->prepare("SELECT iDriID, c.iCarID, c.cCarNam, cDriLic, cDriFirNam, cDriLasNam, cDriTyp, cDriSta FROM tm_driver AS d, tm_carrier AS c WHERE d.iCarID=c.iCarID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($driver_id, $carrier_id, $carrier_name, $driver_license, $driver_first_name, $driver_last_name, $driver_type, $driver_status);
                while($row = $stmt->fetch()) {
                    if($driver_type=='1'){$type="DEPENDIENTE";}if($driver_type=='2'){$type="INDEPENDIENTE";}if($driver_type=='3'){$type="DEPENDIENTE-INDEPENDIENTE";}
                    if($driver_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-check" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    echo '<tr><td><input id="c'.$driver_id.'" name="row_sel" type="checkbox" class="row_sel" data-id="'.$driver_id.'"></td>'.
                        '<td>'.$driver_id.$status.'</td>'.
                        '<td>'.$driver_license.'</td>'.    
                        '<td>'.$driver_first_name.' '.$driver_last_name.'</td>'.                            
                        '<td>'.$carrier_name.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$driver_id.'" data-carrier="'.$carrier_id.'" data-license="'.$driver_license.'" data-fname="'.$driver_first_name.'" data-lname="'.$driver_last_name.'" data-type="'.$driver_type.'" data-status="'.$driver_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $driver_id = $_POST['id'];
           $carrier_id = $_POST['carrier'];
           $driver_license = $_POST['license'];
           $driver_first_name = $_POST['fname'];
           $driver_last_name = $_POST['lname'];
           $driver_type = $_POST['type'];
           if($_POST['status']=='true'){$driver_status=1;}else{$driver_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_driver (iCarID, cDriLic, cDriFirNam, cDriLasNam, cDriTyp, cDriSta) VALUES ('".$carrier_id."', '".$driver_license."', '".$driver_first_name."', '".$driver_last_name."', '".$driver_type."', '".$driver_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_driver SET iCarID='".$carrier_id."', cDriLic='".$driver_license."' , cDriFirNam='".$driver_first_name."', cDriLasNam='".$driver_last_name."', cDriTyp='".$driver_type."', cDriSta='".$driver_status."' WHERE iDriID='".$driver_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $customer_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_driver WHERE iDriID='".$_id[$i]."'");
               }
           }
        }
    }