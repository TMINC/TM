<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel SIlva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    if($action=='select'){
        $option = $_POST['option'];
        $order_id = $_POST['id'];
        if ($stmt = $mysqli->prepare("SELECT iOrdDetID, iOrdID, iCenIDOri, cOrdColDat, cOrdColHou, iCenIDDes, cOrdArrDat, cOrdArrHou, cOrdVol, iMeaIDVol, cOrdWei, iMeaIDWei, cOrdDis, iMeaIDDis, cOrdDetPri, iMeaIDDetPri, cOrdDetReaPri, iMeaIDDetReaPri, cOrdDetNot FROM tm_order_detail WHERE iOrdID = ".$order_id)){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($order_detail_id, $order_id, $center_origin_id, $order_origin_date, $order_origin_hour, $center_destination_id, $order_destination_date, $order_destination_hour, $order_volume, $measure_volume_id, $order_weight, $measure_weight_id, $order_distance, $measure_distance_id, $order_price, $measure_price_id, $order_real_price, $measure_real_price_id, $order_note);
                while($row = $stmt->fetch()) {                       
                    echo '<tr><td><input id="c'.$order_detail_id.'" name="row_sel_detail" type="checkbox" class="row_sel_detail uni_style" data-id="'.$order_detail_id.'" ></td>'.
                        '<td>'.$order_origin_date.'</td>'.                            
                        '<td>'.$order_origin_hour.'</td>'.
                         '<td>'.$order_destination_date.'</td>'.                            
                        '<td>'.$order_destination_hour.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit_date hint--left" data-hint="Editar" data-detail_id="'.$order_detail_id.'" data-id="'.$order_id.'" data-origin_date="'.$order_origin_date.'" data-origin_hour="'.$order_origin_hour.'" data-destination_date="'.$order_destination_date.'" data-destination_hour="'.$order_destination_hour.'"><i class="glyphicon glyphicon-edit" /></a>'.
                        '</td></tr>';
                }
        }     
    }
    else if($action='detail'){
        $option = $_POST['option'];
        if($option=='1'){
                $order_id = $_POST['id'];
                $_id = explode(",", $order_id);
                $_Typeadj="";
                echo "SELECT det.iOrdDetID, det.iOrdID,c.cCenNam, det.cOrdColDat,det.cOrdColHou,c1.cCenNam, det.cOrdArrDat, det.cOrdArrHou, carr.cCarNam, p.cPlaniAdjType 
                        FROM tm_order_detail as det 
                        JOIN tm_center as c ON det.iCenIDOri=c.iCenID 
                        JOIN tm_center as c1 ON det.iCenIDDes=c1.iCenID 
                        LEFT JOIN tm_planification as p ON det.IOrdDetID=p.iOrdDetID 
                        LEFT JOIN tm_carrier as carr ON p.iCarID = carr.iCarID
                        WHERE det.iOrdID='".$order_id."'";
                
                for($i=0; $i< sizeof($_id) ;$i++){
                    if ($stmt = $mysqli->prepare("SELECT det.iOrdDetID, c.cCenNam, det.cOrdColDat,det.cOrdColHou,c1.cCenNam, det.cOrdArrDat, det.cOrdArrHou, carr.cCarNam, p.cPlaniAdjType "
                                    . "FROM tm_order_detail as det "
                                    . "JOIN tm_center as c ON det.iCenIDOri=c.iCenID "
                                    . "JOIN tm_center as c1 ON det.iCenIDDes=c1.iCenID "
                                    . "LEFT JOIN tm_planification as p ON det.IOrdDetID=p.iOrdDetID "
                                    . "LEFT JOIN tm_carrier as carr ON p.iCarID = carr.iCarID "
                                    . "WHERE det.iOrdID='".$_id[$i]."'")){
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($orderdet_id, $orderdet_orig, $ordendet_dataO, $orderdet_hourO, $orderdet_dest, $orderdet_dataD, $orderdet_hourD,$orderdet_transp,$orderdet_AdjType);
                        while($row = $stmt->fetch()) { 
                            if($orderdet_AdjType=='0'){$_Typeadj="Directa";}else if($orderdet_AdjType=='1'){$_Typeadj="Subasta";}
                            echo 
                            '<tr><td style="text-align: center;">'.
                                '<a href="JavaScript:void(0);" style="cursor:pointer;" class="plan_trip hint--left" data-hint="Viaje" data-origin="'.$orderdet_orig.'" data-destination="'.$orderdet_dest.'" data-adjudication="'.$orderdet_AdjType.'" data-carrier="'.$orderdet_transp.'"><i class="glyphicon glyphicon-pencil"></i></a>'.                       
                            '</td>'.
                            '<td>'.$orderdet_id.'</td>'.
                            '<td>'.$orderdet_orig.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$ordendet_dataO." ".$orderdet_hourO.'" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="'.$orderdet_orig.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                            '<td>'.$orderdet_dest.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$orderdet_dataD." ".$orderdet_hourD.'" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="'.$orderdet_dest.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                            '<td>'.$orderdet_transp.'</td>'. 
                            '<td>'.$_Typeadj.'</td></tr>';
                        }
                    }
                }
            }
        else if($option=='2'){
                if ($stmt = $mysqli->prepare("SELECT iVehClaID, CONCAT(cVehClaInf,'-',cVehClaNam) "
                        . "FROM tm_vehicle_class "
                        . "WHERE cVehClaSta='1'")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vehcla_id, $vehcla_dsc);
                    while($row = $stmt->fetch()) {
                        $total = get_vehicles_total($vehcla_id,$mysqli);
                        $veh = get_vehicles_details($vehcla_id,$mysqli);
                        if($total>0){
                            echo '<optgroup label="'.$vehcla_dsc.'" >'.$veh.'</optgroup>';
                        }
                    }            
                }
        }
        else if($option=='3'){
            $order_id = $_POST['id']; 
            if ($stmt = $mysqli->prepare("SELECT COUNT(*) FROM tm_allocation_transport  "
                        . "WHERE cAlloTraOrders in (".$order_id.")")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($nro_transp);
                echo $nro_transp;
            }
        }        
    }else if($action=='AllocTransport'){
            $order = $_POST['order'];
            $id = $_POST['id'];
            $cnt = $_POST['val'];
            $_val = explode("-",$id);
            $vehcla_id =$_val[0];
            $vehtyp_id=$_val[1];
            $vehcat_id=$_val[2];
            $status="0";
            for($i=0;$i<$cnt;$i++){
                $mysqli->query("INSERT INTO tm_allocation_transport (cAlloTraOrders,iAlloTraCntVeh,iAlloTraStaVeh,iVehCatId,iVehClaID,iVehTypID) "
                    . "VALUES ('".$order."', '1', '".$status."', '".$vehcat_id."', '".$vehcla_id."', '".$vehtyp_id."')");
            }
        }
        else if($action=='SelectDetail'){
            $option = $_POST['option'];
            if($option=='1'){
            $order_id = $_POST['id'];
                $_id = explode(",", $order_id);
                $_Typeadj="";
                echo "SELECT det.iOrdDetID, det.iOrdID,c.cCenNam, det.cOrdColDat,det.cOrdColHou,c1.cCenNam, det.cOrdArrDat, det.cOrdArrHou, carr.cCarNam, p.cPlaniAdjType 
                        FROM tm_order_detail as det 
                        JOIN tm_center as c ON det.iCenIDOri=c.iCenID 
                        JOIN tm_center as c1 ON det.iCenIDDes=c1.iCenID 
                        LEFT JOIN tm_planification as p ON det.IOrdDetID=p.iOrdDetID 
                        LEFT JOIN tm_carrier as carr ON p.iCarID = carr.iCarID
                        WHERE det.iOrdID='".$order_id."'";
                
                for($i=0; $i< sizeof($_id) ;$i++){
                    if ($stmt = $mysqli->prepare("SELECT det.iOrdDetID, c.cCenNam, det.cOrdColDat,det.cOrdColHou,c1.cCenNam, det.cOrdArrDat, det.cOrdArrHou, carr.cCarNam, p.cPlaniAdjType "
                                    . "FROM tm_order_detail as det "
                                    . "JOIN tm_center as c ON det.iCenIDOri=c.iCenID "
                                    . "JOIN tm_center as c1 ON det.iCenIDDes=c1.iCenID "
                                    . "LEFT JOIN tm_planification as p ON det.IOrdDetID=p.iOrdDetID "
                                    . "LEFT JOIN tm_carrier as carr ON p.iCarID = carr.iCarID "
                                    . "WHERE det.iOrdID='".$_id[$i]."'")){
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($orderdet_id, $orderdet_orig, $ordendet_dataO, $orderdet_hourO, $orderdet_dest, $orderdet_dataD, $orderdet_hourD,$orderdet_transp,$orderdet_AdjType);
                        while($row = $stmt->fetch()) { 
                            if($orderdet_AdjType=='0'){$_Typeadj="Directa";}else if($orderdet_AdjType=='1'){$_Typeadj="Subasta";}
                            echo 
                            '<tr><td style="text-align: center;">'.
                                '<a style="cursor:pointer;" class="plan_trip hint--left" data-hint="Viaje" data-id="'.$orderdet_id.'" data-origin="'.$orderdet_orig.'" data-destination="'.$orderdet_dest.'" ><i class="glyphicon glyphicon-pencil" /></a>'.                                                            
                            '</td>'.
                            '<td>'.$orderdet_id.'</td>'.
                            '<td>'.$orderdet_orig.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$ordendet_dataO." ".$orderdet_hourO.'" data-hint="Cita Recojo" style="cursor:help;float:right;" data-original-title="'.$orderdet_orig.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                            '<td>'.$orderdet_dest.'<a class="pop_over hint--left hint--info" data-placement="right" data-content="'.$orderdet_dataD." ".$orderdet_hourD.'" data-hint="Cita Llegada" style="cursor:help;float:right;" data-original-title="'.$orderdet_dest.'"><i class="glyphicon glyphicon-calendar"></i></a></td>'.
                            '<td>'.$orderdet_transp.'</td>'. 
                            '<td>'.$_Typeadj.'</td></tr>';
                        } 
                    }
                }
            }
            if($option=='2'){
                if ($stmt = $mysqli->prepare("SELECT iVehClaID, cVehClaInf, cVehClaNam FROM tm_vehicle_class WHERE cVehClaSta ='1'")){
                    $stmt->execute();
                    $stmt->store_result();
                    $stmt->bind_result($vehcla_id, $vehcla_inf,$vehcla_nam);
                    while($row = $stmt->fetch()) {
                        $total = get_vehicles_total($vehcla_id,$mysqli);
                        if($total > 0)
                        {
                            echo '<optgroup label="'.$vehcla_inf.'-'.$vehcla_nam.'">';
                            if ($stmt2 = $mysqli->prepare("SELECT DISTINCT(v.iVehTypID),t.cVehTypNam, v.iVehCatID, ca.cVehCatInf FROM tm_vehicle as v"
                                . " INNER JOIN tm_vehicle_category as ca ON v.iVehCatID = ca.iVehCatID "
                                . " INNER JOIN tm_vehicle_type as t ON v.iVehTypID = t.iVehTypID"
                                . " WHERE v.cVehSta='1' AND v.iVehClaID = ".$vehcla_id)){
                                $stmt2->execute();
                                $stmt2->store_result();
                                $stmt2->bind_result($vehtyp_id,$vehtyp_name, $vehcat_id,$vehcat_inf);
                                while($row2 = $stmt2->fetch()) {
                                    echo '<option value="'.$vehcla_id.'-'.$vehtyp_id.'-'.$vehcat_id.'">'.$vehtyp_name.' ['.$vehcat_inf.']</option>';                                        
                                }
                            }
                            echo '</optgroup>';
                        }
                    }
                }                                    
            }
            if($option=='3'){
               $order_id = $_POST['id'];
               if ($stmt = $mysqli->prepare("SELECT COUNT(at.iAlloTraCntVeh) "
                            . "FROM tm_allocation_transport as at "
                            . "WHERE at.cAlloTraOrders in (?)")){
                        $stmt->bind_param('s', $order_id);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($cnt_veh);
                        $stmt->fetch();
                        echo $cnt_veh;
                }
                
            }
        }        
    else{        
        $order_detail_id = $_POST['date_id'];
        $order_origin_date = $_POST['date_origin_date']; 
        $order_origin_hour = $_POST['date_origin_hour'];
        $order_destination_date = $_POST['date_destination_date'];
        $order_destination_hour = $_POST['date_destination_hour'];        
        if($action=='update'){
            $mysqli->query("UPDATE tm_order_detail SET cOrdColDat='".$order_origin_date."', cOrdColHou='".$order_origin_hour."', cOrdArrDat='".$order_destination_date."', cOrdArrHou='".$order_destination_hour."' WHERE iOrdDetID='".$order_detail_id."'");                         
        }        
    }