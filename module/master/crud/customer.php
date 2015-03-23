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
        if ($stmt = $mysqli->prepare("SELECT iCusID, CONCAT(cCusRuc,' - ',cCusDes) AS find FROM tm_customer WHERE cCusSta='1'")){
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
            if ($stmt = $mysqli->prepare("SELECT iCusID, cCusNam, cCusRuc, cCusDes, cCusSta FROM tm_customer")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($customer_id, $customer_name, $customer_ruc, $customer_description, $customer_status);
                while($row = $stmt->fetch()) {
                    if($customer_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-check" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    echo '<tr><td><input id="c'.$customer_id.'" name="row_sel" type="checkbox" class="row_sel" data-id="'.$customer_id.'"></td>'.
                        '<td>'.$customer_id.$status.'</td>'.
                        '<td>'.$customer_name.'</td>'.
                        '<td>'.$customer_ruc.'</td>'.
                        '<td>'.$customer_description.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$customer_id.'" data-name="'.$customer_name.'" data-code="'.$customer_ruc.'" data-description="'.$customer_description.'" data-status="'.$customer_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $customer_id = $_POST['id'];
           $customer_name = $_POST['name'];
           $customer_ruc = $_POST['code'];
           $customer_description = $_POST['description'];
           if($_POST['status']=='true'){$customer_status=1;}else{$customer_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_customer (cCusNam, cCusRuc, cCusDes, cCusSta) VALUES ('".$customer_name."', '".$customer_ruc."', '".$customer_description."', '".$customer_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_customer SET cCusNam='".$customer_name."' , cCusRuc='".$customer_ruc."', cCusDes='".$customer_description."', cCusSta='".$customer_status."' WHERE iCusID='".$customer_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $customer_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_customer WHERE iCusID='".$_id[$i]."'");
               }
           }
        }
    }