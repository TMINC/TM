<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel SIlva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    $order_id = $_POST['order_id'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdDetPri, iMeaIDDetPri, cOrdDetReaPri, iMeaIDDetReaPri, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order_id)){
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
                echo '<tr><td><input id="c'.$order_detail_id.'" name="row_sel_detail" type="checkbox" class="row_sel_detail uni_style" data-id="'.$order_detail_id.'" ></td>'.
                    '<td>'.$cnt.'</td>'.
                    '<td>'.$center_origin.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&perp; '.$order_origin_date.'    &perp;'.$order_origin_hour.' " title="'.$center_origin.'" data-placement="left"><i class="glyphicon glyphicon-book"/></a></td>'.
                    '<td>'.$center_destination.'<a style="cursor:help;float:right;" class="pop_over hint--right hint--info" data-hint="Detalle" data-content="&perp; '.$order_destination_date.'    &perp;'.$order_destination_hour.' " title="'.$center_destination.'" data-placement="left"><i class="glyphicon glyphicon-book"/></a></td>'.
                    '<td>'.$measure_price.' '.$order_price.'</td>'.
                    '<td>'.$measure_real_price.' '.$order_real_price.'</td>'.
                    '<td>'.$order_note.'</td>'.
                    '<td class="center">'.
                        '<a style="cursor:pointer;" class="edit_detail hint--left" data-hint="Editar" data-detail_id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_id="'.$center_origin_id.'" data-origin_date="'.$order_origin_date.'" data-origin_hour="'.$order_origin_hour.'" data-destination_id="'.$center_destination_id.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'" data-price="'.$order_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$order_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-note="'.$order_note.'" data-real_price="'.$order_real_price.'"><i class="glyphicon glyphicon-edit" /></a>'.
                    '</td></tr>';
            }
        }
    }else{        
        $order_detail_id = $_POST['order_detail_id'];
        $center_origin_id = $_POST['origin'];
        $order_origin_date = $_POST['origin_date']; 
        $order_origin_hour = $_POST['origin_hour']; 
        $center_destination_id = $_POST['destination'];
        $order_destination_date = $_POST['destination_date'];
        $order_destination_hour = $_POST['destination_hour'];
        $order_price = $_POST['detail_price'];
        $measure_price_id = $_POST['detail_measure_price'];
        $order_real_price = $_POST['detail_real_price']; 
        $measure_real_price_id = $_POST['detail_measure_real_price'];
        $order_note = $_POST['detail_note'];
        if($action=='insert'){
            $mysqli->query("INSERT INTO tm_order_detail (iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdDetPri, iMeaIDDetPri, cOrdDetReaPri, iMeaIDDetReaPri, cOrdDetNot) VALUES ('".$order_id."', '".$center_origin_id."', '".$order_origin_date."', '".$order_origin_hour."', '".$center_destination_id."', '".$order_destination_date."', '".$order_destination_hour."', '".$order_price."', '".$measure_price_id."', '".$order_real_price."', '".$measure_real_price_id."', '".$order_note."')");
            $total = detail_total($order_id, $mysqli);
            if($total==0){
                $mysqli->query("UPDATE tm_order SET cOrdDet='0' WHERE iOrdID='".$order_id."'");
            }else{
                $mysqli->query("UPDATE tm_order SET cOrdDet='1' WHERE iOrdID='".$order_id."'");
            }
        } 
        if($action=='update'){
            echo "UPDATE tm_order_detail SET iCenIDOri='".$center_origin_id."' , cOrdColDat='".$order_origin_date."', cOrdColHou='".$order_origin_hour."', iCenIDDes='".$center_destination_id."', cOrdArrDat='".$order_destination_date."', cOrdArrHou='".$order_destination_hour."', cOrdDetPri='".$order_price."', iMeaIDDetPri='".$measure_price_id."', cOrdDetReaPri='".$order_real_price."', iMeaIDDetReaPri='".$measure_real_price_id."', cOrdDetNot='".$order_note."' WHERE iOrdDetID='".$order_detail_id."'";
            $mysqli->query("UPDATE tm_order_detail SET iCenIDOri='".$center_origin_id."' , cOrdColDat='".$order_origin_date."', cOrdColHou='".$order_origin_hour."', iCenIDDes='".$center_destination_id."', cOrdArrDat='".$order_destination_date."', cOrdArrHou='".$order_destination_hour."', cOrdDetPri='".$order_price."', iMeaIDDetPri='".$measure_price_id."', cOrdDetReaPri='".$order_real_price."', iMeaIDDetReaPri='".$measure_real_price_id."', cOrdDetNot='".$order_note."' WHERE iOrdDetID='".$order_detail_id."'");
            $total = detail_total($order_id, $mysqli);
            if($total==0){
                $mysqli->query("UPDATE tm_order SET cOrdDet='0' WHERE iOrdID='".$order_id."'");
            }else{
                $mysqli->query("UPDATE tm_order SET cOrdDet='1' WHERE iOrdID='".$order_id."'");
            }            
        }
        if($action=='delete'){
            $_id = explode(",", $order_detail_id);
            for($i=0; $i< sizeof($_id) ;$i++){
                 $mysqli->query("DELETE FROM tm_order_detail WHERE iOrdDetID='".$_id[$i]."'");
            }
            $total = detail_total($order_id, $mysqli);
            if($total==0){
                $mysqli->query("UPDATE tm_order SET cOrdDet='0' WHERE iOrdID='".$order_id."'");
            }else{
                $mysqli->query("UPDATE tm_order SET cOrdDet='1' WHERE iOrdID='".$order_id."'");
            }
        }
    }