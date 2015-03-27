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
        if ($stmt = $mysqli->prepare("SELECT iVehTypID, CONCAT(cVehTypInf,' - ',cVehTypNam) AS find FROM tm_vehicle_type WHERE cVehTypSta='1'")){
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
            if ($stmt = $mysqli->prepare("SELECT iVehTypID, cVehTypInf, cVehTypNam, cVehTypDes, cVehTypTyp, cVehTypSta FROM tm_vehicle_type")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($type_id, $type_info, $type_name, $type_description, $type_type, $type_status);
                while($row = $stmt->fetch()) {
                    if($type_type=='1'){$type='R';}if($type_type=='2'){$type='O';}
                    if($type_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td class="center"><input id="c'.$type_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$type_id.'"></td>'.
                        '<td>'.$type_id.$status.'</td>'.
                        '<td>'.$type_info.'</td>'.
                        '<td>'.$type_name.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$type_id.'" data-info="'.$type_info.'" data-name="'.$type_name.'" data-description="'.$type_description.'" data-type="'.$type_type.'" data-status="'.$type_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $type_id = $_POST['id'];
           $type_info = $_POST['info'];
           $type_name = $_POST['name'];
           $type_description = $_POST['description'];
           $type_type = $_POST['type'];
           if($_POST['status']=='true'){$type_status=1;}else{$type_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_vehicle_type (cVehTypInf, cVehTypNam, cVehTypDes, cVehTypTyp, cVehTypSta) VALUES ('".$type_info."', '".$type_name."', '".$type_description."', '".$type_type."', '".$type_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_vehicle_type SET cVehTypInf='".$type_info."' , cVehTypNam='".$type_name."', cVehTypDes='".$type_description."', cVehTypTyp='".$type_type."', cVehTypSta='".$type_status."' WHERE iVehTypID='".$type_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $type_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle_type WHERE iVehTypID='".$_id[$i]."'");
               }
           }
        }
    }