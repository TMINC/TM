<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
     
    $option = $_POST['action'];
    if($option=='select'){
        if ($stmt = $mysqli->prepare("SELECT d.iOrdDetID, d.cOrdDetFla, o.iOrdID, o.cOrdSta, o.iOrdTyp, d.iCenIDOri, d.cOrdColDat, d.cOrdColHou, d.iCenIDDes, d.cOrdArrDat, d.cOrdArrHou, d.cOrdVol, d.iMeaIDVol, d.cOrdWei, d.iMeaIDWei, d.cOrdDis, d.iMeaIDDis, d.cOrdDetNot, atd.cAllTraDetCarrID FROM tm_order_detail AS d, tm_order AS o, tm_allocation_transport_detail AS atd WHERE d.iOrdID=o.iOrdID AND atd.cAllTraDetOrdDet=d.iOrdDetID AND atd.cAllTraDetAdjTyp='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($order_detail_id, $order_detail_flag, $order_id, $order_status, $order_type, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note, $participants);
            while($row = $stmt->fetch()) { 
                $center_origin = center_char($center_origin_id, $mysqli);
                $center_type = center_type_char($center_origin_id, $mysqli);if($center_type==1){$center_type_origin="CENTRO DE ACOPIO";}if($center_type==2){$center_type_origin="PLANTA";}if($center_type==3){$center_type_origin="PUERTO DESTINO";}
                $center_destination = center_char($center_destination_id, $mysqli);
                $center_type = center_type_char($center_destination_id, $mysqli);if($center_type==1){$center_type_destination="CENTRO DE ACOPIO";}if($center_type==2){$center_type_destination="PLANTA";}if($center_type==3){$center_type_destination="PUERTO DESTINO";}
                $measure_volume = measure_char($measure_volume_id, $mysqli);
                $measure_weight = measure_char($measure_weight_id, $mysqli); 
                $measure_distance = measure_char($measure_distance_id, $mysqli);
                $vehicle = ship_char_extreme_auction($order_detail_id, $mysqli);
                if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                if($order_status=='3'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;margin-left:5px;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                if($order_detail_flag=='1'){$flag='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Liberada"><i class="glyphicon glyphicon-flag" /></a>';}
                else{$flag='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberar"><i class="glyphicon glyphicon-lock" /></a>';}
                echo '<tr><td><input name="row_sel" type="checkbox" class="row_sel" data-id="'.$order_detail_id.'"></td>'.
                    '<td>'.format($order_detail_id).$status.$flag.'<br /><span class="help-block" style="font-size:8px;"><b>REF.ORDEN: </b>'.$order_id.'</span></td>'.
                    '<td>'.
                        '<div class="formSep">'.$type.
                            '<a style="cursor:help;float:right; margin-left:10px;" class="pop_over hint--left hint--info" data-hint="Caracter&iacute;sticas" data-content="<b>VOLUMEN:</b> '.$order_volume.' '.$measure_volume.'. <br /><b>PESO:</b> '.$order_weight.' '.$measure_weight.'. <br /><b>DISTANCIA APROX.:</b> '.$order_distance.' '.$measure_distance.'" title="CARACTER&Iacute;STICAS" data-placement="right"><i class="glyphicon glyphicon-list-alt"></i></a>'.
                            '<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Información Adicional" data-content="" title="INFO ADICIONAL" data-placement="right"><i class="glyphicon glyphicon-exclamation-sign"/></a>'.
                        '</div>'.
                        '<div class="formSep"><small class="s_color sl_email">'.$vehicle.'</small></div>'.
                        '<div style="float:right;margin-top:-8px;"><a style="cursor:help;" class="hint--left hint--info" data-hint="Finalizaci&oacute;n Subasta"><i class="glyphicon glyphicon-time"></i></a> <div id="countdown" class="label label-info">2d 5h 35m 10s</div></div>'.
                        '<script>$("#countdown").countdown({until: new Date(2015, 5 - 1, 20, 10, 30, 0),format: "DHMS"});</script></td>'.  
                    '<td><div style="float:left;">'.$center_origin.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_origin.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Origen" data-content="'.$order_origin_date.' '.$order_origin_hour.'" title="'.$center_origin.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.                            
                    '<td><div style="float:left;">'.$center_destination.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_destination.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Destino" data-content="'.$order_destination_date.' '.$order_destination_hour.'" title="'.$center_destination.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    '<td><div style="float:left;">INICIAL: S/. 200.00<br />ACTUAL: S/ 189.00</div></td>'.
                    '<td class="center">'.
                        '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar Subasta" data-id="'.$order_detail_id.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '<a style="cursor:pointer;margin-left:20px;" class="detail hint--left" data-hint="Ver Ofertas" data-id="'.$order_detail_id.'"><i class="glyphicon glyphicon-search" /></a>'.
                    '</td></tr>';
            }
        }
    }
