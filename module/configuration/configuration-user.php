<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading"><i class="glyphicon icon-truck"></i>MANTENIMIENTO DE USUARIO(S)</h3>
            <div class="clearfix sepH_b">
                <div class="btn-group col_vis_menu">
                    <a href="#" data-toggle="dropdown" class="btn dropdown-toggle btn-default">COLUMNAS <span class="caret"></span></a>
                    <ul class="dropdown-menu tableMenu" id="dt_maintenance_nav">
                        <li><div class="checkbox"><label class="" for="dt_col_1"><input type="checkbox" value="0" id="dt_col_1" name="toggle-cols" checked="checked" class="uni_style"/> &check;</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_2"><input type="checkbox" value="1" id="dt_col_2" name="toggle-cols" checked="checked" class="uni_style"/> USUARIO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_3"><input type="checkbox" value="2" id="dt_col_3" name="toggle-cols" checked="checked" class="uni_style"/> NOMBRE</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_4"><input type="checkbox" value="3" id="dt_col_4" name="toggle-cols" checked="checked" class="uni_style"/> DESCRIPCION</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_5"><input type="checkbox" value="4" id="dt_col_5" name="toggle-cols" checked="checked" class="uni_style"/> EMAIL</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_6"><input type="checkbox" value="5" id="dt_col_6" name="toggle-cols" checked="checked" class="uni_style"/> PERFIL</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_7"><input type="checkbox" value="6" id="dt_col_7" name="toggle-cols" checked="checked" class="uni_style"/> ROL</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_8"><input type="checkbox" value="7" id="dt_col_8" name="toggle-cols" checked="checked" class="uni_style"/> TIPO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_9"><input type="checkbox" value="8" id="dt_col_9" name="toggle-cols" checked="checked" class="uni_style"/> ESTADO</label></div></li>
                        <li><div class="checkbox"><label class="" for="dt_col_10"><input type="checkbox" value="9" id="dt_col_10" name="toggle-cols" checked="checked" class="uni_style"/> ACCI&Oacute;N</label></div></li>
                    </ul>
                </div>
                <!-- actions for datatables -->
                <div class="dt_maintenance_actions pull-left">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn dropdown-toggle btn-default">ACCIONES <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" data-backdrop="static" href="#modal" class="add" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-plus"></i> NUEVO</a></li>
                            <li><a href="javascript:void(0);" class="trash" data-tableid="dt_maintenance"><i class="glyphicon glyphicon-trash"></i> ELIMINAR</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <table class="table table-striped table-bordered dTableR" id="dt_maintenance">
                <thead>
                    <tr>
                        <th></th>
                        <th class="center">USUARIO</th>
                        <th class="center">NOMBRE</th>
                        <th class="center">DESCRIPCION</th>
                        <th class="center">EMAIL</th>
                        <th class="center">DESCRIPCION PERFIL</th>
                        <th class="center">DESCRIPCION ROL</th>
                        <th class="center" style="width: 100px;">TIPO</th>
                        <th class="center" style="width: 100px;">ESTADO</th>
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
                    <td><b>ID:</b></td>
                    <td class="form-group"><input class="form-control" readonly="true" type="text" id="editId" name="editId" disabled="true">
                    <input class="EA hide" type="checkbox" id="editActive">
                    </td>
                </tr>
                <tr>
                    <td><b>USUARIO:</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editUser" name="editId"></td>
                </tr>
                <tr>
                    <td><b>NOMBRE:</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editName" name="editName"></td>
                </tr>
                <tr class="pwd hide">
                    <td><b>PASSWORD:</b></td>
                    <td class="form-group"><input class="form-control" type="password" id="editPassword" name="editPassword"></td>
                </tr>
                <tr class="CheckPass hide">
                    <td>
                        <label class="control-label col-sm-2">Cambiar Contrase&ntilde;a</label></td>
                    <td>
                        <div class="col-sm-8"><span style="cursor:pointer;" id="active_edit"><img src="img/gCons/unlock.png" alt="Abierto" /> <span class="act act-success">Activar</span></span></div>                        
                    </div>
                    </td>
                </tr>
                <tr>
                    <td class="form-group hide password">
                        <label class="control-label col-sm-2">Contrase&ntilde;a</label>
                    </td>
                    <td class="form-group hide password">
                        <div class="col-sm-8">
                            <input id="editUserPassword" name="editUserPassword" class="input-xlarge form-control" type="password">
                            <span class="help-block">Ingrese su contrase&ntilde;a</span>
                        </div>
                    </td>                    
                </tr>
                <tr>
                    <td class="form-group hide password">
                        <label class="control-label col-sm-2">Repita Contrase&ntilde;a</label>
                    </td>
                    <td class="form-group hide password">
                        <div class="col-sm-8">
                            <input id="editUserPasswordRepeat" name="editUserPasswordRepeat" class="input-xlarge form-control" type="password">
                            <span class="help-block">Repita su contrase&ntilde;a</span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>DESCRIPCI&Oacute;N:</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editDescription" name="editDescription"></td>
                </tr>
                <tr>
                    <td><b>EMAIL:</b></td>
                    <td class="form-group"><input class="form-control" type="text" id="editEmail" name="editEmail"></td>
                </tr> 
                <tr>
                <tr>
                    <td><b>PERFIL:</b></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editProfile" name="editProfile" data-placeholder="SELECCIONE UN PERFIL..." /></td>
                </tr>
                <tr>
                    <td><b>ROL:</b></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editRole" name="editRole" data-placeholder="SELECCIONE UN ROL..." /></td>
                </tr>
                <tr>
                    <td><b>TIPO:</b></td>
                    <td class="form-group"><select class="form-control chzn_edit" id="editType" name="editType" data-placeholder="SELECCIONE UN TIPO..." /></td>
                </tr>                
                <tr>
                    <td><b>ESTADO :</b></td>
                    <td class="form-group"><input type="checkbox" id="editStatus"></td>
                </tr> 
                <tr class="hide">
                    <td><b>ACCI&Oacute;N :</b></td>
                    <td><input class="form-control" type="text" id="editAction"></td>
                </tr> 
                </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" id="save"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
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
    <script src="js/controller/crud_configuration-user.js"></script>
    <!-- lock screen-->    
    <script src="js/np/idle-time.js"></script>
    <script src="js/np/lock-screen.js"></script>
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
            $('#collapseFive').addClass(' in');
            $('#configuration-user').addClass(' active');
        });
    </script>