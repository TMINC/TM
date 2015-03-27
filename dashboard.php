<?php
/**
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TM v3.1</title>
    <!-- Bootstrap framework -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <!-- jQuery UI theme -->
    <link rel="stylesheet" href="lib/jquery-ui/css/Aristo/Aristo.css" />
    <!-- breadcrumbs -->
    <link rel="stylesheet" href="lib/jBreadcrumbs/css/BreadCrumb.css" />
    <!-- tooltips-->
    <link rel="stylesheet" href="lib/qtip2/jquery.qtip.min.css" />
    <!-- colorbox -->
    <link rel="stylesheet" href="lib/colorbox/colorbox.css" />
    <!-- code prettify -->
    <link rel="stylesheet" href="lib/google-code-prettify/prettify.css" />
    <!-- sticky notifications -->
    <link rel="stylesheet" href="lib/sticky/sticky.css" />
    <!-- aditional icons -->
    <link rel="stylesheet" href="img/splashy/splashy.css" />
    <!-- flags -->
    <link rel="stylesheet" href="img/flags/flags.css" />
    <!-- datatables -->
    <link rel="stylesheet" href="lib/datatables/extras/TableTools/media/css/TableTools.css">
    <!-- datepicker -->
    <link rel="stylesheet" href="lib/datepicker/datepicker.css" />
    <!-- datepicker -->
    <link rel="stylesheet" href="lib/timepicker/css/bootstrap-timepicker.css" />
    <!-- tag handler -->
    <link rel="stylesheet" href="lib/tag_handler/css/jquery.taghandler.css" />
    <!-- uniform -->
    <link rel="stylesheet" href="lib/uniform/Aristo/uniform.aristo.css" />
    <!-- multiselect -->
    <link rel="stylesheet" href="lib/multi-select/css/multi-select.css" />
    <!-- chosen.css -->
    <link rel="stylesheet" href="lib/chosen/chosen.css" />
    <!-- hint.css -->
    <link rel="stylesheet" href="lib/hint_css/hint.min.css" />
    <!-- main styles -->
    <link rel="stylesheet" href="css/style.css" />
    <!-- switch buttons -->
    <link rel="stylesheet" href="lib/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css" />
    <!-- theme color-->
    <link rel="stylesheet" href="css/blue.css" id="link_theme" />
    <!-- theme font -->
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/ie.css" />
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="js/ie/html5.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="lib/flot/excanvas.min.js"></script>
    <![endif]-->    
</head>
<body class="full_width">
    <div id="maincontainer" class="clearfix">
    <!-- header -->
        <header>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="brand pull-left" href="./">TMPanel <span class="sml_t">3.0</span></a>
                    <?php //include("includes/menu-head.php");?>
                    <ul class="nav navbar-nav user_menu pull-right">
                        <li class="divider-vertical hidden-sm hidden-xs"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle nav_condensed" data-toggle="dropdown"><i class="flag-es"></i> <b class="caret"></b></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="javascript:void(0)"><i class="flag-de"></i> Deutsch</a></li>
                                <li><a href="javascript:void(0)"><i class="flag-fr"></i> Français</a></li>
                                <li><a href="javascript:void(0)"><i class="flag-gb"></i> English</a></li>
                                <li><a href="javascript:void(0)"><i class="flag-ru"></i> Pусский</a></li>
                            </ul>
                        </li>
                        <li class="divider-vertical hidden-sm hidden-xs"></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="img/user_avatar.png" alt="" class="user_avatar"><?php echo htmlentities($_SESSION['username']);?><b class="caret"></b></a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a href="./?mod=8">Mi Perfil</a></li>
                                <li><a href="javascrip:void(0)">Acerca de...</a></li>
                                <li class="divider"></li>
                                <li><a href="includes/logout.php">Cerrar Sesi&oacute;n</a></li>
                            </ul>
                        </li>
                    </ul>                   
                </div>
            </div>
        </nav>    
        </header>
        <!--start main content-->
        <div id="contentwrapper">
            <div class="main_content"><?php include('directory.php');?></div>			
        </div>                   
        <!--end main content-->
        <!--start sidebar-->
        <?php include("includes/menu-sidebar.php");?>
        <?php include("includes/lock-screen.php");?>
        <!--end sidebar-->
    </div>    
</body>
</html>