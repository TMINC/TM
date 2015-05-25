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
        $id = $_POST['id'];
        $field = $_POST['campo'];
        $state_control_start_charging = $_POST['start_charging'];
        $state_control_end_charging = $_POST['end_charging'];
        $state_control_transit = $_POST['transit'];
        $state_control_arrival_destination = $_POST['arrival_destination'];
        $state_control_start_download = $_POST['start_download'];
        $state_control_end_transportation = $_POST['end_transportation'];
        $state_control_rate = $_POST['rate'];
        if($option=='update'){
            echo $field;
            if($field=='chargingStart'){echo "UPDATE tm_state_control SET cStaConStaCha='".$state_control_start_charging."' WHERE iStaConID='".$id."'"; $mysqli->query("UPDATE tm_state_control SET cStaConStaCha='".$state_control_start_charging."' WHERE iStaConID='".$id."'");}
            if($field=='chargingEnd'){$mysqli->query("UPDATE tm_state_control SET cStaConEndCha='".$state_control_end_charging."' WHERE iStaConID='".$id."'");}
            if($field=='transit'){$mysqli->query("UPDATE tm_state_control SET cStaConTra='".$state_control_transit."' WHERE iStaConID='".$id."'");}
            if($field=='arrivalDestination'){$mysqli->query("UPDATE tm_state_control SET cStaConArrDes='".$state_control_arrival_destination."' WHERE iStaConID='".$id."'");}
            if($field=='startDownload'){$mysqli->query("UPDATE tm_state_control SET cStaConStaDow='".$state_control_start_download."' WHERE iStaConID='".$id."'");}
            if($field=='endTransportation'){$mysqli->query("UPDATE tm_state_control SET cStaConEndTra='".$state_control_end_transportation."', iStaConRat='".$state_control_rate."' WHERE iStaConID='".$id."'");}
        }
        if($option=='state'){
            if ($stmt = $mysqli->prepare("SELECT iStaConID, cStaConStaCha, cStaConEndCha, cStaConTra, cStaConArrDes, cStaConStaDow, cStaConEndTra, cStaConSta, iStaConRat FROM tm_state_control WHERE iStaConID='".$id."'")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($state_control_id, $state_control_start_charging, $state_control_end_charging, $state_control_transit, $state_control_arrival_destination, $state_control_start_download, $state_control_end_transportation, $state_control_status, $state_control_rate);
                while($row = $stmt->fetch()) {
                    $cnt=0;
                    if($state_control_start_charging=='0000-00-00 00:00:00'){$cchargingStart='';}else{$cchargingStart='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_end_charging=='0000-00-00 00:00:00'){$cchargingEnd='';}else{$cchargingEnd='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_transit=='0000-00-00 00:00:00'){$ctransit='';}else{$ctransit='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_arrival_destination=='0000-00-00 00:00:00'){$cArrivalDestination='';}else{$cArrivalDestination='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_start_download=='0000-00-00 00:00:00'){$cStartDownload='';}else{$cStartDownload='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_end_transportation=='0000-00-00 00:00:00'){$cEndTransportation='';}else{$cEndTransportation='disabled="disabled" checked="true"';$cnt++;}
                    if($state_control_rate){
                        $rate = char_rate($state_control_rate);
                        if($state_control_rate==0 || $state_control_rate==1){$msg="MUY MALO [".$state_control_rate."]";$hint="error";}
                        if($state_control_rate==2 || $state_control_rate==3){$msg="MALO [".$state_control_rate."]";$hint="warning";}
                        if($state_control_rate==4 || $state_control_rate==5){$msg="REGULAR [".$state_control_rate."]";$hint="warning";}
                        if($state_control_rate==6 || $state_control_rate==7){$msg="BUENO [".$state_control_rate."]";$hint="info";}
                        if($state_control_rate==8 || $state_control_rate==9){$msg="MUY BUENO [".$state_control_rate."]";$hint="success";}
                        if($state_control_rate==10){$msg="EXELENTE [".$state_control_rate."]";$hint="success";}
                        $cnt='9';
                        $show='<td><a style="cursor:pointer;" class="hint--right hint--'.$hint.'" data-hint="'.$msg.'">'.$rate.'</a></td>';
                    }else{
                        $show='<td class="hide" id="td_rate">'.
                            '<select name="rate_sel" id="rate_sel" class="sepH_b">'.
                            '<option value="0">0</option><option value="1">1</option><option value="2">2</option>'.
                            '<option value="3">3</option><option value="4">4</option><option value="5">5</option>'.
                            '<option value="6">6</option><option value="7">7</option><option value="8">8</option>'.
                            '<option value="9">9</option><option value="10">10</option>'.
                            '</select>'.
                        '</td>';
                    }
                    echo '<tr>'.
                            '<td><b>INICIO DE CARGA :</b><input id="cchargingStart" type="checkbox" style="float:right;" '.$cchargingStart.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="chargingStart" class="form-control" readonly="true" type="text" value="'.$state_control_start_charging.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><b>FIN DE CARGA :</b><input id="cchargingEnd" type="checkbox" style="float:right;" '.$cchargingEnd.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="chargingEnd" class="form-control" readonly="true" type="text" value="'.$state_control_end_charging.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><b>EN TR&Aacute;NSITO :</b><input id="ctransit" type="checkbox" style="float:right;" '.$ctransit.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="transit" class="form-control" readonly="true" type="text" value="'.$state_control_transit.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            ' <td><b>LLEGADA DESTINO :</b><input id="cArrivalDestination" type="checkbox" style="float:right;" '.$cArrivalDestination.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="arrivalDestination" class="form-control" readonly="true" type="text" value="'.$state_control_arrival_destination.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><b>INICIO DESCARGA :</b><input id="cStartDownload" type="checkbox" style="float:right;" '.$cStartDownload.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="startDownload" class="form-control" readonly="true" type="text" value="'.$state_control_start_download.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><b>FIN DE TRANSPORTE :</b><input id="cEndTransportation" type="checkbox" style="float:right;" '.$cEndTransportation.' data-id="'.$state_control_id.'"/></td>'.
                            '<td><input id="endTransportation" class="form-control" readonly="true" type="text" value="'.$state_control_end_transportation.'" /></td>'.
                        '</tr>'.
                        '<tr>'.
                            '<td><b>CALIFICACI&Oacute;N SERVICIO:<input class="cnt_control hide" readonly="true" type="text" value="'.$cnt.'" /></b><span class="help-block">min:0, max:10</span></td>'.
                            $show.
                        '</tr>';
                }
            }
        }
    }