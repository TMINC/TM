<?php
$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : "";
$do = isset($_POST['do']) ? $_POST['do'] : "";
$page = isset($_POST['mod']) ? (empty($do) ? "-list" : ($do == 1 ? "-form" : "-action")) : "";

switch($mod){
    case 0: include "includes/welcome.php"; break;
    case 1: include "controller/upload.php"; break;
    case 2: include "controller/forgot_password.php"; break;
    case 3: include "controller/access.php"; break;	
    case 4: include "controller/logout.php"; break;
    case 5: include "controller/activate.js"; break;
    case 6: include "controller/help.php"; break;
    case 7: include "module/controller/user.php"; break;
    case 8: include "module/profile/profile$page.php"; break;

    case 11: include "module/master/customer$page.php"; break;
    case 12: include "module/master/carrier$page.php"; break;
    case 13: include "module/master/driver$page.php"; break;
    case 14: include "module/master/vehicle$page.php"; break; 
    case 15: include "module/master/vehicle-type$page.php"; break;
    case 16: include "module/master/vehicle-class$page.php"; break;
    case 17: include "module/master/vehicle-category$page.php"; break;
    case 18: include "module/master/vehicle-group$page.php"; break;
    case 19: include "module/master/center$page.php"; break;
    case 20: include "module/master/measure$page.php"; break;
    case 21: include "module/master/route$page.php"; break;
    
    case 22: include "module/order/order$page.php"; break;

    case 31: include "module/shipment/allocation-service$page.php"; break;
    case 32: include "module/shipment/allocation-reasigment$page.php"; break;
    case 33: include "module/shipment/allocation-auction$page.php"; break;
    case 34: include "module/shipment/process-data-transport$page.php"; break;
    case 35: include "module/shipment/process-state-control$page.php"; break;
    case 36: include "module/shipment/track$page.php"; break;
    
    case 51: include "module/configuration/configuration-profile$page.php"; break;
    case 52: include "module/configuration/configuration-rol$page.php"; break;
    case 53: include "module/configuration/configuration-user$page.php"; break;
    case 54: include "module/configuration/configuration-form$page.php"; break;
    
    default: include "includes/logout.php"; break;
}
?>
    