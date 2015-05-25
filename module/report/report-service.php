<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>NIVEL DE SERVICIO</h3>
            <div class="tabbable">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_table" data-toggle="tab">CUADRO</a></li>
                    <li><a href="#tab_graph" data-toggle="tab">GR&Aacute;FICA</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_table">
                        <div class="col-sm-12 col-md-12">
                            <div class="clearfix sepH_b">
                                <div class="btn-group col_vis_menu" style="float:left;">
                                    <a href="JavaScript:void(0);" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                                        <li><div class="checkbox"><label class="small" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> NRO.SERVICIO</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> NRO.VIAJE</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> CLIENTE</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> CALIFICACI&Oacute;N</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> PROVEEDOR</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> CLASE VEH.</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> TIPO VEH.</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> CATEGOR&Iacute;A VEH.</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_9"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> PLACA</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_10"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked" class="uni_style"/> CHOFER</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_11"><input type="checkbox" value="10" id="dt_col_11" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_12"><input type="checkbox" value="11" id="dt_col_12" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_13"><input type="checkbox" value="12" id="dt_col_13" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA PLAN. RECOJO</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_14"><input type="checkbox" value="12" id="dt_col_14" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA REAL RECOJO</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_15"><input type="checkbox" value="14" id="dt_col_15" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA PLAN. LLEGADA</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_16"><input type="checkbox" value="15" id="dt_col_16" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA REAL LLEGADA</label></div></li>
                                        <li><div class="checkbox"><label class="small" for="dt_col_17"><input type="checkbox" value="16" id="dt_col_17" name="toggle-cols" checked="checked" class="uni_style"/> OBSERVACI&Oacute;N</label></div></li>
                                    </ul>
                                </div>
                            </div>
                            <table class="table table-striped table-condensed" id="dt_maintenance" >
                                <thead>
                                    <tr>
                                        <th class="center small">&nbsp;NRO.SERVICIO&nbsp;</th>
                                        <th class="center small">&nbsp;NRO.VIAJE</th>
                                        <th class="center small">&nbsp;CLIENTE&nbsp;</th>
                                        <th class="center small">&nbsp;CALIFICACI&Oacute;N&nbsp;</th>
                                        <th class="center small">&nbsp;PROVEEDOR&nbsp;</th>
                                        <th class="center small">&nbsp;TIPO&nbsp;VEH.&nbsp;</th>
                                        <th class="center small">&nbsp;CLASE&nbsp;VEH.&nbsp;</th>
                                        <th class="center small">&nbsp;CATEGOR&Iacute;A&nbsp;VEH.&nbsp;</th>
                                        <th class="center small">&nbsp;PLACA&nbsp;</th>
                                        <th class="center small">&nbsp;CHOFER&nbsp;</th>
                                        <th class="center small">&nbsp;ORIGEN&nbsp;</th>
                                        <th class="center small">&nbsp;DESTINO&nbsp;</th>
                                        <th class="center small">&nbsp;FECHA-HORA&nbsp;PLAN.&nbsp;RECOJO&nbsp;</th>
                                        <th class="center small">&nbsp;FECHA-HORA&nbsp;REAL&nbsp;RECOJO&nbsp;</th>
                                        <th class="center small">&nbsp;FECHA-HORA&nbsp;PLAN.&nbsp;LLEGADA&nbsp;</th>
                                        <th class="center small">&nbsp;FECHA-HORA&nbsp;REAL&nbsp;LLEGADA&nbsp;</th>
                                        <th class="center small">&nbsp;OBSERVACIONES&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_graph">
                        
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <!-- JQuery Implementation -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate.min.js"></script>
    <script src="lib/jquery-ui/jquery-ui-1.10.0.custom.min.js"></script>
    <!-- touch events for jquery ui-->
    <script src="js/forms/jquery.ui.touch-punch.min.js"></script>
    <!-- easing plugin -->
    <script src="js/jquery.easing.1.3.min.js"></script>
    <!-- smart resize event -->
    <script src="js/jquery.debouncedresize.min.js"></script>
    <!-- js cookie plugin -->
    <script src="js/jquery_cookie_min.js"></script>
    <!-- main bootstrap js -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- bootstrap plugins -->
    <script src="js/bootstrap.plugins.min.js"></script>
    <!-- typeahead -->
    <script src="lib/typeahead/typeahead.min.js"></script>
    <!-- code prettifier -->
    <script src="lib/google-code-prettify/prettify.min.js"></script>
    <!-- sticky messages -->
    <script src="lib/sticky/sticky.min.js"></script>
    <!-- lightbox -->
    <script src="lib/colorbox/jquery.colorbox.min.js"></script>
    <!-- jBreadcrumbs -->
    <script src="lib/jBreadcrumbs/js/jquery.jBreadCrumb.1.1.min.js"></script>
    <!-- hidden elements width/height -->
    <script src="js/jquery.actual.min.js"></script>
    <!-- custom scrollbar -->
    <script src="lib/slimScroll/jquery.slimscroll.js"></script>
    <!-- fix for ios orientation change -->
    <script src="js/ios-orientationchange-fix.js"></script>
    <!-- to top -->
    <script src="lib/UItoTop/jquery.ui.totop.min.js"></script>
    <!-- mobile nav -->
    <script src="js/selectNav.js"></script>
    <!-- moment.js date library -->
    <script src="lib/moment/moment.min.js"></script>
    <!-- masked inputs -->
    <script src="js/forms/jquery.inputmask.min.js"></script>
    <!-- datepicker -->
    <script src="lib/datepicker/bootstrap-datepicker.min.js"></script>
    <!-- timepicker -->
    <script src="lib/timepicker/js/bootstrap-timepicker.min.js"></script>
    <!-- common functions -->
    <script src="js/pages/tm_common.js"></script>
    <!-- styled form elements -->
    <script src="lib/uniform/jquery.uniform.min.js"></script>    
    <!-- datatable -->
    <script src="lib/datatables/jquery.dataTables.min.js"></script>
    <script src="lib/datatables/extras/Scroller/media/js/dataTables.scroller.min.js"></script>
    <!-- datatable table tools -->
    <script src="lib/datatables/extras/TableTools/media/js/TableTools.min.js"></script>
    <script src="lib/datatables/extras/TableTools/media/js/ZeroClipboard.js"></script>
    <!-- datatables bootstrap integration -->
    <script src="lib/datatables/jquery.dataTables.bootstrap.min.js"></script>
    <!-- tooltips -->
    <script src="lib/qtip2/jquery.qtip.min.js"></script>
    <!-- chosen -->
    <script src="lib/chosen/chosen.jquery.min.js"></script>
    <!-- validations -->
    <script src="lib/validation/jquery.validate.min.js"></script>
    <script src="lib/validation/localization/messages_es.js"></script>
    <!-- crud functions -->
    <script src="js/controller/crud_report-service.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseFour').addClass(' in');
            $('#report-service').addClass(' active');
        });
    </script>