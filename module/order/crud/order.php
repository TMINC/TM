<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
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
            if ($stmt = $mysqli->prepare("SELECT iOrdID, iOrdTyp, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdDet, cOrdSta FROM tm_order")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_id, $order_type, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_detail, $order_status);
                while($row = $stmt->fetch()) { 
                    $iMeaIDVol = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDVol->bind_param('s', $measure_volume_id);
                    $iMeaIDVol->execute();
                    $iMeaIDVol->store_result();
                    $iMeaIDVol->bind_result($measure_volume);
                    $iMeaIDVol->fetch();
                    
                    $iMeaIDWei = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDWei->bind_param('s', $measure_weight_id);
                    $iMeaIDWei->execute();
                    $iMeaIDWei->store_result();
                    $iMeaIDWei->bind_result($measure_weight);
                    $iMeaIDWei->fetch();
                    
                    $iMeaIDDis = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDDis->bind_param('s', $measure_distance_id);
                    $iMeaIDDis->execute();
                    $iMeaIDDis->store_result();
                    $iMeaIDDis->bind_result($measure_distance);
                    $iMeaIDDis->fetch();
                    
                    $iMeaIDPri = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDPri->bind_param('s', $measure_price_id);
                    $iMeaIDPri->execute();
                    $iMeaIDPri->store_result();
                    $iMeaIDPri->bind_result($measure_price);
                    $iMeaIDPri->fetch();
                    
                    $iMeaIDReaPri = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
                    $iMeaIDReaPri->bind_param('s', $measure_real_price_id);
                    $iMeaIDReaPri->execute();
                    $iMeaIDReaPri->store_result();
                    $iMeaIDReaPri->bind_result($measure_real_price);
                    $iMeaIDReaPri->fetch();
                    
                    if($order_type=='0'){$type='undefined';}else{$type='undefined';}                    
                    if($order_detail=='0'){$detail='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Sin detalle registrado"><i class="glyphicon glyphicon-exclamation-sign" /></a>';}
                    if($order_detail=='1'){$detail='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Con detalle registrado"><i class="glyphicon glyphicon-ok-sign" /></a>';}
                    if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Sin Atenci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($order_status=='1'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    if($order_status=='2'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="En proceso"><i class="glyphicon glyphicon-unchecked" /></a>';}
                    echo '<tr><td><input id="c'.$order_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$order_id.'" data-detail="'.$order_detail.'">'.$detail.'</td>'.
                        '<td>'.$order_id.$status.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td>'.$order_volume.' '.$measure_volume.'</td>'.                            
                        '<td>'.$order_weight.' '.$measure_weight.'</td>'.
                        '<td>'.$order_distance.' '.$measure_distance.'</td>'.
                        '<td>'.$measure_price.' '.$order_price.'</td>'.
                        '<td>'.$measure_real_price.' '.$order_real_price.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$order_id.'" data-type="'.$order_type.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-detail="'.$order_detail.'" data-status="'.$order_status.'"><i class="glyphicon glyphicon-edit" /></a>'.
                            '<a style="cursor:pointer;margin-left:20px;" class="detail hint--left" data-hint="Registrar Detalle" data-id="'.$order_id.'" data-type="'.$order_type.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-detail="'.$order_detail.'" data-status="'.$order_status.'"><i class="glyphicon glyphicon-pencil" /></a>'.
                        '</td></tr>';
                }
            }
        }else{
            $order_id = $_POST['id'];
            $order_type = $_POST['type'];
            $order_volume = $_POST['volume']; 
            $measure_volume_id = $_POST['measure_volume']; 
            $order_weight = $_POST['weight'];
            $measure_weight_id = $_POST['measure_weight'];
            $order_distance = $_POST['distance'];
            $measure_distance_id = $_POST['measure_distance'];
            $order_price = $_POST['price']; 
            $measure_price_id = $_POST['measure_price'];
            $order_real_price = $_POST['real_price']; 
            $measure_real_price_id = $_POST['measure_real_price'];
            $status = $_POST['status'];
            $detail = $_POST['detail'];
            if($action=='insert'){
                $mysqli->query("INSERT INTO tm_order (iOrdTyp, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cOrdSta) VALUES "
                        . "('".$order_type."', '".$order_volume."', '".$measure_volume_id."', '".$order_weight."', '".$measure_weight_id."', '".$order_distance."', '".$measure_distance_id."', '".$order_price."', '".$measure_price_id."', '".$order_real_price."', '".$measure_real_price_id."', '0')");
            } 
            if($action=='update'){
                $mysqli->query("UPDATE tm_order SET iOrdTyp='".$order_type."' , cOrdVol='".$order_volume."', iMeaIDVol='".$measure_volume_id."', cOrdWei='".$order_weight."', iMeaIDWei='".$measure_weight_id."', cOrdDis='".$order_distance."', iMeaIDDis='".$measure_distance_id."', cOrdPri='".$order_price."', iMeaIDPri='".$measure_price_id."', cOrdReaPri='".$order_real_price."', iMeaIDReaPri='".$measure_real_price_id."' WHERE iOrdID='".$order_id."'");
            }
            if($action=='delete'){
                $_id = explode(",", $order_id);
                for($i=0; $i< sizeof($_id) ;$i++){
                     $mysqli->query("DELETE FROM tm_order WHERE iOrdID='".$_id[$i]."'");
                }
            }
            if($action=='status'){
                $mysqli->query("UPDATE tm_order SET cOrdSta='".$status."' WHERE iOrdID='".$order_id."'");
            }
            if($action=='detail'){
                $mysqli->query("UPDATE tm_order SET cOrdDet='".$detail."' WHERE iOrdID='".$order_id."'");
            }
        }
    }