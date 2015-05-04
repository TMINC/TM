<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
     
    $action = $_POST['action'];           
    $service_reassign_id = $_POST['id'];
    $order_detail_id = $_POST['ids'];
    $carrier_last_id = $_POST['current'];
    $carrier_id = $_POST['new'];
    $service_reassign_cause = $_POST['reason'];
    $allocation = $_POST['allocation'];
    
    
    if($action=='reasigment'){
        $_id = explode(",", $order_detail_id);
        for($i=0; $i< sizeof($_id) ;$i++){
            $mysqli->query("INSERT INTO tm_service_reassign (iOrdDetID, iCarIDs, iCarID, cSerReaCau) VALUES ('".$_id[$i]."', '".$carrier_last_id."', '".$carrier_id."', '".$service_reassign_cause."')");
            $mysqli->query("UPDATE tm_allocation_transport_detail SET cAllTraDetCarrID='".$carrier_id."' WHERE iAllTraDetID='".$allocation."'");
        }
    } 