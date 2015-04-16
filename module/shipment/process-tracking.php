<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>UBICACI&Oacute;N DE TRANSPORTE</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &hookrightarrow;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> NRO.ORDEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> TIPO SERVICIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> CLIENTE</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> VOLUMEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> PESO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> DISTANCIA</label></div></li>                        
                    </ul>
                </div>
                <!-- actions for datatables -->
            
            </div>
            
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th class="center" style="width: 120px;">NRO.ORDEN</th>
                        <th class="center">CLIENTE</th>
                        <th class="center">TIPO SERVICIO</th>
                        <th class="center">VOLUMEN</th>
                        <th class="center">&nbsp;&nbsp;&nbsp;PESO&nbsp;&nbsp;&nbsp;</th>
                        <th class="center">DISTANCIA</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
  
    <!-- Detalle Tracking -->
  
    <div class="modal" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                <table class="table table-bordered">
                <tr>
                    <td><b>NRO.ORDEN :</b></td>
                    <td colspan="2"><input class="form-control" readonly="true" type="text" id="editId"></td>
                </tr>
                <tr>
                    <td><b>TIPO DE SERVICIO :</b></td>
                    <td colspan="2"><select class="form-control chzn_edit" id="editType" data-placeholder="SELECCIONE TIPO DE SERVICIO..." /></td>
                </tr>
                <tr>
                    <td><b>VOLUMEN:</b></td>
                    <td><input class="form-control" type="text" id="editVolume"></td>
                    <td><select class="form-control chzn_edit" id="editMeasureVolume" data-placeholder="SELECCIONE U.M. VOLUMEN..." /></td>
                </tr>
                <tr>
                    <td><b>PESO :</b></td>
                    <td><input class="form-control" type="text" id="editWeight"></td>
                    <td><select class="form-control chzn_edit" id="editMeasureWeight" data-placeholder="SELECCIONE U.M. PESO..." /></td>
                </tr>
                <tr>
                    <td><b>DISTANCIA :</b></td>
                    <td><input class="form-control" type="text" id="editDistance"></td>
                    <td><select class="form-control chzn_edit" id="editMeasureDistance" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                </tr>
                <tr>
                    <td><b>COSTO :</b></td>
                    <td><input class="form-control" type="text" id="editPrice"></td>
                    <td><select class="form-control chzn_edit" id="editMeasurePrice" data-placeholder="SELECCIONE UNA MONEDA..." /></td>
                </tr>
                <tr>
                    <td><b>PRECIO :</b></td>
                    <td><input class="form-control" type="text" id="editRealPrice"></td>
                    <td><select class="form-control chzn_edit" id="editMeasureRealPrice" data-placeholder="SELECCIONE UNA MONEDA..." /></td>
                </tr>
                <tr class="hide">
                    <td><b>ESTADO :</b></td>
                    <td colspan="2"><input type="checkbox" id="editStatus"></td>
                </tr> 
                <tr class="hide">
                    <td><b>ACCI&Oacute;N :</b></td>
                    <td colspan="2"><input class="form-control" type="text" id="editAction"></td>
                </tr> 
                </table>
                </div>
                                                                                    
            </div>
        </div>
    </div>
       <!-- Mapa --> 
    <div class="row">
        <div class="col-sm-3 col-md-3 hide" id="g-map-top">
            <div class="well">
                <form class="input-group" id="gmap_search">
                    <input autocomplete="off" class="form-control" type="text" placeholder="Buscar una ubicaci&oacute;n...">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="splashy-marker_rounded_add"></i></button>
                    </span>
                </form>
            </div>
        </div>        
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="well">
                <div id="g_map" style="width:100%;height:400px"></div>
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
     <!-- maps functions -->
    <script src="js/gmap3.min.js"></script>
    <!-- crud functions -->
    <script src="js/controller/crud_process-tracking.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseThree').addClass(' in');
            $('#process-tracking').addClass(' active');
        });
    </script>