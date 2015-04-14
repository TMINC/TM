<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iVehGroID, cVehGroNam FROM tm_vehicle_group WHERE cVehGroSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($group_id, $group_name);
            while($row = $stmt->fetch()) {
                if($sel==$group_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$group_id.'" '.$selected.'>'.$group_name.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iVehGroID, cVehGroNam, cVehGroDes, cVehGroSta FROM tm_vehicle_group")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($group_id, $group_name, $group_designation, $group_status);
                while($row = $stmt->fetch()) {
                    if($group_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td class="center"><input id="c'.$group_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$group_id.'"></td>'.
                        '<td>'.$group_id.$status.'</td>'.
                        '<td>'.$group_name.'</td>'.
                        '<td>'.$group_designation.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$group_id.'" data-name="'.$group_name.'" data-designation="'.$group_designation.'" data-status="'.$group_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $group_id = $_POST['id'];
           $group_name = $_POST['name'];
           $group_designation = $_POST['designation'];
           if($_POST['status']=='true'){$group_status=1;}else{$group_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_vehicle_group (cVehGroNam, cVehGroDes, cVehGroSta) VALUES ('".$group_name."', '".$group_designation."', '".$group_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_vehicle_group SET cVehGroNam='".$group_name."' , cVehGroDes='".$group_designation."', cVehGroSta='".$group_status."' WHERE iVehGroID='".$group_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $group_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle_group WHERE iVehGroID='".$_id[$i]."'");
               }
           }
        }
    }