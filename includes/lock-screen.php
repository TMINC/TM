<!-- Modal -->
<div class="modal" id="lock-screen">
    <div class="modal-dialog" style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Transportation Management</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info alert-login" id="lock_message" style="margin-top:-5px;"></div>
                <div class="cnt_b" style="margin:15px 10px 0 10px;">
                    <form id="lock_form">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
                            <input class="form-control input-sm" type="text" readonly="true" id="lockscreenuser" name="lockscreenuser" value="<?php echo htmlentities($_SESSION['user']);?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
                            <input class="form-control input-sm" type="password" id="lockscreenpass" name="lockscreenpass" placeholder="Contrase&ntilde;a" />
                        </div>
                    </div>
                    </form>
                    <div class="form-group" style="margin-bottom: 40px;">                        
                        <button class="btn btn-gebo btn-sm pull-right" id="unlock">Desbloquear</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btm_b clearfix">
                    <span class="link_reg">¿No eres <?php echo htmlentities($_SESSION['username']);?>? <a href="includes/logout.php"> Cerrar sesi&oacute;n</a></span>
                </div>
            </div>
        </div>
    </div>
</div>