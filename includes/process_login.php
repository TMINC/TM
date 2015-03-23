<?php
/**
  * Copyright (C) 2015 netpartners-international.com
 **/

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['user'], $_POST['password'])) {
    $user = $_POST['user'];//filter_input(INPUT_POST, 'user', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; // The hashed password.
    
    if (login($user, $password, $mysqli) == true) { // Login success         
        //header("Location: ../dashboard.php");
        exit();
    } else { // Login failed         
        header('Location: ../error.php?error=1');
        exit();
    }
} else { // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=No se ha podido procesar la solicitud');
    exit();
}