<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
if (! $error) { $error = 'Oops! Los datos de accesos son incorrectos.'; }
?>
<!DOCTYPE html>
<!--
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
-->
<html>
    <head>
        <link rel="stylesheet" href="css/style.css" />  
    </head>
    <body>
        <h4 class="alert-heading">Hubo un problema!</h4>
        <?php echo $error; ?>  
    </body>
</html>
