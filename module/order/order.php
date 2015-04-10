<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>ORDEN(ES)</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> ID</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> NRO.ORDEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> CLIENTE</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> VOLUMEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> PESO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> DISTANCIA</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> COSTO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_9"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> PRECIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_10"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked" class="uni_style"/> ACCI&Oacute;N</label></div></li>
                    </ul>
                </div>
                <!-- actions for datatables -->
                <div class="dt_maintenance_actions pull-left">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" data-backdrop="static" href="#modal" class="add" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-plus"></i> NUEVO</a></li>
                            <li><a href="javascript:void(0);" class="set_free" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-flag"></i> LIBERAR</a></li>
                            <li><a href="javascript:void(0);" class="trash" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-trash"></i> ELIMINAR</a></li>
                        </ul>
                    </div>
                </div>
            </div>   
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance">
                <thead>
                    <tr>
                        <th class="center" style="width: 100px;"><input name="sel_row" class="sel_row uni_style" data-tableid="dt_maintenance" type="checkbox"></th>
                        <th class="center" style="width: 120px;">NRO.ORDEN</th>
                        <th class="center">CLIENTE</th>
                        <th class="center" style="width: 110px;">TIPO SERVICIO</th>
                        <th class="center">VOLUMEN</th>
                        <th class="center">PESO</th>
                        <th class="center">DISTANCIA</th>
                        <th class="center">COSTO</th>
                        <th class="center">PRECIO</th>
                        <th class="center" style="width: 80px;">ACCI&Oacute;N</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_form">
                <table class="table table-bordered">
                <tr>
                    <td><b>NRO.ORDEN :</b></td>
                    <td class="form-group" colspan="2"><input class="form-control" readonly="true" type="text" id="editId"></td>
                </tr>
                <tr>
                    <td><b>CLIENTE :</b></td>
                    <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editCustomer" name="editCustomer" data-placeholder="SELECCIONE CLIENTE..." /></td>
                </tr>
                <tr>
                    <td><b>TIPO DE SERVICIO :</b></td>
                    <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editType" name="editType" data-placeholder="SELECCIONE TIPO DE SERVICIO..." /></td>
                </tr>
                <tr>
                    <td><b>VOLUMEN :</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editVolume" name="editVolume"></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editMeasureVolume" name="editMeasureVolume" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                </tr>
                 <tr>
                    <td><b>PESO :</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editWeight" name="editWeight"></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editMeasureWeight" name="editMeasureWeight" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                </tr>
                <tr>
                    <td><b>DISTANCIA :</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editDistance" name="editDistance"></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editMeasureDistance" name="editMeasureDistance" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                </tr>
                <tr>
                    <td><b>COSTO :</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editPrice" name="editPrice"></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editMeasurePrice" name="editMeasurePrice" data-placeholder="SELECCIONE UNA MONEDA..." /></td>
                </tr>
                <tr>
                    <td><b>PRECIO :</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editRealPrice" name="editRealPrice"></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editMeasureRealPrice" name="editMeasureRealPrice" data-placeholder="SELECCIONE UNA MONEDA..." /></td>
                </tr>
                <tr class="hide">
                    <td><b>ESTADO :</b></td>
                    <td colspan="2"><input type="checkbox" id="editStatus" class="uni_style"></td>
                </tr> 
                <tr class="hide">
                    <td><b>ACCI&Oacute;N :</b></td>
                    <td colspan="2"><input class="form-control" type="text" id="editAction"></td>
                </tr> 
                </table>
                     </form>
                </div>
                <div class="modal-footer save hide">
                    <a href="#" class="btn btn-primary" id="save"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="detail">
        <div class="modal-dialog" style="width:80%;">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close hidden" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> DETALLE(S) - ORDEN NRO. <span id="detail_order_number" /></h3>
                </div>
                <div class="modal-body">
                    <div class="btn-group col_vis_menu">
                        <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                        <ul class="dropdown-menu tableMenu" id="dt_detail_nav">
                            <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> NRO.</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> VOLUMEN</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> PESO</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> DISTANCIA</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> COSTO</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_9"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> PRECIO</label></div></li>
                            <li><div class="checkbox ddt_col_10 hide"><label class="" for="dt_col_10"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked"/> ACCI&Oacute;N</label></div></li>
                        </ul>
                    </div>
                    <div class="clearfix sepH_b">
                        <!-- actions for datatables -->
                        <div class="dt_detail_actions pull-left">
                            <div class="btn-group accciones hide">
                                <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a data-toggle="modal" data-backdrop="static" href="#modal_detail" class="add_detail" data-tableid="dt_detail"><i class="glyphicon glyphicon-plus"></i> NUEVO</a></li>
                                    <li><a href="javascript:void(0);" class="trash_detail" data-tableid="dt_detail"><i class="glyphicon glyphicon-trash"></i> ELIMINAR</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered dTableR" id="dt_detail">
                        <thead>
                            <tr>
                                <th class="center" style="width: 90px;"><input name="sel_row" class="sel_row uni_style" data-tableid="dt_maintenance" type="checkbox"></th>
                                <th class="center">NRO.</th>
                                <th class="center">ORIGEN</th>
                                <th class="center">DESTINO</th>
                                <th class="center">VOLUMEN</th>
                                <th class="center">PESO</th>
                                <th class="center">DISTANCIA</th>
                                <th class="center">COSTO</th>
                                <th class="center">PRECIO</th>
                                <th class="center" style="width: 80px;">ACCI&Oacute;N</th>
                            </tr>                            
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="exit_detail"><i class="glyphicon glyphicon-log-out"></i> SALIR</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modal_detail">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_detail_form">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.ORDEN :</b></td>
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editDetailId"></td>
                            </tr>
                            <tr class="hidden">
                                <td><b>ID :</b></td>
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editOrderDetailId"></td>
                            </tr>
                            <tr>
                                <td><b>ORIGEN :</b></td>
                                <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editDetailOrigin" name="editDetailOrigin" data-placeholder="SELECCIONE ORIGEN..." /></td>
                            </tr>
                            <tr>
                                <td><b>FECHA - HORA (ORIGEN):</b></td>
                                <td class="form-group" style="width: 50%;">
                                    <div id="detailOriginDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDetailOriginDate" name="editDetailOriginDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_up"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editDetailOriginHour" name="editDetailOriginHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>DESTINO :</b></td>
                                <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editDetailDestination" name="editDetailDestination" data-placeholder="SELECCIONE DESTINO..." /></td>
                            </tr>
                            <tr>
                                <td><b>FECHA - HORA (DESTINO):</b></td>
                                <td class="form-group">
                                    <div id="detailDestinationDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDetailDestinationDate" name="editDetailDestinationDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_down"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editDetailDestinationHour" name="editDetailDestinationHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>VOLUMEN :</b></td>
                                <td class="form-group"><input class="form-control" type="text" id="editDetailVolume" name="editDetailVolume"></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDetailMeasureVolume" name="editDetailMeasureVolume" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                            </tr>
                            <tr>
                                <td><b>PESO :</b></td>
                                <td class="form-group"><input class="form-control" type="text" id="editDetailWeight" name="editDetailWeight"></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDetailMeasureWeight" name="editDetailMeasureWeight" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                            </tr>
                            <tr>
                                <td><b>DISTANCIA :</b></td>
                                <td class="form-group"><input class="form-control" type="text" id="editDetailDistance" name="editDetailDistance"></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDetailMeasureDistance" name="editDetailMeasureDistance" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                            </tr>
                            <tr>
                                <td><b>COSTO :</b></td>
                                <td class="form-group"><input class="form-control" type="text" id="editDetailPrice" name="editDetailPrice"></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDetailMeasurePrice" name="editDetailMeasurePrice" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                            </tr>
                            <tr>
                                <td><b>PRECIO :</b></td>
                                <td class="form-group"><input class="form-control" type="text" id="editDetailRealPrice" name="editDetailRealPrice"></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDetailMeasureRealPrice" name="editDetailMeasureRealPrice" data-placeholder="SELECCIONE U.M. DISTANCIA..." /></td>
                            </tr>
                            <tr>
                                <td><b>NOTA :</b></td>
                                <td class="form-group" colspan="2"><input class="form-control" type="text" id="editDetailNote"></td>
                            </tr>
                            <tr class="hide">
                                <td><b>ACCI&Oacute;N :</b></td>
                                <td colspan="2"><input class="form-control" type="text" id="editDetailAction"></td>
                            </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer saveD hide">
                    <a href="#" class="btn btn-primary" id="save_detail"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- hide elements-->
    <div class="hide">           
        <!-- confirmation box -->
        <div id="confirm_dialog" class="cbox_content">
            <div class="sepH_c tac"><strong>Esta seguro de eliminar el(los) registro(s)?</strong></div>
            <div class="tac">
                <a href="#" class="btn btn-gebo confirm_yes btn-default">S&iacute;</a>
                <a href="#" class="btn confirm_no btn-default">No</a>
            </div>
        </div>
        <div id="set_free_dialog" class="cbox_content">
            <div class="sepH_c tac"><strong>Esta seguro de liberar el(los) registro(s)?</strong></div>
            <div class="tac">
                <a href="#" class="btn btn-gebo set_free_yes btn-default">S&iacute;</a>
                <a href="#" class="btn set_free_no btn-default">No</a>
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
    <!-- datatable functions -->
    <script src="js/pages/tm_datatables.js"></script>
    <!-- tooltips -->
    <script src="lib/qtip2/jquery.qtip.min.js"></script>
    <!-- chosen -->
    <script src="lib/chosen/chosen.jquery.min.js"></script>
     <!-- validations -->
    <script src="lib/validation/jquery.validate.min.js"></script>
    <script src="lib/validation/localization/messages_es.js"></script>
    <!-- crud functions -->
    <script src="js/controller/crud_order.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseTwo').addClass(' in');
            $('#order').addClass(' active');
        });
    </script>