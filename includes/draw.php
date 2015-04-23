<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$action = $_POST['action'];
    if($action=='drawVehicle'){
        $names = $_POST['name'];
        $_names = explode(",", $names);
        $values = $_POST['value'];
        $_values = explode(",", $values);
        $a_values = explode("-", $values);
        $stmt = $mysqli->prepare("SELECT iVehClaID, CONCAT(cVehClaInf,'-',cVehClaNam) FROM tm_vehicle_class WHERE cVehClaSta='1'");
        $class_id = $a_values[1];
        for($i=0; $i< sizeof($_values) ;$i++){
            $nameClass = get_dsc_cla_veh($class_id,$mysqli);
            echo '<tr>
                <td style="width:50%;"><b>'.$nameClass.' : </b><br/><small>'.$_names[$i].'</small></td>
                <td class="form-group"><input class="form-control editPlanQuantity" type="text" data-id='.$_values[$i].' id="editNumber_'.$_values[$i].'" name="editNumber" value="1"></td>
            </tr>';
        }
    }
