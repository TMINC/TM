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
                            <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> NRO.</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> ORIGEN</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> DESTINO</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> DATOS DE TRANSPORTISTA</label></div></li>
                            <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> ESTADO VIAJE</label></div></li>
                            
                    </ul>
                </div>
              
            </div>   
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance" style="cursor:">
                <thead>
                    <tr>
                        <th class="center">NRO.</th>
                        <th class="center">ORIGEN</th>
                        <th class="center">DESTINO</th>
                        <th class="center">DATOS TRANSPORTE</th>
                        <th class="center">ESTADO DE VIAJE</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modal_state">
        <div class="modal-dialog">
            <div class="modal-content">        
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-file" style="margin-top: 3px;font-size:15px;"></i> EDICI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_form">
                        <table class="table table-bordered">
                         <tr class="centerStart">
                            <td>Inicio de Carga</td>
                            <td> 
                                <input id="cchargingStart" type="checkbox" style="float:left;margin:11px 10px 0 0;" /> 
                                <input id="chargingStart" class="form-control" type="text" style="width:70%;float:left;" />
                            </td>
                        </tr>
                         <tr class="centerStart">
                            <td>Fin de Carga</td>
                            <td> 
                                <input id="cchargingEnd" type="checkbox" style="float:left;margin:11px 10px 0 0;" /> 
                                <input id="chargingEnd" class="form-control" type="text" style="width:70%;float:left;" />
                            </td>
                        </tr>
                       <tr class="centerStart">
                           <td>En Tr&aacute;nsito</td>
                            <td> 
                                <input id="ctransit" type="checkbox" style="float:left;margin:11px 10px 0 0;" /> 
                                <input id="transit" class="form-control" type="text" style="width:70%;float:left;" />
                            </td>
                        </tr>
                        <tr class="centerEnd">
                            <td>Llegada Destino</td>
                            <td> 
                                <input id="cArrivalDestination" type="checkbox" style="float:left;margin:11px 10px 0 0;" /> 
                                <input id="ArrivalDestination" class="form-control" type="text" style="width:70%;float:left;" />
                            </td>
                        </tr>
                        <tr class="centerEnd">
                            <td>Inicio Descarga</td>
                            <td> 
                                <input id="cStartDownload" type="checkbox" style="float:left;margin:11px 10px 0 0;" /> 
                                <input id="StartDownload" class="form-control" type="text" style="width:70%;float:left;" />
                            </td>
                        </tr>
                        <tr class="centerEnd">
                            <td><b>Fin de Transporte :</b></td>
                            <td> 
                                <input id="cEndTransportation" type="checkbox" style="float:left;margin:11px 10px 0 0;" class="uni_style" /> 
                                <input id="EndTransportation" class="form-control" type="text" style="width:70%;float:left;" />
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
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="exit"><i class="glyphicon glyphicon-log-out"></i> SALIR</a>
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