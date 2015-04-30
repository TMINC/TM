<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading">CONTROL DE ESTADOS</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> NRO.</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> TIPO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> VEH&Iacute;CULO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> ACCI&Oacute;N</label></div></li>
                    </ul>
                </div>              
            </div>   
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance" style="cursor:">
                <thead>
                    <tr>
                        <th class="center" style="width: 120px;">NRO.SERVICIO</th>                        
                        <th class="center">TIPO SERVICIO</th>
                        <th class="center">ORIGEN</th>
                        <th class="center">DESTINO</th>
                        <th class="center" style="width: 250px;">VEH&Iacute;CULO</th>
                        <th class="center" style="width: 80px;">ACCI&Oacute;N</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal Estados -->
    <div class="modal" id="modal_state">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_state">
                        <table class="table table-bordered">
                            <tr class="centerStart">
                                <td><b>INICIO DE CARGA :</b></td>
                               <td> 
                                   <input id="cchargingStart" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="chargingStart" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                            <tr class="centerStart">
                                <td><b>FIN DE CARGA :</b></td>
                               <td> 
                                   <input id="cchargingEnd" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="chargingEnd" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                          <tr class="centerStart">
                              <td><b>EN TR&Aacute;NSITO :</b></td>
                               <td> 
                                   <input id="ctransit" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="transit" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                           <tr class="centerEnd">
                                <td><b>LLEGADA DESTINO :</b></td>
                               <td> 
                                   <input id="cArrivalDestination" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="ArrivalDestination" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                           <tr class="centerEnd">
                                <td><b>INICIO DESCARGA :</b></td>
                               <td> 
                                   <input id="cStartDownload" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="StartDownload" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                           <tr class="centerEnd">
                               <td><b>FIN DE TRANSPORTE :</b></td>
                               <td> 
                                   <input id="cEndTransportation" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                   <input id="EndTransportation" class="form-control" readonly="true" type="text" style="width:70%;float:left;" />
                               </td>
                           </tr>
                           <tr class="hide">
                               <td><b>ACCI&Oacute;N :</b></td>
                               <td><input class="form-control" type="text" id="editAction"></td>
                           </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-log-out"></i> SALIR</a>
                </div>
            </div>
        </div>
    </div>    
    <!-- Modal Datos T-->
    <div class="modal" id="modal_transport">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_transport">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>PROVEEDOR :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editCarrier" name="editCarrier"></td>
                            </tr>
                            <tr>
                                <td><b>TIPO DE VEH&Iacute;CULO :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editType" name="editType"></td>
                            </tr>
                            <tr>
                                <td><b>CHOFER :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" disabled="true" id="editDriver" name="editDriver" data-placeholder="SELECCIONE UN CHOFER..." /></td>
                            </tr>
                            <tr>
                                <td><b>PLACA :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" disabled="true" id="editPlate" name="editPlate" data-placeholder="SELECCIONE UNA PLACA..." /></td>
                            </tr>
                            <tr>
                                <td><b>IMEI :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editIMEI" name="editIMEI"></td>
                            </tr>   
                            <tr class="hide">
                                <td><b>ACCI&Oacute;N :</b></td>
                                <td><input class="form-control" type="text" id="editAction"></td>
                            </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-primary" data-dismiss="modal"><i class="glyphicon glyphicon-log-out"></i> SALIR</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- hide elements-->
    <div class="hide">           
        
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
    <script src="js/controller/crud_process-state-control.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseThree').addClass(' in');
            $('#process-state-control').addClass(' active');
        });
    </script>