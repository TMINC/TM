<?php
/**
  * Copyright (C) 2015 netpartners-international.com
  * By: Johnny Moscoso Rossel
 **/

include_once 'db_connect.php';
include_once 'psl-config.php';
include_once 'functions.php';

$activity = $_POST['activity'];
if($activity=='1'){
    if (isset($_POST['user'], $_POST['password'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];

        if (login($user, $password, $mysqli) == true) { // Login success         
            exit();
        } else { 
            echo 'Los valores ingresados son incorrectos.';
        }
    } else { // The correct POST variables were not sent to this page. 
        header('Location: ../error.php?err=No se ha podido procesar la solicitud');
        exit();
    }
}else if($activity=='0'){
    $user = $_POST['username'];
    $mysqli->query("UPDATE tm_user SET cUseAct='0' WHERE cUseUse='".$user."'");
    echo 'Oops!!! Su sesi&oacute;n a expirado.';
}else if($activity=='2'){
    $user = $_POST['username'];
    $mysqli->query("UPDATE tm_user SET cUseAct='1' WHERE cUseUse='".$user."'");    
}else if($activity=='3'){
    $user = $_POST['username'];
    if ($stmt = $mysqli->prepare("SELECT cUseAct FROM tm_user WHERE cUseUse = ? LIMIT 1")){
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($user_activity);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
            if($user_activity=='0'){
                header('Location: ../includes/logout.php');
                header('Location: ../index.php');
            }
            exit();
        }
    }
}