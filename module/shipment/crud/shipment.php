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
            $option = $_POST['option'];
            if($option=='0'){
                if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, iCusID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdDet, cOrdSta FROM tm_order WHERE cOrdSta>'1'")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($order_id, $order_type, $customer_id, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_detail, $order_status);
                    while($row = $stmt->fetch()) { 
                        $customer = customer_char($customer_id, $mysqli);
                        $measure_volume = measure_char($measure_volume_id, $mysqli);
                        $measure_weight = measure_char($measure_weight_id, $mysqli);
                        $measure_distance = measure_char($measure_distance_id, $mysqli);
                        $measure_price = measure_char($measure_price_id, $mysqli);
                        $measure_real_price = measure_char($measure_real_price_id, $mysqli);
                        $disabled = ' disabled="disabled"';
                        if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                        if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';$disabled = '';}
                        if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';$disabled = '';}
                        if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';$disabled = '';}
                        if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                        if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';$disabled = '';}
                        if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                        if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                        echo '<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$order_id.'"></td>'.
                            '<td><input id="c'.$order_id.'" name="row_sel" type="checkbox" '.$disabled.' class="row_sel uni_style" data-id="'.$order_id.'" data-customer="'.$customer_id.'" data-weight="'.$order_weight.'" data-volume="'.$order_volume.'" data-status="'.$order_status.'"></td>'.
                            '<td>'.$order_id.$status.'</td>'.
                            '<td>'.$customer.'</td>'.
                            '<td>'.$type.'</td>'.  
                            '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                            '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                            '<td>'.$order_distance.' '.$measure_distance.'</td></tr>';
                    }
                }
            }
            
            if($option=='2'){
                if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, iCusID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdDet, cOrdSta FROM tm_order WHERE cOrdSta>3")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($order_id, $order_type, $customer_id, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_detail, $order_status);
                    while($row = $stmt->fetch()) { 
                        $customer = customer_char($customer_id, $mysqli);
                        $measure_volume = measure_char($measure_volume_id, $mysqli);
                        $measure_weight = measure_char($measure_weight_id, $mysqli);
                        $measure_distance = measure_char($measure_distance_id, $mysqli);
                        $measure_price = measure_char($measure_price_id, $mysqli);
                        $measure_real_price = measure_char($measure_real_price_id, $mysqli);

                        if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                        if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                        if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                        if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                        if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                        if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                        echo '<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$order_id.'"></td>'.
                            '<td>'.$order_id.$status.'</td>'.
                            '<td>'.$customer.'</td>'.
                            '<td>'.$type.'</td>'.  
                            '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                            '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                            '<td>'.$order_distance.' '.$measure_distance.'</td></tr>';
                    }
                }
            }
            if($option=='4'){
                if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, iCusID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdAucFla, cOrdSta FROM tm_order WHERE cOrdSta>1")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($order_id, $order_type, $customer_id, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_flag, $order_status);
                    while($row = $stmt->fetch()) { 
                        $customer = customer_char($customer_id, $mysqli);
                        $measure_volume = measure_char($measure_volume_id, $mysqli);
                        $measure_weight = measure_char($measure_weight_id, $mysqli);
                        $measure_distance = measure_char($measure_distance_id, $mysqli);
                        $measure_price = measure_char($measure_price_id, $mysqli);
                        $measure_real_price = measure_char($measure_real_price_id, $mysqli);

                        if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                        if($order_flag=='0'){$flag='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberar"><i class="glyphicon glyphicon-star-empty" /></a>';}
                        if($order_flag=='1'){$flag='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Liberada"><i class="glyphicon glyphicon-star" /></a>';}
                        if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                        if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                        if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                        if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                        if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                        echo '<tr><td><img src="img/details_open.png" style="cursor:pointer;" data-id="'.$order_id.'"></td>'.
                            '<td><input id="c'.$order_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$order_id.'" data-customer="'.$customer_id.'" data-weight="'.$order_weight.'" data-volume="'.$order_volume.'">'.$flag.'</td>'.
                            '<td>'.$order_id.$status.'</td>'.
                            '<td>'.$type.'</td>'.  
                            '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                            '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                            '<td>'.$order_distance.' '.$measure_distance.'</td>'.
                            '<td class="center">'.
                                '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar Subasta" data-id="'.$order_id.'"><i class="glyphicon glyphicon-edit" /></a>'.
                                '<a style="cursor:pointer;margin-left:20px;" class="detail hint--left" data-hint="Ver Ofertas" data-id="'.$order_id.'"><i class="glyphicon glyphicon-search" /></a>'.
                            '</td></tr>';
                    }
                }
            }
            if($option=='5'){
                if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, iCusID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdAucFla, cOrdSta FROM tm_order WHERE cOrdSta>3")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($order_id, $order_type, $customer_id, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_flag, $order_status);
                    while($row = $stmt->fetch()) { 
                        $customer = customer_char($customer_id, $mysqli);
                        $measure_volume = measure_char($measure_volume_id, $mysqli);
                        $measure_weight = measure_char($measure_weight_id, $mysqli);
                        $measure_distance = measure_char($measure_distance_id, $mysqli);
                        $measure_price = measure_char($measure_price_id, $mysqli);
                        $measure_real_price = measure_char($measure_real_price_id, $mysqli);
                        $gps = gps_all($order_id, $mysqli);
                        if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                        if($order_flag=='0'){$flag='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberar"><i class="glyphicon glyphicon-star-empty" /></a>';}
                        if($order_flag=='1'){$flag='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Liberada"><i class="glyphicon glyphicon-star" /></a>';}
                        if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                        if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                        if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                        if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                        if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                        if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                        echo "<tr><td><img src='img/details_open.png' style='cursor:pointer;' data-id='".$order_id."'></td>".
                            "<td>".$flag."</td>".
                            "<td>".$order_id.$status."</td>".
                            "<td>".$customer."</td>". 
                            "<td>".$type." <a class='pop_over hint--left hint--info' data-placement='right' data-content='VOLUMEN: ".$order_volume." ".$measure_volume." PESO: ".$order_weight." ".$measure_weight." DISTANCIA: ".$order_distance." ".$measure_distance."' data-hint='Caracter&iacute;sticas del Servicio' style='cursor:help;float:right;' data-original-title='NRO.ORDEN [".$order_id."]'><i class='glyphicon glyphicon-list-alt'></i></a></td>".  
                            "<td class='center'>".
                                "<a style='cursor:pointer;margin-left:20px;' class='all_signal_gps hint--left' data-hint='Ver todos los veh&iacute;culos' data-id='".$order_id."' data-all_coordinate='".$gps."'><i class='glyphicon glyphicon-search' /></a>".
                            "</td></tr>";
                    }
                }
            }
        }
        if($action=='detail'){
            $order = $_POST['order'];
            if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note);
                while($row = $stmt->fetch()) {                 
                    $center_origin = center_char($center_origin_id, $mysqli);
                    $center_destination = center_char($center_destination_id, $mysqli);
                    $measure_volume = measure_char($measure_volume_id, $mysqli);
                    $measure_weight = measure_char($measure_weight_id, $mysqli); 
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    echo '<tr><td>'.$center_origin.'</td>'.
                        '<td>'.$center_destination.'</td>'.
                        '<td>'.$order_volume.' '.$measure_volume.'</td>'.
                        '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                        '<td>'.$order_distance.' '.$measure_distance.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit_date hint--left" data-hint="Editar Citas" data-id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_id="'.$center_origin_id.'" data-origin_date="'.$order_origin_date.'" data-origin_hour="'.$order_origin_hour.'" data-destination_id="'.$center_destination_id.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-note="'.$order_note.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '</td></tr>';                    
                }
            }
        }
        if($action=='reassign'){
            $order = $_POST['order'];
            if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note);
                while($row = $stmt->fetch()) {                 
                    $center_origin = center_char($center_origin_id, $mysqli);
                    $center_destination = center_char($center_destination_id, $mysqli);
                    $measure_volume = measure_char($measure_volume_id, $mysqli);
                    $measure_weight = measure_char($measure_weight_id, $mysqli); 
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    $vehicle_description = ship_char_extreme($order_detail_id, $mysqli);
                    echo '<tr><td><i class="splashy-arrow_state_blue_right"></i> '.format($order_detail_id).'<a class="pop_over hint--left hint--info" data-placement="right" data-content="<b>VOLUMEN:</b> '.$order_volume.' '.$measure_volume.'<br /><b>PESO: </b>'.$order_weight.' '.$measure_weight.'<br /><b>DISTANCIA: </b>'.$order_distance.' '.$measure_distance.'" data-hint="Caracter&iacute;sticas" style="cursor:help;float:right;" data-original-title="NRO. '.format($order_detail_id).'"><i class="glyphicon glyphicon-list-alt"></i></a></td>'.
                        '<td>'.$center_origin.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$order_origin_date." ".$order_origin_hour.'" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="'.$center_origin.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                        '<td>'.$center_destination.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$order_destination_date." ".$order_destination_hour.'" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="'.$center_destination.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                        $vehicle_description.'</tr>';                    
                }
            }
        }
        if($action=='gps'){
            $order = $_POST['order'];
            if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note);
                $cnt=0;
                while($row = $stmt->fetch()) {                 
                    $center_origin = center_char($center_origin_id, $mysqli);
                    $center_destination = center_char($center_destination_id, $mysqli);
                    $measure_volume = measure_char($measure_volume_id, $mysqli);
                    $measure_weight = measure_char($measure_weight_id, $mysqli); 
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    $gps = gps_table($order_detail_id, $mysqli);
                    echo '<tr><td>'.$order_detail_id.' <a class="pop_over hint--left hint--info" data-placement="right" data-content="VOLUMEN: '.$order_volume.' '.$measure_volume.' PESO: '.$order_weight.' '.$measure_weight.' DISTANCIA: '.$order_distance.' '.$measure_distance.'" data-hint="Caracter&iacute;sticas del Servicio" style="cursor:help;float:right;" data-original-title="NRO.SERVICIO ['.$order_detail_id.']"><i class="glyphicon glyphicon-list-alt"></i></a></td>'.
                        '<td>'.$center_origin.' <a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$order_origin_date.' '.$order_origin_hour.'" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="'.$center_origin.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                        '<td>'.$center_destination.' <a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$order_destination_date.' '.$order_destination_hour.'" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="'.$center_destination.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                        $gps.'</tr>';                  
                }
            }
        }
   }
