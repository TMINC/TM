<?php 
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel SIlva Figueroa
 **/
    include_once '../../../includes/db_connect.php';
    include_once '../../../includes/psl-config.php';
    include_once '../../../includes/functions.php';
    
    $action = $_POST['action'];
    $help_id = $_POST['help_id'];
    $help_reply_id = $_POST['reply_id'];
    $help_id = $_POST['help']; 
    $user_id = $_POST['id']; 
    $help_reply_description = $_POST['description'];  
    if($action=='insert'){   
        $mysqli->query("INSERT INTO tm_help_reply (iHelID, cHelRepDes, iUseID) VALUES ('".$help_id."', '".$help_reply_description."', '".$user_id."')");
       } 
    if($action=='update'){
        $mysqli->query("UPDATE tm_help_reply SET cHelRepDes='".$help_reply_description."', cHelRepRev='".$help_reply_reviews."', iUseID='".$user_id."' WHERE iHelRepID='".$help_reply_id."'");                         
    }