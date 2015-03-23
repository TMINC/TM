<!DOCTYPE html>
<html lang="es" class="login_page">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TM 3.0</title>
    <!-- Bootstrap framework -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <!-- theme color-->
    <link rel="stylesheet" href="css/blue.css" />
    <!-- tooltip -->    
    <link rel="stylesheet" href="lib/qtip2/jquery.qtip.min.css" />
    <!-- main styles -->
    <link rel="stylesheet" href="css/style.css" />    
    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico" />    
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="js/ie/html5.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <![endif]-->	
</head>
<body>
    <div class="login_box">			
        <form id="login_form">
            <div class="top_b">Transportation Management</div>    
            <div class="alert alert-info alert-login" id="l_message">
                Bienvenid@, ingrese su usuario y contrase&ntilde;a.
            </div>
            <div class="cnt_b">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control input-sm" type="text" id="username" name="username" placeholder="Usuario" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control input-sm" type="password" id="password" name="password" placeholder="Contrase&ntilde;a" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox"><label><input type="checkbox" id="remember" name="remember" /> Mantener la sesi&oacute;n iniciada</label></div>
                </div>
            </div>
            <div class="btm_b clearfix">
                <button class="btn btn-default btn-sm pull-right" id="l_send">Iniciar sesi&oacute;n</button>
                <span class="link_reg">¿No tienes cuenta TM? <a href="#reg_form">Reg&iacute;strate ahora</a></span>
            </div>
        </form>			
        <form id="pass_form" style="display:none">
            <div class="top_b">Transportation Management</div>    
                <div class="alert alert-info alert-login" id="p_message">
                Porfavor ingrese su correo electr&oacute;nico. Usted recibira un link con una nueva contrase&ntilde;a v&iacute;a email.
            </div>
            <div class="cnt_b">
                <div class="formRow clearfix">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">@</span>
                        <input type="text" placeholder="Su correo electr&oacute;nico" id="p_email" name="p_email" class="form-control input-sm" />
                    </div>
                </div>
            </div>
            <div class="btm_b tac">
                <button class="btn btn-default" ip="p_send">Solicitar Nueva Contrase&ntilde;a</button>
            </div>  
        </form>
	
        <form id="reg_form" style="display:none">
            <div class="top_b">Transportation Management</div>
            <div class="alert alert-warning alert-login">
                Complete el siguiente formulario y luego "Registrar", con esto usted acepta los <a data-toggle="modal" href="#terms">t&eacute;rminos del servicio</a>.
            </div>
            <div id="terms" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">T&eacute;rminos y Condiciones</h3>
                        </div>
                        <div class="modal-body">
                            <p>
                                Nulla sollicitudin pulvinar enim, vitae mattis velit venenatis vel. Nullam dapibus est quis lacus tristique consectetur. Morbi posuere vestibulum neque, quis dictum odio facilisis placerat. Sed vel diam ultricies tortor egestas vulputate. Aliquam lobortis felis at ligula elementum volutpat. Ut accumsan sollicitudin neque vitae bibendum. Suspendisse id ullamcorper tellus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum at augue lorem, at sagittis dolor. Curabitur lobortis justo ut urna gravida scelerisque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aliquam vitae ligula elit.
                                Pellentesque tincidunt mollis erat ac iaculis. Morbi odio quam, suscipit at sagittis eget, commodo ut justo. Vestibulum auctor nibh id diam placerat dapibus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Suspendisse vel nunc sed tellus rhoncus consectetur nec quis nunc. Donec ultricies aliquam turpis in rhoncus. Maecenas convallis lorem ut nisl posuere tristique. Suspendisse auctor nibh in velit hendrerit rhoncus. Fusce at libero velit. Integer eleifend sem a orci blandit id condimentum ipsum vehicula. Quisque vehicula erat non diam pellentesque sed volutpat purus congue. Duis feugiat, nisl in scelerisque congue, odio ipsum cursus erat, sit amet blandit risus enim quis ante. Pellentesque sollicitudin consectetur risus, sed rutrum ipsum vulputate id. Sed sed blandit sem. Integer eleifend pretium metus, id mattis lorem tincidunt vitae. Donec aliquam lorem eu odio facilisis eu tempus augue volutpat.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cnt_b">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-user"></i></span>
                        <input class="form-control input-sm" type="text" id="r_username" name="r_username" placeholder="Usuario" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm"><i class="glyphicon glyphicon-lock"></i></span>
                        <input class="form-control input-sm" type="password" id="r_password" name="r_password" placeholder="Contrase&ntilde;a" value="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon input-sm">@</span>
                        <input class="form-control input-sm" type="text" id="r_email" name="r_email" placeholder="Correo Electr&oacute;nico" value="">
                    </div>
                    <span class="help-block">El correo electr&oacute;nico no se publicara y solo es de uso para recuperar su contrase&ntilde;a.</span>
                </div>
            </div>
            <div class="btm_b tac">
                <button class="btn btn-default" id="r_send">Registrar</button>
            </div>  
        </form>
        <div class="links_b links_btm clearfix">
            <span class="linkform"><a href="#pass_form">¿No puedes acceder a tu cuenta?</a></span>
            <span class="linkform" style="display:none">No importa, <a href="#login_form">enviarme a iniciar sesi&oacute;n</a></span>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.actual.min.js"></script>
    <script src="lib/validation/jquery.validate.min.js"></script>
    <script src="lib/validation/localization/messages_es.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/np/sha512.js"></script>
    <script src="js/np/login.js"></script>
</body>
</html>