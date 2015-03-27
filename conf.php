<?php
$mcc_dir = rtrim(realpath(dirname(__FILE__)), DIRECTORY_SEPARATOR);
if($manager = opendir("$mcc_dir/class/")){
    while(($file = readdir($manager)) !== false) 
        if($file != "." and $file != "..") 
            if(strtolower(end(explode(".", $file))) == "php") require_once "$mcc_dir/class/$file";
    closedir($manager);   
}
$cn = Connect::getInstance();
$today= date('Y-m-d');
define('URL_PATH','http://'. $_SERVER['HTTP_HOST'] .'/AssetTrack/');
?>