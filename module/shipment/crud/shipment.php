<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iOrdID FROM tm_order WHERE cOrdSta='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($order_id);
            while($row = $stmt->fetch()) {
                if($sel==$order_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$order_id.'" '.$selected.'>'.$order_id.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdDet, cOrdSta FROM tm_order WHERE cOrdSta!='0'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_id, $order_type, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_detail, $order_status);
                while($row = $stmt->fetch()) { 
                    $measure_volume = measure_char($measure_volume_id, $mysqli);
                    $measure_weight = measure_char($measure_weight_id, $mysqli);
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    $measure_price = measure_char($measure_price_id, $mysqli);
                    $measure_real_price = measure_char($measure_real_price_id, $mysqli);
                                        
                    if($order_type=='0'){$type='undefined';}else{$type='undefined';}
                    if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                    if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                    if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                    if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                    if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                    echo '<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$order_id.'"></td>'.
                        '<td><input id="c'.$order_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$order_id.'" data-status="'.$order_status.'"></td>'.
                        '<td>'.$order_id.$status.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                        '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                        '<td>'.$order_distance.' '.$measure_distance.'</td>'.
                        '<td>'.$measure_price.' '.$order_price.'</td>'.
                        '<td>'.$measure_real_price.' '.$order_real_price.'</td></tr>';
                }
            }
        }
        if($action=='detail'){
            $order = $_POST['order'];
            if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdDetPri, iMeaIDDetPri, cOrdDetReaPri, iMeaIDDetReaPri, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_note);
                $cnt=0;
                while($row = $stmt->fetch()) {                 
                    $center_origin = center_char($center_origin_id, $mysqli);
                    $center_destination = center_char($center_destination_id, $mysqli);
                    $measure_price = measure_char($measure_price_id, $mysqli);
                    $measure_real_price = measure_char($measure_real_price_id, $mysqli); 
                    $cnt++;
                    echo '<tr><td>'.$center_origin.'</td>'.
                        '<td>'.$center_destination.'</td>'.
                        '<td>'.$measure_price.' '.$order_price.'</td>'.
                        '<td>'.$measure_real_price.' '.$order_real_price.'</td>'.
                        '<td>2500 KM</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit_date hint--left" data-hint="Editar Citas" data-id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_id="'.$center_origin_id.'" data-origin_date="'.$order_origin_date.'" data-origin_hour="'.$order_origin_hour.'" data-destination_id="'.$center_destination_id.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-note="'.$order_note.'" data-real_price="'.$order_real_price.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '</td></tr>';;                    
                }
            }
        }
        if($action=='status'){
            
        }
    }