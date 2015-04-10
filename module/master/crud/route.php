<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    if($action=='consult'){
        $sel = $_POST['sel'];
        if ($stmt = $mysqli->prepare("SELECT iRouID, cRouNam FROM tm_route WHERE cRouSta='1'")){
           $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($route_id, $route_name);
            while($row = $stmt->fetch()) {
                if($sel==$route_id){$selected = " selected";}else{$selected = "";}
                echo '<option value="'.$route_id.'" '.$selected.'>'.$route_name.'</option>';
            }            
        }
    }else{
        if($action=='select'){
            if ($stmt = $mysqli->prepare("SELECT iRouID, cRouNam, iCenIDOri, iCenIDDes, cRouDis, iMeaIDDis, cRouTim, cRouPri, iMeaIDPri, cRouReaPri, iMeaIDReaPri, cRouSta FROM tm_route")){
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($route_id, $route_name, $center_origin_id, $center_destination_id, $route_distance, $measure_distance_id, $route_time, $route_price, $measure_price_id, $route_real_price, $measure_real_price_id, $route_status);
                while($row = $stmt->fetch()) {
                    $center_origin = center_char($center_origin_id, $mysqli);
                    $center_destination = center_char($center_destination_id, $mysqli);
                    $measure_distance = measure_char($measure_distance_id, $mysqli);
                    $measure_price = measure_char($measure_price_id, $mysqli);
                    $measure_real_price = measure_char($measure_real_price_id, $mysqli);                    
                    if($route_status=='1'){$status='<a class="hint--left hint--success" style="float:right;cursor:pointer;" data-hint="Activo"><i class="glyphicon glyphicon-ok" /></a>';}else{$status='<a class="hint--left hint--error" style="float:right;cursor:pointer;" data-hint="Inactivo"><i class="glyphicon glyphicon-minus" /></a>';}
                    echo '<tr><td><input id="c'.$route_id.'" name="row_sel" type="checkbox" class="row_sel uni_style" data-id="'.$route_id.'"></td>'.
                        '<td>'.$route_id.$status.'</td>'.
                        '<td>'.$route_name.'</td>'.
                        '<td>'.$center_origin.'</td>'.
                        '<td>'.$center_destination.'</td>'.
                        '<td>'.$route_distance.' '.$measure_distance.'</td>'.
                        '<td>'.$route_time.'</td>'.
                        '<td>'.$measure_price.' '.$route_price.'</td>'.
                        '<td>'.$measure_real_price.' '.$route_real_price.'</td>'.
                        '<td class="center">'.
                            '<a style="cursor:pointer;" class="edit hint--left" data-hint="Editar" data-id="'.$route_id.'" data-name="'.$route_name.'" data-origin_id="'.$center_origin_id.'" data-destination_id="'.$center_destination_id.'" data-distance="'.$route_distance.'" data-measure_distance="'.$measure_distance_id.'" data-time="'.$route_time.'" data-price="'.$route_price.'" data-measure_price="'.$measure_price_id.'" data-real_price="'.$route_real_price.'" data-measure_real_price="'.$measure_real_price_id.'" data-status="'.$route_status.'"><i class="glyphicon glyphicon-edit" /></a>'.                            
                        '</td></tr>';
                }
            }
        }else{
           $route_id = $_POST['id'];
           $route_name = $_POST['name'];
           $center_origin_id = $_POST['origin'];
           $center_destination_id = $_POST['destination'];
           $route_distance = $_POST['distance'];
           $measure_distance_id = $_POST['measure_distance'];
           $route_time = $_POST['time'];
           $route_price = $_POST['price']; 
           $measure_price_id = $_POST['measure_price'];
           $route_real_price = $_POST['real_price']; 
           $measure_real_price_id = $_POST['measure_real_price'];
           if($_POST['status']=='true'){$route_status=1;}else{$route_status=0;}
           if($action=='insert'){               
               $mysqli->query("INSERT INTO tm_route (cRouNam, iCenIDOri, iCenIDDes, cRouDis, iMeaIDDis, cRouTim, cRouPri, iMeaIDPri, cRouReaPri, iMeaIDReaPri, cRouSta) VALUES ('".$route_name."', '".$center_origin_id."', '".$center_destination_id."', '".$route_distance."', '".$measure_distance_id."', '".$route_time."', '".$route_price."', '".$measure_price_id."', '".$route_real_price."', '".$measure_real_price_id."', '".$route_status."')");
           } 
           if($action=='update'){
               $mysqli->query("UPDATE tm_route SET cRouNam='".$route_name."' , iCenIDOri='".$center_origin_id."', iCenIDDes='".$center_destination_id."', cRouDis='".$route_distance."', iMeaIDDis='".$measure_distance_id."', cRouTim='".$route_time."', cRouPri='".$route_price."', iMeaIDPri='".$measure_price_id."', cRouReaPri='".$route_real_price."', iMeaIDReaPri='".$measure_real_price_id."', cRouSta='".$route_status."' WHERE iRouID='".$route_id."'");
           }
           if($action=='delete'){
               $_id = explode(",", $route_id);
               for($i=0; $i< sizeof($_id) ;$i++){
                    $mysqli->query("DELETE FROM tm_route WHERE iRouID='".$_id[$i]."'");
               }
           }
        }
    }