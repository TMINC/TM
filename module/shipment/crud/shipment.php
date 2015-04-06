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
                    if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($order_status=='1'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                    if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                    if($order_status=='3'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                    if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                    if($order_status=='5'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                    echo '<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$order_id.'"></td>'.
                        '<td><input id="c'.$order_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$order_id.'"></td>'.
                        '<td>'.$order_id.$status.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                        '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                        '<td>'.$order_distance.' '.$measure_distance.'</td>'.
                        '<td>'.$measure_price.' '.$order_price.'</td>'.
                        '<td>'.$measure_real_price.' '.$order_real_price.'</td></tr>';
                }
            }
        }else{
            $order_id = $_POST['id'];
            $order_status = $_POST['status'];
            if($action=='status'){
                $mysqli->query("UPDATE tm_order SET cOrdSta='".$order_status."' WHERE iOrdID='".$order_id."'");
            }
        }
    }