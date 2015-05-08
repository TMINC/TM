<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>SUBASTA(S)-TRANSPORTE</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> NRO.SERVICIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> NRO.ORDEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> TIPO SERVICIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> INFORMACI&Oacute;N</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> PRECIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> FINALIZA</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_9"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked" class="uni_style"/> ACCI&Oacute;N</label></div></li>
                    </ul>
                </div>
                <!-- actions for datatables -->
                <div class="dt_maintenance_actions pull-left">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="set_free" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-flag"></i> LIBERAR</a></li>
                            <li><a href="javascript:void(0);" class="see_offer" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-search"></i> VER HISTORIAL DE OFERTAS</a></li>
                            <li><a href="javascript:void(0);" class="reset_offer" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-refresh"></i> REINICIAR</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance">
                <thead>
                    <tr>
                        <th class="center" style="width: 12px;"><input name="sel_row" class="sel_row" data-tableid="dt_maintenance" type="checkbox"></th>
                        <th class="center" style="width: 120px;">NRO.SERVICIO</th>
                        <th class="center">TIPO SERVICIO</th>
                        <th class="center">ORIGEN</th>
                        <th class="center">DESTINO</th>
                        <th class="center">PRECIO</th>
                        <th class="center" style="width: 90px;">ACCI&Oacute;N</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->    
    <!-- Editar Subasta -->
     <div class="modal" id="modal_auction">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_auction_form">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.SERVICIO :</b></td>
                                <td colspan="2"><input class="form-control hide" readonly="true" type="text" id="editId"><input class="form-control" readonly="true" type="text" id="editDetailId"></td>
                            </tr>
                            <tr>
                                <td><b>PARTICIPANTES&nbsp;:</b></td>
                                <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editCarrier" name="editCarrier" data-placeholder="SELECCIONE TRANSPORTISTAS..." multiple="" /></td>
                            </tr>
                            <tr>
                                <td><b>PRECIO INICIAL : </b></td>
                                <td class="form-group" colspan="2">
                                    <div class="input-group">
                                        <span class="input-group-addon">S/.</span>
                                        <input class="form-control" type="text" style="text-align: right;" id="editBaseAmount" name="editBaseAmount">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                 <td><b>INFORMACI&Oacute;N :</b></td>
                                <td class="form-group" colspan="2">
                                    <textarea rows="2" id="editInfo" name="editInfo" class="form-control autosize"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><b>FECHA INICIO :</b></td>
                                <td class="form-group" style="width: 40%;">
                                    <div id="startAuctionDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editStartAuctionDate" name="editStartAuctionDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_up"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editStartAuctionHour" name="editStartAuctionHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>FECHA FIN :</b></td>
                                <td class="form-group">
                                    <div id="endAuctionDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editEndAuctionDate" name="editEndAuctionDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_down"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editEndAuctionHour" name="editEndAuctionHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hide">
                                <td><b>ACCI&Oacute;N :</b></td>
                                <td colspan="2"><input class="form-control" type="text" id="editAction"></td>
                            </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="close_auction" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="save_auction"><i class="glyphicon glyphicon-save"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Hacer Ofertas -->
    <div class="modal" id="modal_offer">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_offer_form">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>MONTO INICIAL :</b><input class="form-control hide" readonly="true" type="text" id="editIdAuction"></td>
                                <td class="form-group" colspan="2">
                                    <div class="input-group f_success ">
                                        <span class="input-group-addon">S/.</span>
                                        <input class="form-control" type="text" style="text-align: right;" id="editInitialAmount" disabled="">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                               <td><b>MONTO ACTUAL :</b></td>
                               <td class="form-group" colspan="2">
                                   <div class="input-group f_warning">
                                       <span class="input-group-addon">S/.</span>
                                       <input class="form-control" type="text" style="text-align: right;" id="editCurrentAmount" disabled="">
                                       <span class="input-group-addon">.00</span>
                                   </div>
                               </td>
                            </tr>
                            <tr>
                                <td><b>MONTO A OFERTAR :</b></td>
                                <td class="form-group" colspan="2">
                                    <div class="input-group">
                                        <span class="input-group-addon">S/.</span>
                                        <input class="form-control" type="text" style="text-align: right;" id="editOfferAmount" name="editOfferAmount">
                                        <span class="input-group-addon">.00</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">                    
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="save_offer"><i class="glyphicon glyphicon-saved"></i> REALIZAR OFERTA</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Ver Ofertas -->
    <div class="modal" id="modal_offer_see">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> OFERTAS ACTUALES</h3>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered" id="table_offer">
                        <thead>
                            <tr>
                                <th class="center" style="width: 70%;text-align: center;">TRANSPORTISTA</th>
                                <th class="center" style="text-align: center;">OFERTA</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> SALIR</a>
                </div>
            </div>
        </div>
    </div>
     <!-- Asignación Directa -->
    <div class="modal" id="modal_adjudication">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-tasks" style="margin-top: 3px;font-size:15px;"></i> REASIGNACI&Oacute;N TRANSPORTE</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_adjudication">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.SERVICIO :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editId" name="editId"></td>
                            </tr>
                            <tr>
                                <td><b>SERVICIOS RELACIONADOS :</b></td>
                                <td class="form-group">
                                    <input class="form-control hide" readonly="true" type="text" id="editAllocationsID">
                                    <input class="form-control" readonly="true" type="text" id="editIds" name="editIds">
                                </td>
                            </tr>
                            <tr>
                                <td><b>PROVEEDOR TRANSPORTE ACTUAL :</b></td>
                                <td class="form-group">
                                    <input class="form-control hide" readonly="true" type="text" id="editCarrierCurrentID">
                                    <input class="form-control" readonly="true" type="text" id="editCarrierCurrent" name="editCarrierCurrent">
                                </td>
                            </tr>
                            <tr>
                                <td><b>PROVEEDOR TRANSPORTE NUEVO :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editCarrierNew" name="editCarrierNew" data-placeholder="SELECCIONE UN PROVEEDOR..." /></td>
                            </tr>
                            <tr>
                                <td><b>MOTIVO :</b></td>
                                <td class="form-group">
                                    <textarea rows="2" id="editReason" name="editReason" class="form-control autosize"></textarea>
                                </td>
                            </tr>
                        </table>
                    </form> 
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="adjudication_close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="adjudication_save"><i class="glyphicon glyphicon-save"></i> GUARDAR</a>
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
    <script src="lib/datepicker/locales/bootstrap-datepicker.es.js"></script>
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
    <script src="js/controller/crud_allocation-auction.js"></script>
    <!-- countdown -->
    <script src="js/jquery.countdown.min.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseThree').addClass(' in');
            $('#allocation-auction').addClass(' active');
        });
    </script>