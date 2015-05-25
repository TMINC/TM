<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
     include_once '../../../includes/db_connect.php';
     include_once '../../../includes/psl-config.php';
     include_once '../../../includes/functions.php';
    $action = $_POST['action'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT c.iCarID, c.cCarNam, v.iVehID, v.cVehPla FROM tm_vehicle_assignation AS va,tm_carrier AS c, tm_vehicle AS v  WHERE va.iCarID=c.iCarID AND va.iVehID=v.iVehID")){
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($carrier_id, $carrier_name, $vehicle_id, $vehicle_plate);
            while($row = $stmt->fetch()) { 
                echo '<tr><td><input name="row_sel" type="checkbox" class="row_sel uni_style" data-carrier="'.$carrier_id.'" data-vehicle="'.$vehicle_id.'"></td>'.
                    '<td>'.$carrier_name.'</td>'.                            
                    '<td>'.$vehicle_plate.'</td>'.
                    '</td></tr>';
            }
        }
    }else{        
        $carrier_id = $_POST['carrier_id'];
        $vehicle_id = $_POST['vehicle_id'];
        if($action=='insert'){
            echo "INSERT INTO tm_vehicle_assignation (iCarID, iVehID) VALUES "
                       . "('".$carrier_id."', '".$vehicle_id."')";
            $mysqli->query("INSERT INTO tm_vehicle_assignation (iCarID, iVehID) VALUES "
                       . "('".$carrier_id."', '".$vehicle_id."')");
        } 
        if($action=='delete'){
            echo "DELETE FROM tm_vehicle_assignation WHERE iCarID='".$carrier_id."' AND iVehID='".$vehicle_id."'";
            $mysqli->query("DELETE FROM tm_vehicle_assignation WHERE iCarID='".$carrier_id."' AND iVehID='".$vehicle_id."'");
               
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  