<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
     
    $action = $_POST['action'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT atd.iAllTraID, d.iOrdDetID, d.cOrdDetFla, o.iOrdID, o.cOrdSta, o.iOrdTyp, d.iCenIDOri, d.cOrdColDat, d.cOrdColHou, d.iCenIDDes, d.cOrdArrDat, d.cOrdArrHou, d.cOrdVol, d.iMeaIDVol, d.cOrdWei, d.iMeaIDWei, d.cOrdDis, d.iMeaIDDis, d.cOrdDetNot, atd.cAllTraDetCarrID FROM tm_order_detail AS d, tm_order AS o, tm_allocation_transport_detail AS atd WHERE d.iOrdID=o.iOrdID AND atd.cAllTraDetOrdDet=d.iOrdDetID AND atd.cAllTraDetAdjTyp='1'")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($allocation_id, $order_detail_id, $order_detail_flag, $order_id, $order_status, $order_type, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_note, $participants);
            $cnt=0;
            while($row = $stmt->fetch()) { 
                $cnt++;
                $center_origin = center_char($center_origin_id, $mysqli);
                $center_type = center_type_char($center_origin_id, $mysqli);if($center_type==1){$center_type_origin="CENTRO DE ACOPIO";}if($center_type==2){$center_type_origin="PLANTA";}if($center_type==3){$center_type_origin="PUERTO DESTINO";}
                $center_destination = center_char($center_destination_id, $mysqli);
                $center_types = center_type_char($center_destination_id, $mysqli);if($center_types==1){$center_type_destination="CENTRO DE ACOPIO";}if($center_types==2){$center_type_destination="PLANTA";}if($center_types==3){$center_type_destination="PUERTO DESTINO";}
                $measure_volume = measure_char($measure_volume_id, $mysqli);
                $measure_weight = measure_char($measure_weight_id, $mysqli); 
                $measure_distance = measure_char($measure_distance_id, $mysqli);
                $vehicle = ship_char_extreme_auction($order_detail_id, $mysqli);
                $vehicle_code = vehicle_char($allocation_id, $mysqli);
                if($order_type=='1'){$type='TRANSPORTE FRESCO';}else{$type='TRANSPORTE CONGELADO';}
                if($order_status=='3'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;margin-left:5px;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                /**
                 * Auction Data 
                 **/
                if(char_auction_exist($order_id, $order_detail_id, $mysqli)){
                    $exist=1;
                    $auction=char_auction_id($order_id, $order_detail_id, $mysqli);
                    $status_auction=char_auction('cAucSta', $auction, $mysqli);
                    $price_start=char_auction('cAucBasAmo', $auction, $mysqli);
                    $price_now=char_auction_offer($auction, $mysqli);
                    $start=char_auction('cAucStart', $auction, $mysqli);
                    $_start = explode(" ", $start);
                    $date_start=$_start[0];
                    $hour_start=$_start[1];
                    $end=char_auction('cAucEnd', $auction, $mysqli);
                    $_end = explode(" ", $end);
                    $date_end=$_end[0];
                    $hour_end=$_end[1];
                    $info=char_auction('cAucInf', $auction, $mysqli);
                    $auction_description='Subasta Iniciada, finaliza en:';
                }else{
                    $exist=0;
                    $auction=$cnt;
                    $status_auction='0';
                    $price_start=number_format('0',2);
                    $price_now=number_format('0',2);
                    $date_start='0000-00-00';
                    $date_end='0000-00-00';
                    $hour_start='00:00:00';
                    $hour_end='00:00:00';
                    $info='- - - - -';
                    $auction_description='Subasta sin Iniciar';
                }
                if($status_auction=='1'){$flag='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Liberada"><i class="glyphicon glyphicon-flag" /></a>';}
                else{$flag='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberar"><i class="glyphicon glyphicon-lock" /></a>';}
                if($price_now>0){}else{$price_now=$price_start;}
                $_date_end = explode("-", $date_end);
                $_hour_end = explode(":", $hour_end);
                echo '<tr><td><input name="row_sel" type="checkbox" class="row_sel" data-id="'.$order_detail_id.'" data-exist="'.$exist.'" data-auction="'.$auction.'"></td>'.
                    '<td>'.format($order_detail_id).$status.$flag.'<br /><span class="help-block" style="font-size:8px;"><b>REF.ORDEN: </b>'.$order_id.'</span></td>'.
                    '<td>'.
                        '<div class="formSep">'.$type.
                            '<a style="cursor:help;float:right; margin-left:10px;" class="pop_over hint--left hint--info" data-hint="Caracter&iacute;sticas" data-content="<b>VOLUMEN:</b> '.$order_volume.' '.$measure_volume.'. <br /><b>PESO:</b> '.$order_weight.' '.$measure_weight.'. <br /><b>DISTANCIA APROX.:</b> '.$order_distance.' '.$measure_distance.'" title="CARACTER&Iacute;STICAS" data-placement="right"><i class="glyphicon glyphicon-list-alt"></i></a>'.
                            '<a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Información Adicional" data-content="'.$info.'" title="INFO ADICIONAL" data-placement="right"><i class="glyphicon glyphicon-exclamation-sign"/></a>'.
                        '</div>'.
                        '<div class="formSep"><small class="s_color sl_email">'.$vehicle.'</small></div>'.
                        '<div style="float:right;margin-top:-8px;"><a style="cursor:help;" class="hint--left hint--info" data-hint="'.$auction_description.'"><i class="glyphicon glyphicon-time"></i></a> <div id="countdown'.$auction.'" class="label label-info"></div></div>'.
                        '<script>$("#countdown'.$auction.'").countdown({until: new Date('.$_date_end[0].', '.$_date_end[1].' - 1, '.$_date_end[2].', '.$_hour_end[0].', '.$_hour_end[1].', 0),format: "DHMS"});</script></td>'.  
                    '<td><div style="float:left;">'.$center_origin.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_origin.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Origen" data-content="'.$order_origin_date.' '.$order_origin_hour.'" title="'.$center_origin.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.                            
                    '<td><div style="float:left;">'.$center_destination.'<br /><span class="help-block" style="font-size:8px;">'.$center_type_destination.'</span></div><a style="cursor:help;float:right;" class="pop_over hint--left hint--info" data-hint="Destino" data-content="'.$order_destination_date.' '.$order_destination_hour.'" title="'.$center_destination.'" data-placement="right"><i class="glyphicon glyphicon-calendar"/></a></td>'.
                    '<td><p><span class="label label-default"  style="float:right;">PRECIO INICIAL &nbsp;&nbsp;&nbsp; (S/.)</span><br /><span class="help-block" style="float:right;">'.number_format($price_start,2).'</help></p><p><span class="label label-info" style="float:right;">PRECIO SUBASTA (S/.)</span><br /><span class="help-block" style="float:right;">'.number_format($price_now,2).'</span></p></td>'.
                    '<td class="center" style="width: 90px;">'.
                        '<a style="cursor:pointer;" class="edit hint--left" data-hint="Administrar Subasta" data-exist="'.$exist.'" data-order="'.$order_id.'" data-order_id="'.$order_detail_id.'" data-id="'.$auction.'" data-price_start="'.$price_start.'" data-price_now="'.$price_now.'" data-date_start="'.$date_start.'" data-date_end="'.$date_end.'" data-hour_start="'.$hour_start.'" data-hour_end="'.$hour_end.'" data-info="'.$info.'" data-participants="'.$participants.'" data-vehicle="'.$vehicle_code.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '<a style="cursor:pointer;margin-left:10px;" class="offer hint--left" data-hint="Ofertar" data-id="'.$auction.'" data-exist="'.$exist.'" data-price_start="'.$price_start.'" data-price_now="'.$price_now.'"><i class="glyphicon glyphicon-usd" /></a>'.
                        '<a style="cursor:pointer;margin-left:10px;" class="reassign hint--left" data-hint="Asignaci&nacute;n Directa" data-id="'.$order_detail_id.'"><i class="glyphicon glyphicon-transfer" /></a>'.
                    '</td></tr>';
            }
        }
    }else{
        $order_id = $_POST['order_id'];
        $order_detail_id = $_POST['order_detail_id'];
        $amount = $_POST['amount'];
        $info = $_POST['info'];
        $carrier = $_POST['carrier'];
        $date_start = $_POST['date_start'];
        $hour_start = $_POST['hour_start'];
        $start = $date_start.' '.$hour_start;
        $date_end = $_POST['date_end'];
        $hour_end = $_POST['hour_end'];
        $end = $date_end.' '.$hour_end;
        $free = $_POST['free'];
        if($action=='insert'){
            $mysqli->query("INSERT INTO tm_auction (iOrdID, iOrdDetID, cAucBasAmo, cAucInf, cAucStart, cAucEnd, cAucSta) VALUES ('".$order_id."', '".$order_detail_id."', '".$amount."', '".$info."', '".$start."', '".$end."', '0')");
            //UPDATE EN ALLOCATION
        } 
        if($action=='update'){
            $mysqli->query("UPDATE tm_auction SET cAucBasAmo='".$amount."', cAucInf='".$info."', cAucStart='".$start."', cAucEnd='".$end."' WHERE iOrdID='".$order_id."' AND iOrdDetID='".$order_detail_id."'");
            //UPDATE EN ALLOCATION
        }
        if($action=='free'){
            $auction_id = $_POST['id'];
            $_id = explode(",", $auction_id);
            for($i=0; $i< sizeof($_id) ;$i++){
                $mysqli->query("UPDATE tm_auction SET cAucSta='1' WHERE iAucID='".$_id[$i]."'");
            }
        }
        if($action=='delete'){
            $auction_id = $_POST['id'];
            $_id = explode(",", $auction_id);
            for($i=0; $i< sizeof($_id) ;$i++){
                 $mysqli->query("DELETE FROM tm_auction WHERE iAucID='".$_id[$i]."'");
                 $mysqli->query("DELETE FROM tm_auction_offer WHERE iAucID='".$_id[$i]."'");
            }
        }
        if($action=='idetail'){
            $auction_id = $_POST['aucid'];
            $carrier = $_POST['carrier'];
            $offer = $_POST['offer'];
            $mysqli->query("INSERT INTO tm_auction_offer (iAucID, iCarID, cAucOffDatHou, cAucOffAmo) VALUES ('".$auction_id."', '".$carrier."', '".date("Y-m-d H:i:s")."', '".$offer."')");
        }
        if($action=='sdetail'){
            $auction_id = $_POST['aucid'];
            $user_type = $_POST['type'];
            if ($stmt = $mysqli->prepare("SELECT u.cUseNam, o.cAucOffDatHou, o.cAucOffAmo FROM tm_auction_offer AS o,tm_user AS u WHERE o.iCarID=u.iUseID AND o.iAucID='".$auction_id."' ORDER BY o.cAucOffAmo ASC")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($user, $auction_date, $auction_amount);
                while($row = $stmt->fetch()) { 
                    echo '<tr>
                        <td><b>'.$user.'</b><span class="help-block">Oferto a las: '.$auction_date.'</span></td>
                        <td class="form-group" colspan="2">
                            <div class="input-group f_success ">
                                <span class="input-group-addon">S/.</span>
                                <input class="form-control" type="text" style="text-align: right;" value="'.$auction_amount.'" disabled="">
                                <span class="input-group-addon">.00</span>
                            </div>
                        </td>
                    </tr>';
                }
            }
        }
    }
