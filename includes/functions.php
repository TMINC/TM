<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'psl-config.php';

function sec_session_start() {
    $session_name = 'tm_session_id';   // Set a custom session name 
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}

function login($user, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT iUseID, cUseUse, cUseNam, cUsePas, cUseSal 
				  FROM tm_user 
                                  WHERE cUseUse = ? LIMIT 1")) 
    {
        $stmt->bind_param('s', $user);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        // get variables from result.
        $stmt->bind_result($user_id, $useractive, $username, $db_password, $salt);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked 
                return false;
            } else {
                // Check if the password in the database matches 
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $useractive = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $useractive);

                    $_SESSION['user'] = $useractive;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
                    if (!$mysqli->query("UPDATE tm_user SET cUseAct='1' WHERE iUseID='".$user_id."'")) {
                        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
                        exit();
                    }
                    // Login successful. 
                    return true;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    if (!$mysqli->query("INSERT INTO tm_login_attempts(iUseID, cLogAttTim) 
                                    VALUES ('$user_id', '$now')")) {
                        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
                        exit();
                    }$mysqli->query();                    
                    return false;
                }
            }
        } else {
            // No user exists. 
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
        exit();
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
    if ($stmt = $mysqli->prepare("SELECT cLogAttTim 
                                  FROM tm_login_attempts 
                                  WHERE iUseID = ? AND cLogAttTim > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database Error: Cannot prepare statement");
        exit();
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT cUsePas FROM tm_user WHERE iUseID = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Could not prepare statement
            header("Location: ../error.php?err=Database Error: Cannot prepare statement");
            exit();
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {
    if ('' == $url) { return $url; }
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function measure_char($iMeaID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cMeaAbr FROM tm_measure WHERE iMeaID = ?");
    $stmt->bind_param('s', $iMeaID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($measure);
    $stmt->fetch();
    return $measure;
}

function center_char($iCenID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cCenNam FROM tm_center WHERE iCenID = ?");
    $stmt->bind_param('s', $iCenID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($center);
    $stmt->fetch();
    return $center;
}

function customer_char($iCusID, $mysqli){
    $stmt = $mysqli->prepare("SELECT cCusNam FROM tm_customer WHERE iCusID = ?");
    $stmt->bind_param('s', $iCusID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($customer);
    $stmt->fetch();
    return $customer;
}

function detail_total($iOrdID, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_order_detail WHERE iOrdID = ?");
    $stmt->bind_param('s', $iOrdID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}

function order_total($cOrdSta, $mysqli){
    $stmt = $mysqli->prepare("SELECT count(*) FROM tm_order WHERE cOrdSta = ?");
    $stmt->bind_param('s', $cOrdSta);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($total);
    $stmt->fetch();
    return $total;
}