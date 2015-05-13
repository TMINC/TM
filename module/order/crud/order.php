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
            if ($stmt = $mysqli->prepare("SELECT iOrdID, iSerTypID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, cs.iCusID, cs.cCusNam, cOrdDet, cOrdSta FROM tm_order AS o, tm_customer AS cs WHERE o.iCusID=cs.iCusID")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_id, $order_type, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $customer_id, $customer_name, $order_detail, $order_status);
                while($row = $stmt->fetch()) { 
                    $measure_volume = measure_char($measure_volume_id, $mysqli);
                    $measure_weight = measure_char($measure_weight_id, $mysqli);
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    $measure_price = measure_char($measure_price_id, $mysqli);
                    $measure_real_price = measure_char($measure_real_price_id, $mysqli);
                    $type = service_type_char($order_type, $mysqli);
                    $disabled = ' disabled="disabled"';
                    if($order_detail=='0'){$detail='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Sin detalle registrado"><i class="glyphicon glyphicon-exclamation-sign" /></a>';}
                    if($order_detail=='1'){$detail='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Con detalle registrado"><i class="glyphicon glyphicon-ok-sign" /></a>';}
                    if($order_status=='0'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Rechazada"><i class="glyphicon glyphicon-unchecked" /></a>';$disabled = '';}
                    if($order_status=='1'){$status='<a class="hint--right hint--error" style="float:right;cursor:pointer;" data-hint="Pendiente de Liberaci&oacute;n"><i class="glyphicon glyphicon-unchecked" /></a>';$disabled = '';}
                    if($order_status=='2'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Liberada"><i class="glyphicon glyphicon-log-in" /></a>';}
                    if($order_status=='3'){$status='<a class="hint--right hint--warning" style="float:right;cursor:pointer;" data-hint="Orden Subastada"><i class="glyphicon glyphicon-flash" /></a>';}
                    if($order_status=='4'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Transporte Asignado"><i class="glyphicon glyphicon-new-window" /></a>';}
                    if($order_status=='5'){$status='<a class="hint--right hint--info" style="float:right;cursor:pointer;" data-hint="Procesando Transporte"><i class="glyphicon glyphicon-expand" /></a>';}
                    if($order_status=='6'){$status='<a class="hint--right hint--success" style="float:right;cursor:pointer;" data-hint="Transporte Finalizado"><i class="glyphicon glyphicon-log-out" /></a>';}
                    echo '<tr><td><input id="c'.$order_id.'" name="row_sel" type="checkbox" '.$disabled.' class="row_sel uni_style" data-id="'.$order_id.'" data-detail="'.$order_detail.'" data-status="'.$order_status.'">'.$detail.'</td>'.
                        '<td>'.$order_id.$status.'</td>'.
                        '<td>'.$customer_name.'</td>'.
                        '<td>'.$type.'</td>'.
                        '<td style="text-align:right;">'.$order_volume.'&nbsp;'.$measure_volume.'</td>'.                            
                        '<td style="text-align:right;">'.$order_weight.'&nbsp;'.$measure_weight.'</td>'.
                        '<td style="text-align:right;">'.$order_distance.'&nbsp;'.$measure_distance.'</td>'.
                        '<td style="text-align:right;">'.$measure_price.'&nbsp;'.number_format($order_price,2).'</td>'.
                        '<td style="text-align:right;">'.$measure_real_price.'&nbsp;'.number_format($order_real_price,2).'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$order_id.'" data-type="'.$order_type.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-customer="'.$customer_id.'" data-detail="'.$order_detail.'" data-status="'.$order_status.'"><i class="glyphicon glyphicon-edit" /></a>'.
                            '<a style="cursor:pointer;margin-left:20px;" class="detail hint--left" data-hint="Registrar Detalle" data-id="'.$order_id.'" data-type="'.$order_type.'" data-volume="'.$order_volume.'" data-measure_volume="'.$measure_volume_id.'" data-weight="'.$order_weight.'" data-measure_weight="'.$measure_weight_id.'" data-distance="'.$order_distance.'" data-measure_distance="'.$measure_distance_id.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-customer="'.$customer_id.'" data-detail="'.$order_detail.'" data-status="'.$order_status.'"><i class="glyphicon glyphicon-pencil" /></a>'.
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
            $customer_id = $_POST['customer'];
            $status = $_POST['status'];
            $detail = $_POST['detail'];
            if($action=='insert'){
                $mysqli->query("INSERT INTO tm_order (iSerTypID, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdPri, iMeaIDPri, cOrdReaPri, iMeaIDReaPri, iCusID, cOrdSta) VALUES "
                        . "('".$order_type."', '".$order_volume."', '".$measure_volume_id."', '".$order_weight."', '".$measure_weight_id."', '".$order_distance."', '".$measure_distance_id."', '".$order_price."', '".$measure_price_id."', '".$order_real_price."', '".$measure_real_price_id."', '".$customer_id."', '1')");
            } 
            if($action=='update'){
                $mysqli->query("UPDATE tm_order SET iSerTypID='".$order_type."' , cOrdVol='".$order_volume."', iMeaIDVol='".$measure_volume_id."', cOrdWei='".$order_weight."', iMeaIDWei='".$measure_weight_id."', cOrdDis='".$order_distance."', iMeaIDDis='".$measure_distance_id."', cOrdPri='".$order_price."', iMeaIDPri='".$measure_price_id."', cOrdReaPri='".$order_real_price."', iMeaIDReaPri='".$measure_real_price_id."', iCusID='".$customer_id."' WHERE iOrdID='".$order_id."'");
            }
            if($action=='delete'){
                $_id = explode(",", $order_id);
                for($i=0; $i< sizeof($_id) ;$i++){
                     $mysqli->query("DELETE FROM tm_order WHERE iOrdID='".$_id[$i]."'");
                }
            }
            if($action=='status'){
                $_id = explode(",", $order_id);
                for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("UPDATE tm_order SET cOrdSta='".$status."' WHERE iOrdID='".$_id[$i]."'");
                    //Si el "status" cumple el tipo 5, tendremos que asignarle la insercion de los servicios y la orden en la tabla tm_state_control
                    if($status=='5'){
                        $order_detail_id = get_order_details($_id[$i], $mysqli);
                        $_ids = explode(",", $order_detail_id);
                        for($is=0; $is< sizeof($_ids) ;$is++){
                            $allocation_detail_id = get_order_details_allocation($_ids[$is], $mysqli);
                            $_ida = explode(",", $allocation_detail_id);
                            for($ia=0; $ia< sizeof($_ida) ;$ia++){
                                $mysqli->query("INSERT INTO tm_state_control(iOrdID, iOrdDetID, iAllTraDetID) VALUES ('".$_id[$i]."', '".$_ids[$is]."', '".$_ida[$ia]."')");
                            }
                        }
                    }
                }
            }
            if($action=='detail'){
                $mysqli->query("UPDATE tm_order SET cOrdDet='".$detail."' WHERE iOrdID='".$order_id."'");
            }
        }
    }