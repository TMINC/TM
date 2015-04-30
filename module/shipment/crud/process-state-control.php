<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
     
    $option = $_POST['action'];
    if($option=='select'){
        if ($stmt = $mysqli->prepare("SELECT DISTINCT(d.iOrdDetID), d.cOrdDetFla, o.iOrdID, o.cOrdSta, o.iOrdTyp, d.iCenIDOri, d.cOrdColDat, d.cOrdColHou, d.iCenIDDes, d.cOrdArrDat, d.cOrdArrHou, d.cOrdVol, d.iMeaIDVol, d.cOrdWei, d.iMeaIDWei, d.cOrdDis, d.iMeaIDDis, d.cOrdDetNot,cStaConStaCha, cStaConEndCha, cStaConTra, cStaConArrDes, cStaConStaDow, cStaConEndTra, cStaConSta FROM tm_state_control AS s, tm_order_detail AS d, tm_order AS o WHERE s.iOrdDetID=d.iOrdDetID AND s.iOrdID=o.iOrdID")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($order_detail_id, $order_detail_flag, $order_id, $order_status, $order_type, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note, $state_control_start_charging, $state_control_end_charging, $state_control_transit, $state_control_arrival_desdtination, $state_control_start_download, $state_control_end_transportation, $state_control_status);
            while($row = $stmt->fetch()) { 
                $center_origin = center_char($center_origin_id, $mysqli);
                $center_type = center_type_char($center_origin_id, $mysqli);if($center_type==1){$center_type_origin="CENTRO DE ACOPIO";}if($center_type==2){$center_type_origin="PLANTA";}if($center_type==3){$center_type_origin="PUERTO DESTINO";}
                $center_destination = center_char($center_destination_id, $mysqli);
                $center_type = center_type_char($center_destination_id, $mysqli);if($center_type==1){$center_type_destination="CENTRO DE ACOPIO";}if($center_type==2){$center_type_destination="PLANTA";}if($center_type==3){$center_type_destination="PUERTO DESTINO";}
                $measure_volume = measure_char($measure_volume_id, $mysqli);
                $measure_weight = measure_char($measure_weight_id, $mysqli); 
                $measure_distance = measure_char($measure_distance_id, $mysqli);

                if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                echo '<tr><td>'.format($order_detail_id).'<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Nota" data-content="'.$order_note.'" title="NOTA" data-placement="right"><i class="glyphicon glyphicon-comment"/></a><br /><span class="help-block" style="font-size:8px;"><b>REF.ORDEN: </b>'.$order_id.'</span></td>'.
                    '<td>'.$type.'<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Caracter&iacute;sticas" data-content="VOLUMEN: '.$order_volume.' '.$measure_volume.'. <br />PESO: '.$order_weight.' '.$measure_weight.'. <br />DISTANCIA APROX.: '.$order_distance.' '.$measure_distance.'" title="CARACTER&Iacute;STICAS" data-placement="right"><i class="glyphicon glyphicon-list-alt"/></a>'.
                    '<td><div style="float:left;">'.$center_origin.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_origin.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Cita Recojo" data-content="'.$order_origin_date.' '.$order_origin_hour.'" title="'.$center_origin.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.                            
                    '<td><div style="float:left;">'.$center_destination.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_destination.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Cita Llegada" data-content="'.$order_destination_date.' '.$order_destination_hour.'" title="'.$center_destination.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    ship_char_full($order_detail_id, $mysqli).'</tr>';
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