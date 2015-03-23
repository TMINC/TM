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
        if ($stmt = $mysqli->prepare("SELECT iVehCatID, CONCAT(cVehCatInf,' - ',cVehCatNam) AS find FROM tm_vehicle_category WHERE cVehCatSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($category_id, $category);
            while($row = $stmt->fetch()) {
                if($sel==$category){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$category_id.'" '.$selected.'>'.$category.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iVehCatID, cVehCatInf, cVehCatNam, cVehCatDes, cVehCatSta FROM tm_vehicle_category")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($category_id, $category_info, $category_name, $category_description, $category_status);
                while($row = $stmt->fetch()) {
                    if($category_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-check" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    echo '<tr><td class="center"><input id="c'.$category_id.'" name="row_sel" type="checkbox" class="row_sel" data-id="'.$category_id.'"></td>'.
                        '<td>'.$category_id.$status.'</td>'.
                        '<td>'.$category_info.'</td>'.
                        '<td>'.$category_name.'</td>'.
                        '<td>'.$category_description.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$category_id.'" data-info="'.$category_info.'" data-name="'.$category_name.'" data-description="'.$category_description.'" data-status="'.$category_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $category_id = $_POST['id'];
           $category_info = $_POST['info'];
           $category_name = $_POST['name'];
           $category_description = $_POST['description'];
           if($_POST['status']=='true'){$category_status=1;}else{$category_status=0;}
           if($action=='insert'){
               $mysqli->query("INSERT INTO tm_vehicle_category (cVehCatInf, cVehCatNam, cVehCatDes, cVehCatSta) VALUES ('".$category_info."', '".$category_name."', '".$category_description."', '".$category_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_vehicle_category SET cVehCatInf='".$category_info."' , cVehCatNam='".$category_name."', cVehCatDes='".$category_description."', cVehCatSta='".$category_status."' WHERE iVehCatID='".$category_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $category_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle_category WHERE iVehCatID='".$_id[$i]."'");
               }
           }
        }
    }