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
        if ($stmt = $mysqli->prepare("SELECT iVehClaID, CONCAT(cVehClaInf,' - ',cVehClaNam) AS find FROM tm_vehicle_class WHERE cVehClaSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($type_id, $type);
            while($row = $stmt->fetch()) {
                if($sel==$type){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$type_id.'" '.$selected.'>'.$type.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iVehClaID, cVehClaInf, cVehClaNam, cVehClaDes, cVehClaTyp, cVehClaSta FROM tm_vehicle_class")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($class_id, $class_info, $class_name, $class_description, $class_type, $class_status);
                while($row = $stmt->fetch()) {
                    if($class_type=='1'){$type='R';}if($class_type=='2'){$type='O';}
                    if($class_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-check" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    echo '<tr><td class="center"><input id="c'.$class_id.'" name="row_sel" type="checkbox" class="row_sel" data-id="'.$class_id.'"></td>'.
                        '<td>'.$class_id.$status.'</td>'.
                        '<td>'.$class_info.'</td>'.
                        '<td>'.$class_name.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$class_id.'" data-info="'.$class_info.'" data-name="'.$class_name.'" data-description="'.$class_description.'" data-type="'.$class_type.'" data-status="'.$class_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $class_id = $_POST['id'];
           $class_info = $_POST['info'];
           $class_name = $_POST['name'];
           $class_description = $_POST['description'];
           $class_type = $_POST['type'];
           if($_POST['status']=='true'){$class_status=1;}else{$class_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_vehicle_class (cVehClaInf, cVehClaNam, cVehClaDes, cVehClaTyp, cVehClaSta) VALUES ('".$class_info."', '".$class_name."', '".$class_description."', '".$class_type."', '".$class_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_vehicle_class SET cVehClaInf='".$class_info."' , cVehClaNam='".$class_name."', cVehClaDes='".$class_description."', cVehClaTyp='".$class_type."', cVehClaSta='".$class_status."' WHERE iVehClaID='".$class_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $class_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle_class WHERE iVehClaID='".$_id[$i]."'");
               }
           }
        }
    }