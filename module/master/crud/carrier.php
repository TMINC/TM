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
        if ($stmt = $mysqli->prepare("SELECT iCarID, CONCAT(cCarRuc,' - ',cCarNam) AS find FROM tm_carrier WHERE cCarSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($carrier_id, $carrier);
            while($row = $stmt->fetch()) {
                if($sel==$carrier){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$carrier_id.'" '.$selected.'>'.$carrier.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iCarID, cCarNam, cCarRuc, cCarAge, cCarPho, cCarEma, cCarSta FROM tm_carrier")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($carrier_id, $carrier_name, $carrier_ruc, $carrier_agent, $carrier_phone, $carrier_email, $carrier_status);
                while($row = $stmt->fetch()) {
                    if($carrier_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$carrier_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$carrier_id.'"></td>'.
                        '<td>'.$carrier_id.$status.'</td>'.
                        '<td>'.$carrier_name.'</td>'.
                        '<td>'.$carrier_ruc.'</td>'.
                        '<td>'.$carrier_agent.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&phone; '.$carrier_phone.'    @&nbsp;'.$carrier_email.'" title="'.$carrier_agent.'" data-placement="left"><i class="glyphicon glyphicon-user"/></a></td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$carrier_id.'" data-name="'.$carrier_name.'" data-code="'.$carrier_ruc.'" data-agent="'.$carrier_agent.'" data-phone="'.$carrier_phone.'" data-email="'.$carrier_email.'" data-status="'.$carrier_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $carrier_id = $_POST['id'];
           $carrier_name = $_POST['name'];
           $carrier_ruc = $_POST['code'];
           $carrier_agent = $_POST['agent'];
           $carrier_phone = $_POST['phone'];
           $carrier_email = $_POST['email'];
           if($_POST['status']=='true'){$carrier_status=1;}else{$carrier_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_carrier (cCarNam, cCarRuc, cCarAge, cCarPho, cCarEma, cCarSta) VALUES ('".$carrier_name."', '".$carrier_ruc."', '".$carrier_agent."', '".$carrier_phone."', '".$carrier_email."', '".$carrier_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_carrier SET cCarNam='".$carrier_name."' , cCarRuc='".$carrier_ruc."', cCarAge='".$carrier_agent."', cCarPho='".$carrier_phone."', cCarEma='".$carrier_email."', cCarSta='".$carrier_status."' WHERE iCarID='".$carrier_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $carrier_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_carrier WHERE iCarID='".$_id[$i]."'");
               }
           }
        }
    }