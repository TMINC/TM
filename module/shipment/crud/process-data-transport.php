<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 * Rv: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
     
    $option = $_POST['action'];
    if($option=='select'){
        if ($stmt = $mysqli->prepare("SELECT DISTINCT(d.iOrdDetID), d.cOrdDetFla, o.iOrdID, o.cOrdSta, o.iSerTypID, d.iCenIDOri, d.cOrdColDat, d.cOrdColHou, d.iCenIDDes, d.cOrdArrDat, d.cOrdArrHou, d.cOrdVol, d.iMeaIDVol, d.cOrdWei, d.iMeaIDWei, d.cOrdDis, d.iMeaIDDis, d.cOrdDetNot FROM tm_state_control AS s, tm_order_detail AS d, tm_order AS o WHERE s.iOrdDetID=d.iOrdDetID AND s.iOrdID=o.iOrdID")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($order_detail_id, $order_detail_flag, $order_id, $order_status, $order_type, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note);
            while($row = $stmt->fetch()) { 
                $center_origin = center_char($center_origin_id, $mysqli);
                $center_type = center_type_char($center_origin_id, $mysqli);if($center_type==1){$center_type_origin="CENTRO DE ACOPIO";}if($center_type==2){$center_type_origin="PLANTA";}if($center_type==3){$center_type_origin="PUERTO DESTINO";}
                $center_destination = center_char($center_destination_id, $mysqli);
                $center_type = center_type_char($center_destination_id, $mysqli);if($center_type==1){$center_type_destination="CENTRO DE ACOPIO";}if($center_type==2){$center_type_destination="PLANTA";}if($center_type==3){$center_type_destination="PUERTO DESTINO";}
                $measure_volume = measure_char($measure_volume_id, $mysqli);
                $measure_weight = measure_char($measure_weight_id, $mysqli); 
                $measure_distance = measure_char($measure_distance_id, $mysqli);
                $type = service_type_char($order_type, $mysqli);

                //if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                echo '<tr><td>'.format($order_detail_id).'<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Nota" data-content="'.$order_note.'" title="NOTA" data-placement="right"><i class="glyphicon glyphicon-comment"/></a><br /><span class="help-block" style="font-size:8px;"><b>REF.ORDEN: </b>'.$order_id.'</span></td>'.
                    '<td>'.$type.'<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Caracter&iacute;sticas" data-content="VOLUMEN: '.$order_volume.' '.$measure_volume.'. <br />PESO: '.$order_weight.' '.$measure_weight.'. <br />DISTANCIA APROX.: '.$order_distance.' '.$measure_distance.'" title="CARACTER&Iacute;STICAS" data-placement="right"><i class="glyphicon glyphicon-list-alt"/></a>'.
                    '<td><div style="float:left;">'.$center_origin.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_origin.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Cita Recojo" data-content="'.$order_origin_date.' '.$order_origin_hour.'" title="'.$center_origin.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.                            
                    '<td><div style="float:left;">'.$center_destination.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_destination.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Cita Llegada" data-content="'.$order_destination_date.' '.$order_destination_hour.'" title="'.$center_destination.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    ship_char_full($order_detail_id, $mysqli).'</tr>';
            }
        }         
    }else{        
        $allocation = $_POST['id'];
        $vehicle = $_POST['vehicle'];
        $vehicle_aditional = $_POST['vehicle_aditional'];
        $driver = $_POST['driver'];
        $imei = $_POST['imei'];
        if($option=='insert'){
            $mysqli->query("INSERT INTO tm_order_detail_assign (iAllTraDetID, iDriID, iVehID, iVehAdiID, cOrdDetAssIMEI) VALUES ('".$allocation."', '".$driver."', '".$vehicle."', '".$vehicle_aditional."', '".$imei."')");
        } 
        if($option=='update'){
            $mysqli->query("UPDATE tm_order_detail_assign SET iDriID='".$driver."', iVehID='".$vehicle."', iVehAdiID='".$vehicle_aditional."', cOrdDetAssIMEI='".$imei."' WHERE iAllTraDetID='".$allocation."'");   
        }
        if($option=='state'){
            $id = $_POST['id'];
            if ($stmt = $mysqli->prepare("SELECT cStaConStaCha, cStaConEndCha, cStaConTra, cStaConArrDes, cStaConStaDow, cStaConEndTra, cStaConSta, iStaConRat FROM tm_state_control WHERE iStaConID='".$id."'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($state_control_start_charging, $state_control_end_charging, $state_control_transit, $state_control_arrival_destination, $state_control_start_download, $state_control_end_transportation, $state_control_status, $state_control_rate);
                while($row = $stmt->fetch()) {
                    $rate = char_rate($state_control_rate);
                    if($state_control_rate==0 || $state_control_rate==1){$msg="MUY MALO";$hint="error";}
                    if($state_control_rate==2 || $state_control_rate==3){$msg="MALO";$hint="warning";}
                    if($state_control_rate==4 || $state_control_rate==5){$msg="REGULAR";$hint="warning";}
                    if($state_control_rate==6 || $state_control_rate==7){$msg="BUENO";$hint="info";}
                    if($state_control_rate==8 || $state_control_rate==9){$msg="MUY BUENO";$hint="success";}
                    if($state_control_rate==10){$msg="EXELENTE";$hint="success";}
                    echo '<tr class="centerStart">'.
                            '<td><b>INICIO DE CARGA :</b></td>'.
                            '<td><input id="chargingStart" class="form-control" readonly="true" type="text" value="'.$state_control_start_charging.'" /></td>'.
                        '</tr>'.
                        '<tr class="centerStart">'.
                            '<td><b>FIN DE CARGA :</b></td>'.
                            '<td><input id="chargingEnd" class="form-control" readonly="true" type="text" value="'.$state_control_end_charging.'" /></td>'.
                        '</tr>'.
                        '<tr class="centerStart">'.
                            '<td><b>EN TR&Aacute;NSITO :</b></td>'.
                            '<td><input id="transit" class="form-control" readonly="true" type="text" value="'.$state_control_transit.'" /></td>'.
                        '</tr>'.
                        '<tr class="centerEnd">'.
                            ' <td><b>LLEGADA DESTINO :</b></td>'.
                            '<td><input id="ArrivalDestination" class="form-control" readonly="true" type="text" value="'.$state_control_arrival_destination.'" /></td>'.
                        '</tr>'.
                        '<tr class="centerEnd">'.
                            '<td><b>INICIO DESCARGA :</b></td>'.
                            '<td><input id="StartDownload" class="form-control" readonly="true" type="text" value="'.$state_control_start_download.'" /></td>'.
                        '</tr>'.
                            '<tr class="centerEnd">'.
                            '<td><b>FIN DE TRANSPORTE :</b></td>'.
                            '<td><input id="EndTransportation" class="form-control" readonly="true" type="text" value="'.$state_control_end_transportation.'" /></td>'.
                        '</tr>'.
                        '<tr class="centerEnd">'.
                            '<td><b>CALIFICACI&Oacute;N :</b></td>'.
                            '<td><a style="cursor:pointer;" class="hint--right hint--'.$hint.'" data-hint="'.$msg.'">'.$rate.'</a></td>'.
                        '</tr>';
                }
            }
        }
    }
    