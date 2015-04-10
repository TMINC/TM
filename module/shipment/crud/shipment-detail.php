<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel SIlva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdDetPri, iMeaIDDetPri, cOrdDetReaPri, iMeaIDDetReaPri, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order_id)){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_note);
            while($row = $stmt->fetch()) {                       
                echo '<tr><td><input id="c'.$order_detail_id.'" name="row_sel_detail" type="checkbox" class="row_sel_detail uni_style" data-id="'.$order_detail_id.'" ></td>'.
                    '<td>'.$order_origin_date.'</td>'.                            
                    '<td>'.$order_origin_hour.'</td>'.
                     '<td>'.$order_destination_date.'</td>'.                            
                    '<td>'.$order_destination_hour.'</td>'.
                    '<td class="center">'.
                        '<a style="cursor:pointer;" class="edit_date hint--left" data-hint="Editar" data-detail_id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_date="'.$order_origin_date.'" data-origin_hour="'.$order_origin_hour.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'"><i class="glyphicon glyphicon-edit" /></a>'.
                    '</td></tr>';
            }
        }
    }else{        
        $order_detail_id = $_POST['date_id'];
        $order_origin_date = $_POST['origin_date']; 
        $order_origin_hour = $_POST['origin_hour'];
        $order_destination_date = $_POST['destination_date'];
        $order_destination_hour = $_POST['destination_hour'];        
        if($action=='update'){
            $mysqli->query("UPDATE tm_order_detail SET cOrdColDat='".$order_origin_date."', cOrdColHou='".$order_origin_hour."', cOrdArrDat='".$order_destination_date."', cOrdArrHou='".$order_destination_hour."' WHERE iOrdDetID='".date_id."'");                         
        }        
    }