<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    
    $action = $_POST['action'];
    $user_id = $_POST['id'];
    if($action=='select'){
        if ($stmt = $mysqli->prepare("SELECT iUseID, cUseUse, cUseNam, cUseDes, cUseEma, cUseTyp, cUseSig FROM tm_user WHERE iUseID = ?")){
            $stmt->bind_param('s', $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user_id, $user_user, $user_name, $user_description, $user_email, $user_type, $user_signature);
            $jsondata = array();$i=0;
            while($row = $stmt->fetch()) {
                $jsondata['user'] = $user_user;
                $jsondata['name'] = $user_name;
                $jsondata['description'] = $user_description;
                $jsondata['email'] = $user_email;
                $jsondata['type'] = $user_type;
                $jsondata['signature'] = $user_signature;
            }
            header('Content-type: application/json; charset=utf-8');
            echo json_encode($jsondata);
        }
    }else{
        $user_user = $_POST['user'];
        $user_name = $_POST['name'];
        $user_description = $_POST['description'];
        $user_type = $_POST['type'];
        $user_signature = $_POST['signature'];
        $user_status = $_POST['status'];
        $user_password = $_POST['password'];
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
        $password = hash('sha512', $user_password.$random_salt);
        if($action=='update'){
            if($user_status=='1'){
                $mysqli->query("UPDATE tm_user SET cUseUse='".$user_user."', cUsePas='".$password."', cUseSal='".$random_salt."', cUseNam='".$user_name."', cUseDes='".$user_description."', cUseTyp='".$user_type."', cUseSig='".$user_signature."' WHERE iUseID='".$user_id."'");
            }else{
                $mysqli->query("UPDATE tm_user SET cUseUse='".$user_user."', cUseNam='".$user_name."', cUseDes='".$user_description."', cUseTyp='".$user_type."', cUseSig='".$user_signature."' WHERE iUseID='".$user_id."'");
            }
        }
    }