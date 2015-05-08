<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>COSTO REAL VS. COSTO ESTIMADO</h3>            
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
                            <li><div class="checkbox"><label class="small" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> TIPO VEH.</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> CLASE VEH.</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> CATEGOR&Iacute;A VEH.</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_9"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> PLACA</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_10"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked" class="uni_style"/> CHOFER</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_11"><input type="checkbox" value="10" id="dt_col_11" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_12"><input type="checkbox" value="11" id="dt_col_12" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_13"><input type="checkbox" value="12" id="dt_col_13" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA PLA. RECOJO</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_14"><input type="checkbox" value="12" id="dt_col_14" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA REAL RECOJO</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_15"><input type="checkbox" value="14" id="dt_col_15" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA PLA. LLEGADA</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_16"><input type="checkbox" value="15" id="dt_col_16" name="toggle-cols" checked="checked" class="uni_style"/> FECHA-HORA REAL LLEGADA</label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_17"><input type="checkbox" value="16" id="dt_col_17" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_18"><input type="checkbox" value="17" id="dt_col_18" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_19"><input type="checkbox" value="18" id="dt_col_19" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_20"><input type="checkbox" value="19" id="dt_col_20" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_21"><input type="checkbox" value="20" id="dt_col_21" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_22"><input type="checkbox" value="21" id="dt_col_22" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            <li><div class="checkbox"><label class="small" for="dt_col_23"><input type="checkbox" value="22" id="dt_col_23" name="toggle-cols" checked="checked" class="uni_style"/> </label></div></li>
                            
                        </ul>
                    </div>
                </div>
                <table class="table table-striped table-bordered dTableR" id="dt_maintenance" width="100%">
                    <thead>
                        <tr>
                            <th class="center small">NRO.SERVICIO</th>
                            <th class="center small">NRO.VIAJE</th>
                            <th class="center small">CLIENTE</th>
                            <th class="center small">PRECIO</th>
                            <th class="center small">PROVEEDOR</th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                            <th class="center small"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
    <script src="js/controller/crud_report-price.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseFour').addClass(' in');
            $('#report-price').addClass(' active');
        });
    </script>