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
        if ($stmt = $mysqli->prepare("SELECT iCusID, CONCAT(cCusRuc,' - ',cCusNam) AS find FROM tm_customer WHERE cCusSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($customer_id, $customer);
            while($row = $stmt->fetch()) {
                if($sel==$customer){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$customer_id.'" '.$selected.'>'.$customer.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            echo "SELECT iCusID, cCusNam, cCusRuc, cCusAdd, cCusPhoNam, cCusWebNam, cCusCon, cCusPhoCon, cCusEmaCon, cCusSta FROM tm_customer";
            if ($stmt = $mysqli->prepare("SELECT iCusID, cCusNam, cCusRuc, cCusAdd, cCusPhoNam, cCusWebNam, cCusCon, cCusPhoCon, cCusEmaCon, cCusSta FROM tm_customer")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($customer_id, $customer_name, $customer_ruc, $customer_address, $customer_phone_name, $customer_web_name, $customer_contact, $customer_phone_contact, $customer_email_contact, $customer_status);
                while($row = $stmt->fetch()) {
                    if($customer_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$customer_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$customer_id.'"></td>'.
                        '<td>'.$customer_id.$status.'</td>'.
                        '<td>'.$customer_name.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&perp; '.$customer_address.'    &phone;'.$customer_phone_name.'    &bullet;'.$customer_web_name.'" title="'.$customer_name.'" data-placement="left"><i class="glyphicon glyphicon-briefcase"/></a></td>'.
                        '<td>'.$customer_ruc.'</td>'.
                        '<td>'.$customer_contact.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&phone;'.$customer_phone_contact.'    @&nbsp;'.$customer_email_contact.'" title="'.$customer_contact.'" data-placement="left"><i class="glyphicon glyphicon-user"/></a></td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$customer_id.'" data-name="'.$customer_name.'" data-code="'.$customer_ruc.'" data-address="'.$customer_address.'" data-phone_name="'.$customer_phone_name.'" data-web_name="'.$customer_web_name.'" data-contact="'.$customer_contact.'" data-phone_contact="'.$customer_phone_contact.'" data-email_contact="'.$customer_email_contact.'" data-status="'.$customer_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $customer_id = $_POST['id'];
           $customer_name = $_POST['name'];
           $customer_ruc = $_POST['code'];
           $customer_address = $_POST['address'];
           $customer_phone_name = $_POST['phone_name'];
           $customer_web_name = $_POST['web_name'];
           $customer_contact = $_POST['contact'];
           $customer_phone_contact = $_POST['phone_contact'];
           $customer_email_contact = $_POST['email_contact'];
           if($_POST['status']=='true'){$customer_status=1;}else{$customer_status=0;}
           if($action=='insert'){
           $mysqli->query("INSERT INTO tm_customer (cCusNam, cCusRuc, cCusAdd, cCusPhoNam, cCusWebNam, cCusCon, cCusPhoCon, cCusEmaCon, cCusSta) VALUES ('".$customer_name."', '".$customer_ruc."', '".$customer_address."', '".$customer_phone_name."', '".$customer_web_name."', '".$customer_contact."', '".$customer_phone_contact."', '".$customer_email_contact."', '".$customer_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_customer SET cCusNam='".$customer_name."' , cCusRuc='".$customer_ruc."', cCusAdd='".$customer_address."', cCusPhoNam='".$customer_phone_name."', cCusWebNam='".$customer_web_name."', cCusCon='".$customer_contact."', cCusPhoCon='".$customer_phone_contact."', cCusEmaCon='".$customer_email_contact."', cCusSta='".$customer_status."' WHERE iCusID='".$customer_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $customer_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_customer WHERE iCusID='".$_id[$i]."'");
               }
           }
        }
    }