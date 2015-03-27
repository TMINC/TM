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
        if ($stmt = $mysqli->prepare("SELECT iVehID, cVehPla FROM tm_vehicle WHERE cVehSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($vehicle_id, $vehicle_plate);
            while($row = $stmt->fetch()) {
                if($sel==$vehicle_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$vehicle_id.'" '.$selected.'>'.$vehicle_plate.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iVehID, cVehPla, cVehGen, vt.iVehTypID, vt.cVehTypInf, vt.cVehTypNam, vc.iVehClaID, vc.cVehClaInf, vc.cVehClaNam, cVehWei, vy.iVehCatID, vy.cVehCatInf, vy.cVehCatNam, iMeaIDWei, cVehLen, cVehWid, cVehHei, iMeaIDHei, cVehSta FROM tm_vehicle AS v, tm_vehicle_class AS vc, tm_vehicle_type AS vt, tm_vehicle_category AS vy WHERE v.iVehClaID=vc.iVehClaID AND v.iVehTypID=vt.iVehTypID AND v.iVehCatID=vy.iVehCatID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($vehicle_id, $vehicle_plate, $vehicle_genre, $vehicle_type_id, $vehicle_type_info, $vehicle_type_name, $vehicle_class_id, $vehicle_class_info, $vehicle_class_name, $vehicle_weight, $vehicle_category_id, $vehicle_category_info, $vehicle_category_name, $vehicle_measure_weight, $vehicle_length, $vehicle_width, $vehicle_height, $vehicle_measure_height, $vehicle_status);
                while($row = $stmt->fetch()) {
                    $iMeaIDWei = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDWei->bind_param('s', $vehicle_measure_weight);
                    $iMeaIDWei->execute();
                    $iMeaIDWei->store_result();
                    $iMeaIDWei->bind_result($measure_weight);
                    $iMeaIDWei->fetch();
                    
                    $iMeaIDHei = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDHei->bind_param('s', $vehicle_measure_height);
                    $iMeaIDHei->execute();
                    $iMeaIDHei->store_result();
                    $iMeaIDHei->bind_result($measure_height);
                    $iMeaIDHei->fetch();
                    if($vehicle_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$vehicle_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$vehicle_id.'"></td>'.
                        '<td>'.$vehicle_id.$status.'</td>'.
                        '<td>'.$vehicle_plate.'</td>'.                            
                        '<td>'.$vehicle_type_info.'-'.$vehicle_type_name.'</td>'.
                        '<td>'.$vehicle_class_info.'-'.$vehicle_class_name.'</td>'.
                        '<td>'.$vehicle_category_info.'-'.$vehicle_category_name.'</td>'.
                        '<td>'.$vehicle_genre.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="PESO: '.$vehicle_weight.' '.$measure_weight.'. LONGITUD: '.$vehicle_length.' '.$measure_height.'. ANCHURA: '.$vehicle_width.' '.$measure_height.'. ALTURA: '.$vehicle_height.' '.$measure_height.'." title="'.$vehicle_plate.'" data-placement="left"><i class="glyphicon glyphicon-list"/></a></td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$vehicle_id.'" data-plate="'.$vehicle_plate.'" data-genre="'.$vehicle_genre.'" data-type="'.$vehicle_type_id.'" data-class="'.$vehicle_class_id.'" data-weight="'.$vehicle_weight.'" data-category="'.$vehicle_category_id.'" data-measure_weight="'.$vehicle_measure_weight.'" data-length="'.$vehicle_length.'" data-width="' .$vehicle_width.'" data-height="'.$vehicle_height.'" data-measure_height="'.$vehicle_measure_height.'" data-status="'.$vehicle_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $vehicle_id = $_POST['id'];
           $vehicle_plate = $_POST['plate'];
           $vehicle_genre = $_POST['genre'];
           $vehicle_type_id = $_POST['type_id'];
           $vehicle_class_id = $_POST['class_id'];
           $vehicle_weight = $_POST['weight'];
           $vehicle_category_id = $_POST['category_id'];
           $vehicle_measure_weight = $_POST['measure_weight'];
           $vehicle_length = $_POST['length'];
           $vehicle_width = $_POST['width'];
           $vehicle_height = $_POST['height'];
           $vehicle_measure_height = $_POST['measure_height'];
           $vehicle_status = $_POST['status'];
           if($_POST['status']=='true'){$vehicle_status=1;}else{$vehicle_status=0;}
           if($action=='insert'){
               echo "INSERT INTO tm_vehicle (cVehPla, cVehGen, iVehTypID, iVehClaID, cVehWei, iVehCatID, 1MeaIDWei, cVehLen, cVehWid, cVehHei, iMeaIDHei, cVehSta) VALUES "
                       . "('".$vehicle_plate."', '".$vehicle_genre."', '".$vehicle_type_id."', '".$vehicle_class_id."', '".$vehicle_weight."', '".$vehicle_category_id."' '".$vehicle_measure_weight."', '".$vehicle_length."', '".$vehicle_width."', '".$vehicle_height."', '".$vehicle_measure_height."', '".$vehicle_status."')";
               $mysqli->query("INSERT INTO tm_vehicle (cVehPla, cVehGen, iVehTypID, iVehClaID, cVehWei, iVehCatID, iMeaIDWei, cVehLen, cVehWid, cVehHei, iMeaIDHei, cVehSta) VALUES "
                       . "('".$vehicle_plate."', '".$vehicle_genre."', '".$vehicle_type_id."', '".$vehicle_class_id."', '".$vehicle_weight."', '".$vehicle_category_id."', '".$vehicle_measure_weight."', '".$vehicle_length."', '".$vehicle_width."', '".$vehicle_height."', '".$vehicle_measure_height."', '".$vehicle_status."')");
           } 
           if($action=='update'){
               echo "UPDATE tm_vehicle SET cVehPla='".$vehicle_plate."' , cVehGen='".$vehicle_genre."', iVehTypID='".$vehicle_type_id."', iVehClaID='".$vehicle_class_id."', cVehWei='".$vehicle_weight."', iVehCatID='".$vehicle_category_id."' iMeaIDWei='".$vehicle_measure_weight."', cVehLen='".$vehicle_length."', cVehWid='".$vehicle_width."', cVehHei='".$vehicle_height."', iMeaIDHei='".$vehicle_measure_height."', cVehSta='".$vehicle_status."' WHERE iVehID='".$vehicle_id."'";
               $mysqli->query("UPDATE tm_vehicle SET cVehPla='".$vehicle_plate."', cVehGen='".$vehicle_genre."', iVehTypID='".$vehicle_type_id."', iVehClaID='".$vehicle_class_id."', cVehWei='".$vehicle_weight."', iVehCatID='".$vehicle_category_id."', iMeaIDWei='".$vehicle_measure_weight."', cVehLen='".$vehicle_length."', cVehWid='".$vehicle_width."', cVehHei='".$vehicle_height."', iMeaIDHei='".$vehicle_measure_height."', cVehSta='".$vehicle_status."' WHERE iVehID='".$vehicle_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $vehicle_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_vehicle WHERE iVehID='".$_id[$i]."'");
               }
           }
        }
    }