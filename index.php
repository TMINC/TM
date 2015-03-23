<?php
/**
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) { include 'dashboard.php'; } else { include 'login.php'; }