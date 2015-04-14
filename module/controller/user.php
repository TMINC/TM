<?php
/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
?>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <h3 class="heading">MI PERFIL</h3>
            <form class="form-horizontal" id="validation_form">
                <fieldset>
                    <div class="form-group hide">
                        <label class="control-label col-sm-2">ID</label>
                        <div class="col-sm-8">
                            <input id="editUserId" name=="editUserId" class="input-xlarge form-control" value="<?php echo $_SESSION['user_id'];?>" type="text">
                            <input type="checkbox" id="editActive">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Usuario</label>
                        <div class="col-sm-8">
                            <input id="editUserUser" name="editUserUser" class="input-xlarge form-control" type="text" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Descripci&oacute;n</label>
                        <div class="col-sm-8">
                            <input id="editUserDescription" name="editUserDescription" class="input-xlarge form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nombre Completo</label>
                        <div class="col-sm-8">
                            <input id="editUserName" name="editUserName" class="input-xlarge form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Correo Electr&oacute;nico</label>
                        <div class="col-sm-8">
                            <input id="editUserEmail" name="editUserEmail" class="input-xlarge form-control" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Cambiar Contrase&ntilde;a</label>
                        <div class="col-sm-8"><span style="cursor:pointer;" id="active_edit"><img src="img/gCons/unlock.png" alt="Abierto" /> <span class="act act-success">Activar</span></span></div>                        
                    </div>
                    <div class="form-group hide password">
                        <label class="control-label col-sm-2">Contrase&ntilde;a</label>
                        <div class="col-sm-8">
                            <input id="editUserPassword" name="editUserPassword" class="input-xlarge form-control" type="password">
                            <span class="help-block">Ingrese su contrase&ntilde;a</span>
                        </div>
                    </div>
                    <div class="form-group hide password">
                        <label class="control-label col-sm-2">Repita Contrase&ntilde;a</label>
                        <div class="col-sm-8">
                            <input id="editUserPasswordRepeat" name="editUserPasswordRepeat" class="input-xlarge form-control" type="password">
                            <span class="help-block">Repita su contrase&ntilde;a</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Tipo</label>
                        <div class="col-sm-8">
                            <label class="radio-inline" style="margin-left:-22px;">
                                <input value="P" id="editUserSpecial" name="editUserType" type="radio" class="uni_style">
                                Particular
                            </label>
                            <label class="radio-inline">
                                <input value="G" id="editUserGeneric" name="editUserType" type="radio" class="uni_style">
                                G&eacute;nerico
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2">Firma</label>
                        <div class="col-sm-8">
                            <textarea rows="2" id="editUserSignature" name="editUserSignature" class="form-control autosize"></textarea>
                            <span class="help-block">Automatic resize</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8 col-sm-offset-2">
                            <a href="JavaScript:void(0);" class="btn btn-primary" id="save"><i class="glyphicon glyphicon-saved"></i> GUARDAR</a>
                        </div>
                    </div>
                </fieldset>
            </form>
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
    <!-- common functions -->
    <script src="js/pages/tm_common.js"></script>
    <!-- styled form elements -->
    <script src="lib/uniform/jquery.uniform.min.js"></script>
    <!-- tooltips -->
    <script src="lib/qtip2/jquery.qtip.min.js"></script>
    <!-- autosize textareas -->
    <script src="js/forms/jquery.autosize.min.js"></script>
    <!-- chosen -->
    <script src="lib/chosen/chosen.jquery.min.js"></script>
    <!-- validations -->
    <script src="lib/validation/jquery.validate.min.js"></script>
    <script src="lib/validation/localization/messages_es.js"></script>
    <!-- crud functions -->
    <script src="js/controller/crud_profile.js"></script>
    <!-- encriptado -->
    <script src="js/np/sha512.js"></script>
    <script>
        $(document).ready(function() {
            //* show all elements & remove preloader
            setTimeout('$("html").removeClass("js")',1000);
        });
    </script>