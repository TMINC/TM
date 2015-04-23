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
    $order_detail_id = $_POST['order_detail_id'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT iStaConID, o.iOrdID, od.iOrdDetID, od.iCenIDOri, od.cOrdColDat, od.cOrdColHou, od.iCenIDDes, od.cOrdArrDat, od.cOrdArrHou, od.cOrdVol, od.iMeaIDVol, od.cOrdWei, od.iMeaIDWei, od.cOrdDis, od.iMeaIDDis, cStaConStaCha, cStaConEndCha, cStaConTra, cStaConArrDes, cStaConStaDow, cStaConEndTra, cStaConSta FROM tm_state_control AS sc, tm_order AS o, tm_order_detail AS od WHERE sc.iOrdID=o.iOrdID AND sc.iOrdDetID=od.iOrdDetID ")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($state_control_id, $order_id, $order_detail_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $state_control_start_charging, $state_control_end_charging, $state_control_transit, $state_control_arrival_desdtination, $state_control_start_download, $state_control_end_transportation, $state_control_status);
          
            while($row = $stmt->fetch()) {                 
                $center_origin = center_char($center_origin_id, $mysqli);
                $center_destination = center_char($center_destination_id, $mysqli);
                $measure_volume = measure_char($measure_volume_id, $mysqli);
                $measure_weight = measure_char($measure_weight_id, $mysqli);
                $measure_distance = measure_char($measure_distance_id, $mysqli);
              
                echo '<tr><td>'.$order_detail_id.'<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint ="ORDEN NRO" data-content="'.$order_id.'" title="ORDEN NRO" data-placement="right"><i class="glyphicon glyphicon-comment"/></a></td>'.
                    '<td>'.$center_origin.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Cita" data-content="FECHA: '.$order_origin_date.' HORA: '.$order_origin_hour.'" data-placement="left"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    '<td>'.$center_destination.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Cita" data-content="FECHA: '.$order_destination_date.' HORA: '.$order_destination_hour.'" data-placement="left"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    '<td class="center">'.'<a style="cursor:pointer;" class="edit_data hint--left" data-hint="Datos Transporte" data-detail_id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_id="'.$center_origin_id.'" data-destination_id="'.$center_destination_id.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-note="'.$order_note.'" data-real_price="'.$order_real_price.'"><i class="glyphicon glyphicon-edit" /></a>'.'</td>'.
                    '<td class="center">'.'<a style="cursor:pointer;" class="edit_state hint--left" data-hint="Control de Estados" data-detail_id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_id="'.$center_origin_id.'" data-destination_id="'.$center_destination_id.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-note="'.$order_note.'" data-real_price="'.$order_real_price.'"><i class="glyphicon glyphicon-edit" /></a>'.'</td>';
                    }
                }         
    }else{        
        $center_origin_id = $_POST['origin'];
        $order_origin_date = $_POST['origin_date'];
        $order_origin_hour = $_POST['origin_hour'];
        $center_destination_id = $_POST['destination'];
        $order_destination_date = $_POST['destination_date'];
        $order_destination_hour = $_POST['destination_hour'];
        $order_volume = $_POST['volume']; 
        $measure_volume_id = $_POST['measure_volume']; 
        $order_weight = $_POST['weight'];
        $measure_weight_id = $_POST['measure_weight'];
        $order_distance = $_POST['distance'];
        $measure_distance_id = $_POST['measure_distance'];
        $state_control_start_charging = $_POST['start_charging'];
        $state_control_end_charging = $_POST['end_charging'];
        $state_control_transit = $_POST['transit'];
        $state_control_arrival_desdtination = $_POST['arrival_destination'];
        $state_control_start_download = $_POST['start_download'];
        $state_control_end_transportation = $_POST['end_transportation'];
        if($action=='insert'){
            $mysqli->query("INSERT INTO tm_state_control (iOrdID, iOrdDetID, cStaConStaCha, cStaConEndCha, cStaConTra, cStaConArrDes, cStaConStaDow, cStaConEndTra, cStaConSta) VALUES ('".$order_id."', '".$order_detail_id."', '".$state_control_start_charging."', '".$state_control_end_charging."', '".$state_control_transit."', '".$state_control_arrival_desdtination."', '".$state_control_start_download."', '".$state_control_end_transportation."')");
        } 
        if($action=='update'){
            $mysqli->query("UPDATE tm_state_control SET cStaConStaCha='".$state_control_start_charging."' , cStaConEndCha='".$state_control_end_charging."', cStaConTra='".$state_control_transit."', cStaConArrDes='".$state_control_arrival_desdtination."', cStaConStaDow='".$state_control_start_charging."', cStaConEndTra='".$state_control_end_transportation."' WHERE iStaConID='".$state_control_id."'");   
        }
    }