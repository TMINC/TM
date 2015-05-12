<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        if ($stmt = $mysqli->prepare("SELECT iSerTypID, cSerTypNam FROM tm_service_type WHERE cSerTypSta='1'")){
           $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($service_type_id, $service_type_name);
            while($row = $stmt->fetch()) {
                if($sel==$service_type_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$service_type_id.'" '.$selected.'>'.$service_type_name.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iSerTypID, cSerTypNam, cSerTypDes, cSerTypSta FROM tm_service_type")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($service_type_id, $service_type_name, $service_type_description, $service_type_status);
                while($row = $stmt->fetch()) {                   
                    if($service_type_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$service_type_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$service_type_id.'"></td>'.
                        '<td>'.$service_type_id.$status.'</td>'.
                        '<td>'.$service_type_name.'</td>'.
                        '<td>'.$service_type_description.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$service_type_id.'" data-name="'.$service_type_name.'" data-description="'.$service_type_description.'" data-status="'.$service_type_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $service_type_id = $_POST['id'];
           $service_type_name = $_POST['name'];
           $service_type_description = $_POST['description'];
           if($_POST['status']=='true'){$service_type_status=1;}else{$service_type_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_service_type (cSerTypNam, cSerTypDes, cSerTypSta) VALUES ('".$service_type_name."', '".$service_type_description."', '".$service_type_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_service_type SET cSerTypNam='".$service_type_name."' , cSerTypDes='".$service_type_description."', cSerTypSta='".$service_type_status."' WHERE iSerTypID='".$service_type_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $service_type_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_service_type WHERE iSerTypID='".$_id[$i]."'");
               }
           }
        }
    }