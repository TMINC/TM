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
        $_names = array_unique(explode(",", $names));
        $values = $_POST['value'];
        $_values = array_unique(explode(",", $values));
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
    if($action=='drawAdjudication'){
        $names = $_POST['name'];
        $_names = array_unique(explode(",", $names));
        $values = $_POST['value'];
        $_values = array_unique(explode(",", $values));
        $a_values = array_unique(explode("-", $values));
        $stmt = $mysqli->prepare("SELECT iVehClaID, CONCAT(cVehClaInf,'-',cVehClaNam) FROM tm_vehicle_class WHERE cVehClaSta='1'");
        $class_id = $a_values[1];
        for($i=0; $i< sizeof($_values) ;$i++){
            $a_values2 = explode("-", $_values[$i]);
            $shared =$a_values2[4];
            $nameClass = get_dsc_cla_veh($class_id,$mysqli);
            if($shared==2){         
                $check_Shared = '<b style="color:#999;">COMPARTIR EN OTRO VIAJE?</b> <input type="checkbox" class="editShareType bs-switch" data-size="small" id="typeShare'.$_values[$i].'" name="typeShare" checked="checked" />';
            }
            else{
                $check_Shared = '<b style="color:#999;">COMPARTIR EN OTRO VIAJE?</b> <input type="checkbox" class="editShareType bs-switch" data-size="small" id="typeShare'.$_values[$i].'" name="typeShare"/>';
            }
            echo '<tr>
                <td style="width:50%;"><b>'.$nameClass.' : </b><br/><small>'.$_names[$i].'</small><br>'.$check_Shared.'</td>
                <td>
                    <select class="form-control chzn_edit editAdjudicationType" id="typeAdjudication_'.$_values[$i].'" name="editAdjudicationType" data-id="typeAdjudication_'.$_values[$i].'" data-carrier="typeCarrier_'.$_values[$i].'" data-search="0" data-placeholder="SELECCIONE TIPO DE ADJUDICACION..."></select><span class="help-block">Adjudicaci&oacute;n</span>
                    <select class="form-control chzn_edit editCarrier hide" id="typeCarrier_'.$_values[$i].'" multiple="multiple" name="editCarrier" data-placeholder="SELECCIONE PROVEEDOR DE TRANSPORTE..."></select><span class="help-block">Proveedor</span>
                </td>
                </tr>';
        }
    }
