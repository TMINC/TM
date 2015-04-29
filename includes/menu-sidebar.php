<?php
/**
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/

include_once 'db_connect.php';
include_once 'functions.php';

?>
    <a href="javascript:void(0)" class="sidebar_switch on_switch bs_ttip" data-placement="auto right" data-viewport="body" title="Ocultar Sidebar">Sidebar switch</a>
    <div class="sidebar">
        <div class="sidebar_inner_scroll">
            <div class="sidebar_inner">
                <form class="input-group input-group-sm">
                    <input autocomplete="off" name="query" class="search_query form-control input-sm" size="16" placeholder="Buscar..." type="text">
                    <span class="input-group-btn"><button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button></span>
                </form>
                <div id="side_accordion" class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#collapseOne" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                <i class="glyphicon glyphicon-folder-close"></i> Maestros
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapseOne">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="nav-header">Informaci&oacute;n</li>
                                    <li id="info-customer"><a href="./?mod=11">&ShortRightArrow; Cliente(s)</a></li>
                                    <li id="info-carrier"><a href="./?mod=12">&ShortRightArrow; Proveedor(es)</a></li>
                                    <li id="info-driver"><a href="./?mod=13">&ShortRightArrow; Chofer(es)</a></li>
                                    <li class="nav-header">Transporte</li>
                                    <li id="vehicle-description"><a href="./?mod=14">&ShortRightArrow; Veh&iacute;culo(s)</a></li>
                                    <li id="vehicle-type"><a href="./?mod=15">&ShortRightArrow; Tipo(s)</a></li>
                                    <li id="vehicle-class"><a href="./?mod=16">&ShortRightArrow; Clase(s)</a></li>
                                    <li id="vehicle-category"><a href="./?mod=17">&ShortRightArrow; Categor&iacute;a(s)</a></li>
                                    <li id="vehicle-group"><a href="./?mod=18">&ShortRightArrow; Grupo(s)</a></li>
                                    <li class="nav-header">Traslado</li>
                                    <li id="transfer-center"><a href="./?mod=19">&ShortRightArrow; Centro(s)</a></li>
                                    <li class="nav-header">Generales</li>
                                    <li id="other-measure"><a href="./?mod=20">&ShortRightArrow; U.Medida</a></li>
                                    <li id="info-route"><a href="./?mod=21">&ShortRightArrow; Ruta(s)</a></li>
                                 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#collapseTwo" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                <i class="glyphicon glyphicon-file"></i> Generador de Pedido
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapseTwo">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li id="order"><a href="./?mod=22">&ShortRightArrow; Pedido(s)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#collapseThree" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                <i class="glyphicon glyphicon-road"></i> Transporte
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapseThree">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="nav-header">Asignaci&oacute;n</li>
                                    <li id="allocation-service"><a href="./?mod=31">&ShortRightArrow; Servicio(s)</a></li>
                                    <li id="allocation-reasigment"><a href="./?mod=32">&ShortRightArrow; Reasiginar Servicio(s)</a></li>
                                    <li id="allocation-auction"><a href="./?mod=33">&ShortRightArrow; Subasta(s)</a></li>
                                    <li class="nav-header">Proceso</li>
                                    <li id="process-data-transport"><a href="./?mod=34">&ShortRightArrow; Registro Transportista</a></li>
                                    <li id="process-state-control"><a href="./?mod=35">&ShortRightArrow; Control de Estado(s)</a></li>
                                    <li class="divider"></li>
                                    <li id="process-tracking"><a href="./?mod=36">&ShortRightArrow; Ubicaci&oacute;n de Transporte(s)</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#collapseFour" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                <i class="glyphicon glyphicon-list-alt"></i> Reportes
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapseFour">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li id="report-service"><a href="./?mod=41">&ShortRightArrow; Nivel de Servicio</a></li>
                                    <li id="report-price"><a href="./?mod=42">&ShortRightArrow; Costo Real/Costo Estimado</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a href="#collapseFive" data-parent="#side_accordion" data-toggle="collapse" class="accordion-toggle">
                                <i class="glyphicon glyphicon-cog"></i> Configuraci&oacute;n
                            </a>
                        </div>
                        <div class="accordion-body collapse" id="collapseFive">
                            <div class="panel-body">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="nav-header">Usuario</li>
                                        <li id="configuration-profile"><a href="./?mod=51">&ShortRightArrow; Perfil(es)</a></li>
                                        <li id="configuration-rol"><a href="./?mod=52">&ShortRightArrow; Rol(es)</a></li>
                                        <li id="configuration-user"><a href="./?mod=53">&ShortRightArrow; Usuario(s)</a></li>
                                    <li class="nav-header">Sistema</li>
                                        <li id="system-form"><a href="./?mod=54">&ShortRightArrow; Form(s)</a></li>
                                    <li class="nav-header">Ayuda</li>
                                        <li id="help-tutor"><a href="./?mod=55">&ShortRightArrow; Tutorial(es)</a></li>
                                        <li id="help-manual"><a href="./?mod=56">&ShortRightArrow; Manual(es)</a></li>
                                        <li class="divider"></li>
                                        <li id="help"><a href="./?mod=57">&ShortRightArrow; Ayuda</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="push"></div>
            </div>					
            <div class="sidebar_info">
                <ul class="list-unstyled">
                    <li style="text-align: center;"><strong>ESTADO DE ORDEN(ES)</strong></li>
                    <li class="small">
                        <span class="act act-danger"><?php echo order_total("0", $mysqli)." | ".order_total("1", $mysqli);?></span>
                        <strong>&blacksquare; Rechazada(s) | Pendiente(s)</strong>
                    </li>
                    <li class="small">
                        <span class="act act-warning"><?php echo order_total("2", $mysqli);?></span>
                        <strong>&blacksquare; Liberada(s)</strong>
                    </li>
                    <li class="small">
                        <span class="act act-info"><?php echo order_total("3", $mysqli)." | ".order_total("4", $mysqli);?></span>
                        <strong>&blacksquare; Subasta | Trans. Asignado</strong>
                    </li>
                    <li class="small">
                        <span class="act act-success"><?php echo order_total("5", $mysqli);?></span>
                        <strong>&blacksquare; En Transporte</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>    
