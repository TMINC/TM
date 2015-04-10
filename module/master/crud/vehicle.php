<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iVehID, CONCAT(cVehPla,' - ',cVehTuc) AS find FROM tm_vehicle WHERE cVehSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vehicle_id, $vehicle);
            while($row = $stmt->fetch()) {
                if($sel==$vehicle){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$vehicle_id.'" '.$selected.'>'.$vehicle.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            
            if ($stmt = $mysqli->prepare("SELECT iVehID, cVehPla, cVehTuc, vt.iVehTypID, vt.cVehTypInf, vt.cVehTypNam, vc.iVehClaID, vc.cVehClaInf, vc.cVehClaNam, vy.iVehCatID, vy.cVehCatInf, vy.cVehCatNam, cVehWei, iMeaIDWei, cVehLen, iMeaIDLen, cVehWid, iMeaIDWid, cVehHei, iMeaIDHei, cVehSta FROM tm_vehicle AS v, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS vy WHERE v.iVehClaID=vc.iVehClaID AND v.iVehTypID=vt.iVehTypID AND v.iVehCatID=vy.iVehCatID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vehicle_id, $vehicle_plate, $vehicle_tuc, $vehicle_type_id, $vehicle_type_info, $vehicle_type_name, $vehicle_class_id, $vehicle_class_info, $vehicle_class_name, $vehicle_category_id, $vehicle_category_info, $vehicle_category_name, $vehicle_weight, $measure_weight_id, $vehicle_lenght, $measure_lenght_id, $vehicle_width, $measure_width_id, $vehicle_height, $measure_height_id, $vehicle_status);
                while($row = $stmt->fetch()) {
                    $measure_weight = measure_char($measure_weight_id, $mysqli);
                    $measure_lenght = measure_char($measure_lenght_id, $mysqli);
                    $measure_width = measure_char($measure_width_id, $mysqli);
                    $measure_height = measure_char($measure_height_id, $mysqli);
                    
                    if($vehicle_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$vehicle_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$vehicle_id.'"></td>'.
                        '<td>'.$vehicle_id.$status.'</td>'.
                        '<td>'.$vehicle_tuc.'</td>'.                            
                        '<td>'.$vehicle_type_info.'-'.$vehicle_type_name.'</td>'.
                        '<td>'.$vehicle_class_info.'-'.$vehicle_class_name.'</td>'.
                        '<td>'.$vehicle_category_info.'-'.$vehicle_category_name.'</td>'.
                        '<td>'.$vehicle_plate.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="PESO: '.$vehicle_weight.' '.$measure_weight.'. LONGITUD: '.$vehicle_lenght.' '.$measure_lenght.'. ANCHURA: '.$vehicle_width.' '.$measure_width.'. ALTURA: '.$vehicle_height.' '.$measure_height.'." title="'.$vehicle_plate.'" data-placement="left"><i class="glyphicon glyphicon-list"/></a></td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$vehicle_id.'" data-plate="'.$vehicle_plate.'" data-tuc="'.$vehicle_tuc.'" data-type="'.$vehicle_type_id.'" data-class="'.$vehicle_class_id.'" data-category="'.$vehicle_category_id.'" data-weight="'.$vehicle_weight.'" data-measure_weight="'.$measure_weight_id.'" data-lenght="'.$vehicle_lenght.'" data-measure_lenght="'.$measure_lenght_id.'" data-width="' .$vehicle_width.'" data-measure_width="'.$measure_width_id.'" data-height="'.$vehicle_height.'" data-measure_height="'.$measure_height_id.'" data-status="'.$vehicle_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $vehicle_id = $_POST['id'];
           $vehicle_plate = $_POST['plate'];
           $vehicle_tuc = $_POST['tuc'];
           $vehicle_type_id = $_POST['type_id'];
           $vehicle_class_id = $_POST['class_id'];
           $vehicle_category_id = $_POST['category_id'];
           $vehicle_weight = $_POST['weight'];
           $measure_weight_id = $_POST['measure_weight'];
           $vehicle_lenght = $_POST['lenght'];
           $measure_lenght_id = $_POST['measure_lenght'];
           $vehicle_width = $_POST['width'];
           $measure_width_id = $_POST['measure_width'];
           $vehicle_height = $_POST['height'];
           $measure_height_id = $_POST['measure_height'];
           $vehicle_status = $_POST['status'];
           if($_POST['status']=='true'){$vehicle_status=1;}else{$vehicle_status=0;}
           if($action=='insert'){              
               $mysqli->query("INSERT INTO tm_vehicle (cVehPla, cVehTuc, iVehTypID, iVehClaID, iVehCatID, cVehWei, iMeaIDWei, cVehLen, iMeaIDLen, cVehWid, iMeaIDWid, cVehHei, iMeaIDHei, cVehSta) VALUES "
                       . "('".$vehicle_plate."', '".$vehicle_tuc."', '".$vehicle_type_id."', '".$vehicle_class_id."', '".$vehicle_category_id."', '".$vehicle_weight."', '".$measure_weight_id."', '".$vehicle_lenght."', '".$measure_lenght_id."', '".$vehicle_width."', '".$measure_width_id."', '".$vehicle_height."', '".$measure_height_id."', '".$vehicle_status."')");
           } 
           if($action=='update'){ 
               $mysqli->query("UPDATE tm_vehicle SET cVehPla='".$vehicle_plate."', cVehTuc='".$vehicle_tuc."', iVehTypID='".$vehicle_type_id."', iVehClaID='".$vehicle_class_id."', iVehCatID='".$vehicle_category_id."', cVehWei='".$vehicle_weight."', iMeaIDWei='".$measure_weight_id."', cVehLen='".$vehicle_lenght."', iMeaIDLen='".$measure_lenght_id."', cVehWid='".$vehicle_width."', iMeaIDWid='".$measure_width_id."', cVehHei='".$vehicle_height."', iMeaIDHei='".$measure_height_id."', cVehSta='".$vehicle_status."' WHERE iVehID='".$vehicle_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $vehicle_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle WHERE iVehID='".$_id[$i]."'");
               }
           }
        }
    }