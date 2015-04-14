/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    profile.dt_maintenance();
});

profile = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {   
    var _id = $("#editUserId").val();
    $.ajax({
        type: "POST",
        url: "module/controller/crud/user.php",
        data: "action=select&id="+ _id,
        success: function (response) {
            $("#editUserUser").val(response.user);
            $("#editUserName").val(response.name);
            $("#editUserDescription").val(response.description);
            $("#editUserEmail").val(response.email);
            $("#editUserSignature").val(response.signature);
            if(response.type=='G'){
                $("#editUserGeneric").attr("checked", true);
            }else{
                $("#editUserSpecial").attr("checked", true);
            }
            unistyle();
            popover();
            guardar();
            activar();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var popover = function (){
    $(".pop_over").popover();
};
var activar = function () {
    $("#active_edit").off().on('click', function (e) {
        e.preventDefault();
        var _active = 0;
        if($("#editActive").is(':checked')){_active=1;}else{_active=0;};
        if(_active==1){
            $(".password").addClass("hide");$("#editActive").removeAttr('checked');
            $("#active_edit").html('<img src="img/gCons/lock.png" alt="Cerrado" /> <span class="act act-warning">Inactivar</span>');
        }else{
            $(".password").removeClass("hide");$("#editActive").attr('checked','checked');
            $("#active_edit").html('<img src="img/gCons/unlock.png" alt="Abierto" /> <span class="act act-success">Activar</span>');
        }
     });
};
var guardar = function () {
    $("#save").off().on('click', function (e) {
        e.preventDefault();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editUserUser: { required: true, minlength: 3 },
                editUserDescription: { required: true, minlength: 3 },
                editUserName: { required: true },
                editUserEmail: { required: true, email: true },
                editUserPassword: {
                    required: true,
                    minlength: 5
                },
                editUserPasswordRepeat: {
                    required: true,
                    minlength: 5,
                    equalTo: "#editUserPassword"
                },
                editUserSignature: { required: true }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass("f_error");     
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass("f_error");    
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            }
        }).form()){
            var _id = $("#editUserId").val();
            var _user = $("#editUserUser").val();
            var _name = $("#editUserName").val();
            var _description = $("#editUserDescription").val();
            var _email = $("#editUserEmail").val();
            var _signature = $("#editUserSignature").val();
            var _prestatus = $("#editActive").is(':checked');
            var _status = 0;
            if(_prestatus){_status=1;}
            var _password = hex_sha512($("#editUserPassword").val());
            var _type = $('input:radio[name="editUserType"]:checked').val();
            $.ajax({
                type: "POST",
                url: "module/controller/crud/user.php",
                data: "action=update& id="+ _id+"& user="+ _user+"& name="+ _name+"& password="+ _password+"& description="+ _description+"& email="+ _email+"& signature="+ _signature+"& type="+ _type+"& status="+ _status,
                success: function () {
                    load(); 
                    $.sticky("[INFO]<br/>Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            }); 
        }
        return false;
    });
};