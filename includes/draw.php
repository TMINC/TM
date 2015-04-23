<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'db_connect.php';
include_once 'psl-config.php';

$action = $_POST['action'];
    if($action=='drawVehicle'){
        $names = $_POST['name'];
        $_names = explode(",", $names);
        $values = $_POST['value'];
        $_values = explode(",", $values);
        for($i=0; $i< sizeof($_values) ;$i++){
            echo $_values[$i];
            echo '<tr>
                <td style="width:50%;"><b>'.$_names[$i].' :</b></td>
                <td class="form-group"><input class="form-control editPlanQuantity" type="text" id="editNumber_'.$_values[$i].'" name="editNumber" value="1"></td>
            </tr>';
        }
    }
