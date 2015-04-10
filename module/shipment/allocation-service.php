<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>SERVICIO(S)-TRANSPORTE</h3>
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
                <div class="dt_maintenance_actions pull-left">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:void(0);" class="plan"><i class="glyphicon glyphicon-thumbs-up"></i> PLANIFICAR</a></li>
                            <li><a href="javascript:void(0);" class="set_free" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-flag"></i> LIBERAR</a></li>
                            <li><a href="javascript:void(0);" class="refuse" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-thumbs-down"></i> RECHAZAR</a></li>
                        </ul>
                    </div>
                </div>
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
    <!-- Adjudication Type-->
    <div class="modal" id="adjudication">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-tasks" style="margin-top: 3px;font-size:15px;"></i> ADJUDICACI&Oacute;N</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_adjudication">
                        <table class="table table-bordered" >
                            <tr>
                                <td><b>TIPO :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editAdjudicationType" name="editAdjudicationType" data-placeholder="SELECCIONE TIPO DE ADJUDICACION..."></select></td>
                            </tr>
                        </table>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="adjudication_close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="adjudication_save"><i class="glyphicon glyphicon-ok"></i> CONTINUAR</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Editar Citas -->
     <div class="modal" id="modal_date">
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
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editDateId"></td>
                            </tr>
                            <tr class="hidden">
                                <td><b>ID :</b></td>
                                <td colspan="2"><input class="form-control" readonly="true" type="text" id="editOrderDateId"></td>
                            </tr>
                            <tr>
                                <td><b>ORIGEN :</b></td>
                                <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editDateOrigin" name="editDateOrigin" data-placeholder="SELECCIONE ORIGEN..." /></td>
                            </tr>
                            <tr>
                                <td><b>FECHA - HORA (ORIGEN):</b></td>
                                <td class="form-group" style="width: 50%;">
                                    <div id="dateOriginDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDateOriginDate" name="editDateOriginDate">
                                        <span class="input-group-addon"><i class="splashy-calendar_day_up"></i></span>
                                    </div>
                                </td>
                                <td class="form-group">                        
                                    <div class="input-group bootstrap-timepicker">
                                        <input class="form-control" type="text" id="editDateOriginHour" name="editDateOriginHour" readonly="true">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><b>DESTINO :</b></td>
                                <td class="form-group" colspan="2"><select class="form-control chzn_edit" id="editDateDestination" name="editDateDestination" data-placeholder="SELECCIONE DESTINO..." /></td>
                            </tr>
                            <tr>
                                <td><b>FECHA - HORA (DESTINO):</b></td>
                                <td class="form-group">
                                    <div id="dateDestinationDate" class="input-group date">
                                        <input class="form-control" type="text" readonly="" id="editDateDestinationDate" name="editDetailDestinationDate">
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
                            <tr class="hide">
                                <td><b>ACCI&Oacute;N :</b></td>
                                <td colspan="2"><input class="form-control" type="text" id="editDetailAction"></td>
                            </tr> 
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" id="save_detail"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Selección datos Transporte -->
    <div class="modal" id="adjudicationDirect">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">×</button>
                    <h3><i class="glyphicon glyphicon-tasks" style="margin-top: 3px;font-size:15px;"></i> ASIGNACI&Oacute;N TRANSPORTE</h3>
                </div>
                <div class="modal-body">
                    <form id="validation_adjudication_direct">
                        <table class="table table-bordered">
                            <tr>
                                <td><b>NRO.VIAJE :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editDirectId" name="editDirectId"></td>
                            </tr>
                            <tr>
                                <td><b>NRO.PEDIDO(S) :</b></td>
                                <td class="form-group"><input class="form-control" readonly="true" type="text" id="editDirectOrderId" name="editDirectOrderId"></td>
                            </tr>
                            <tr>
                                <td><b>PROVEEDOR TRANSPORTE :</b></td>
                                <td class="form-group"><select class="form-control chzn_edit" id="editDirectCarrier" name="editDirectCarrier" data-placeholder="SELECCIONE UN PROVEEDOR..." /></td>
                            </tr>
                        </table>
                    </form> 
                </div>
                <div class="modal-footer">
                    <a href="JavaScript:void(0);" class="btn btn-default" id="adjudication_direct_close" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> CANCELAR</a>
                    <a href="JavaScript:void(0);" class="btn btn-primary" id="adjudication_direct_save"><i class="glyphicon glyphicon-save"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    
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
                    <td colspan="2"><input type="checkbox" id="editStatus" class="uni_style"></td>
                </tr> 
                <tr class="hide">
                    <td><b>ACCI&Oacute;N :</b></td>
                    <td colspan="2"><input class="form-control" type="text" id="editAction"></td>
                </tr> 
                </table>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" id="save"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Selección datos Transporte -->
    <div class="modal fade" id="directTransport">
	    <div class="modal-dialog">
		    <div class="modal-content">
			    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				    <h3 class="modal-title">Informaci&oacute;n Transporte</h3>
			    </div>
			    <div class="modal-body">
				    <table class="table table-striped table-bordered table-condensed" id="table_edit">
                        <tr>
                            <td>Nro. Viaje</td>
                            <td><input id="numberTransport" class="form-control" type="text" disabled /></td>
                        </tr>
                        <tr>
                            <td>Nro. Cita Recojo</td>
                            <td><input id="dateTransport" class="form-control" type="text" disabled /></td>
                        </tr>
                        <tr>
                            <td>Proveedor de Transporte</td>
                            <td><select id="supplier" data-placeholder="SELECCIONE PROVEEDOR DE TRANSPORTE..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr>
                            <td>Tipo de Veh&iacute;culo<br /> 
                                <input id="newType" type="checkbox" style="float:left;"/><div style="font-size:11px;color:Blue;margin:3px 0 0 4px;float:left;">Solicitar Transporte Adicional</div>
                            </td>
                            <td><select id="typeVehicle" data-placeholder="SELECCIONE TIPO DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>                       
                        <tr>
                            <td>Clase de Veh&iacute;culo</td>
                            <td><select id="classVehicle" data-placeholder="SELECCIONE CLASE DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr class="trtransporte hide">
                            <td>Tipo de Veh&iacute;culo II</td>
                            <td><select id="typeVehicleII" data-placeholder="SELECCIONE TIPO DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>                       
                        <tr class="trtransporte hide">
                            <td>Clase de Veh&iacute;culo II</td>
                            <td><select id="classVehicleII" data-placeholder="SELECCIONE CLASE DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr>
                            <td>Clase de Documento de Transporte</td>
                            <td><select id="document" data-placeholder="SELECCIONE CLASE DE DOCUMENTO DE TRANSPORTE..." class="chzn_a form-control" style="width:330px;"></select></td>                                
                        </tr> 
                        <tr class="trorigen hide">
                            <td>Seleccione Origen</td>
                            <td><select id="origin" data-placeholder="SELECCIONE ORIGEN..." class="chzn_a form-control" style="width:330px;"/></td>                                
                        </tr>
                        <tr class="trdestino hide">
                            <td>Seleccione Destino</td>
                            <td><select id="destination" data-placeholder="SELECCIONE DESTINO..." class="chzn_a form-control" style="width:330px;"/></td>                                
                        </tr>
                        <tr class="trdestino hide">
                            <td colspan="2">Cita Entrega Destino</td>
                        </tr>
                        <tr class="trdestino hide">
                            <td colspan="2">
                                <table id="dt_citaEntregaCD">
                                <tbody></tbody>                                
                                </table>                                
                           </td>
                        </tr>
                        <tr class="trcitaEntrega hide">
                            <td colspan="2">Registre hora y fecha para la(s) cita(s) de Entrega en Destino(s)</td>
                        </tr>
                        <tr class="trcitaEntrega hide">
                            <td colspan="2">
                                <table id="dt_citaEntrega">
                                <tbody></tbody>                                
                                </table>                                
                           </td>                                
                        </tr>                        
                    </table>
			    </div>
			    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				    <button type="button" class="btn btn-primary" id="saveTransport">Guardar</button>
			    </div>
		    </div>
	    </div>
    </div>
    <!-- Selección datos Subasta -->
    <div class="modal fade" id="auctionTransport">
	    <div class="modal-dialog">
		    <div class="modal-content">
			    <div class="modal-header">
				    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				    <h3 class="modal-title">Informaci&oacute;n Subasta</h3>
			    </div>
			    <div class="modal-body">
                    <table class="table table-striped table-bordered table-condensed">
                        <tr>
                            <td width="40%">Nro. Subasta</td>
                            <td><input id="idSubasta" class="form-control" type="text" disabled /></td>
                        </tr>
                        <tr>
                            <td>Nro. Viaje</td>
                            <td><input id="numberTravel" class="form-control" type="text" disabled /></td>
                        </tr>
                        <tr>
                            <td>Nro. Cita</td>
                            <td><input id="numberDate" class="form-control" type="text" disabled /></td>
                        </tr>
                        <tr>
                            <td>Proveedor de Transporte</td>
                            <td><select id="supplierTransport" data-placeholder="SELECCIONE PARTICIPANTES..." class="chzn_a form-control" style="width:330px;" multiple="multiple"/></td>
                        </tr>
                        <tr>
                            <td>Tipo de Veh&iacute;culo<br /> 
                                <input id="newTypeSub" type="checkbox" style="float:left;"/><div style="font-size:11px;color:Blue;margin:3px 0 0 4px;float:left;">Solicitar Transporte Adicional</div>
                            </td>
                            <td><select id="typeVehSub" data-placeholder="SELECCIONE TIPO DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr>
                            <td>Clase de Veh&iacute;culo</td>
                            <td><select id="classVehSub" data-placeholder="SELECCIONE CLASE DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr class="trtransporteSub hide">
                            <td>Tipo de Veh&iacute;culo II</td>
                            <td><select id="typeVehSubII" data-placeholder="SELECCIONE TIPO DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr class="trtransporteSub hide">
                            <td>Clase de Veh&iacute;culo II</td>
                            <td><select id="classVehSubII" data-placeholder="SELECCIONE CLASE DE VEHICULO..." class="chzn_a form-control" style="width:330px;"/></td>
                        </tr>
                        <tr>
                            <td>Clase de Documento de Transporte</td>
                            <td><select id="documentSub" data-placeholder="SELECCIONE CLASE DE DOCUMENTO DE TRANSPORTE..." class="chzn_a form-control" style="width:330px;"></select></td>                                
                        </tr> 
                        <tr class="trorigenSub hide">
                            <td>Seleccione Origen</td>
                            <td><select id="originSub" data-placeholder="SELECCIONE ORIGEN..." class="chzn_a form-control" style="width:330px;"/></td>                                
                        </tr>
                        <tr class="trdestinoSub hide">
                            <td>Seleccione Destino</td>
                            <td><select id="destinationSub" data-placeholder="SELECCIONE DESTINO..." class="chzn_a form-control" style="width:330px;"/></td>                                
                        </tr>
                        <tr class="trdestinoSub hide">
                            <td colspan="2">Cita Entrega Destino</td>
                        </tr>
                        <tr class="trdestinoSub hide">
                            <td colspan="2">
                                <table id="dt_citaEntregaCDSub">
                                <tbody></tbody>                                
                                </table>                                
                           </td>
                        </tr>
                        <tr class="trcitaEntregaSub hide">
                            <td colspan="2">Registre hora y fecha para la(s) cita(s) de Entrega en Destino(s)</td>
                        </tr>
                        <tr class="trcitaEntregaSub hide">
                            <td colspan="2">
                                <table id="dt_citaEntregaSub">
                                <tbody></tbody>                                
                                </table>                                
                           </td>                                
                        </tr>
                        <tr>
                            <td>Descripci&oacute;n del Servicio</td>
                            <td><input id="descriptionTravel" class="form-control" type="text" /></td>
                        </tr>
                        <tr>
                            <td>Monto Base S/.</td>
                            <td><input id="amountTravel" class="form-control" type="text" /></td>
                        </tr>
                        <tr>
                            <td>Estado</td>
                            <td><input type="checkbox" id="editStatus" checked disabled></td>
                        </tr>
                        <tr>
                            <td>Fecha Fin de Subasta</td>
                            <td>
                                <div id="dateSelectTxt" class="input-group date">
							        <input class="form-control" readonly="" type="text" id="dateSelectS">
				                    <span class="input-group-addon"><i class="splashy-calendar_day"></i></span>
						        </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Hora Fin de Subasta</td>
                            <td>
                                <div class="input-group bootstrap-timepicker">
							        <input id="hourSelect" type="text" class="form-control detHour" value="">
							        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i> Ajustar Hora</span>
						        </div>
                            </td>
                        </tr>
                    </table>				    
			    </div>
			    <div class="modal-footer">
				    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				    <button type="button" class="btn btn-primary" id="saveAuction">Guardar</button>
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
    <script src="js/controller/crud_allocation-service.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseThree').addClass(' in');
            $('#allocation-service').addClass(' active');
        });
    </script>