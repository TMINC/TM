/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
$(document).ready(function() {
    user.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            console.log(element);
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});
user = {    
    dt_maintenance: function() {             
        load();
        $("#editProfile").change(function(){
            var _per = $('#editProfile :selected').val();
            $("#editRole").empty();
            var _sel='0';
            $.ajax({
                type: "POST",
                async:false,
                url: "module/configuration/crud/configuration-role.php",
                data: "action=consultRole&sel="+ _sel+"&prof="+ _per,
                success: function (data) { $("#editRole").append('<option selected="true"> </option>'); $("#editRole").append(data); }        
            });        
            chosen();
            $("#editRole").trigger("liszt:updated"); 
        });
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/configuration/crud/configuration-user.php",
        data: "action=select&option=0",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
            unistyle();
            maskinput();
            popover();
            chosen();
            agregar();
            editar();
            eliminar();
            guardar();
        }        
    });
};

var unistyle = function (){
    $(".uni_style").uniform();  
};
var maskinput = function (){
   //$("#editTime").inputmask("99:99:99");
};
var popover = function (){
    $(".pop_over").popover();
};
var chosen = function (){
    $(".chzn_edit").chosen();
};
var table = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_maintenance').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }    
    if($('#dt_maintenance').length){
        $('#dt_maintenance').dataTable({
            "sDom": "<'row'<'col-sm-4'l><'col-sm-4 text-right'T><'col-sm-4'f>r>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "copy",
                        "sButtonText": "Copiar"
                    },
                    {
                        "sExtends": "print",
                        "sButtonText": "Imprimir"
                    },
                    {
                        "sExtends":    "collection",
                        "sButtonText": 'Guardar <span class="caret" />',
                        "aButtons":    [ "csv", "xls", "pdf" ]
                    }
                ],
                "sSwfPath": "lib/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf"
            },
            "aaSorting": [[1, "asc"]],
            "iDisplayLength": -1,
            "aLengthMenu": [[-1, 100, 50, 25], ["[ * ]", 100, 50, 25]],
            "oLanguage": {
                "sSearch": "Buscar por: ",
                "sLengthMenu": "Mostrar _MENU_ registro(s).",
                "sEmptyTable": "No hay registros para mostrar",
                "sInfo": "Mostrando _START_ al _END_ de _TOTAL_ registro(s)",
                "sInfoEmpty": "Mostrando 0 al 0 de 0 registro(s)",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sPrevious": "Último",
                    "sNext": "Siguiente",
                    "sLast": "Anterior"
                }
            },
            "aoColumns": [
                    { "bSortable": false },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" }
                ],
            "sPaginationType": "bootstrap"
        });
        $('#dt_maintenance_nav').off().on('click', 'li input', function(){
            fnShowHide($(this).val());
        });
        $('#dt_maintenance').off().on('click', 'tbody tr td img', function(){
            var oTable = $('#dt_maintenance').dataTable();
            var nTr = $(this).parents('tr')[0];            
        });
    }
};
var agregar = function(){
    $(".add").off().on('click', function (e) {
        e.preventDefault();
        $("#editId").val("");
        $("#editName").val("");
        $("#editUser").val("");
        $("#editPassword").val("");
        $("#editDescription").val("");
        $("#editEmail").val("");
         
        $("#editProfile").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editProfile").append('<option selected="true"> </option>'); $("#editProfile").append(data); }        
        });        
        chosen();
        $("#editProfile").trigger("liszt:updated"); 
        
        var _per = $('#editProfile :selected').val();
        $("#editRole").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consultRole&sel="+ _sel+"&prof="+ _per,
            success: function (data) { $("#editRole").append('<option selected="true"> </option>'); $("#editRole").append(data); }        
        });        
        chosen();
        $("#editRole").trigger("liszt:updated");
        
        $("#editType").empty();
        $('#editType').append('<option selected="selected"></option>');
        $('#editType').append('<option value="G">GENERICO</option>');
        $('#editType').append('<option value="I">INTERNO</option>');
        $('#editType').chosen();
        $("#editType").trigger("liszt:updated");
        
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _user = $(this).data('user');
        var _name = $(this).data('name');
        var _description = $(this).data('description');
        var _mail = $(this).data('mail');
        var _profile = $(this).data('profile');
        var _role = $(this).data('rol');
        var _type = $(this).data('type');
        var _pass = $(this).data('password');
        
        $("#editId").val(_id);
        $("#editUser").val(_user);
        $("#editName").val(_name);
        $("#editPassword").val(_pass);
        $("#editDescription").val(_description);
        $("#editEmail").val(_mail);
        
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consult&sel="+ _profile,
            success: function (data) { $("#editProfile").empty();$("#editProfile").append(data); }        
        });
        chosen();
        $("#editProfile").trigger("liszt:updated");  
        
        var _per = $('#editProfile :selected').val();
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consultRole&sel="+ _role+"&prof="+ _per,
            success: function (data) { $("#editRole").empty();$("#editRole").append(data); }        
        });
        chosen();
        $("#editRole").trigger("liszt:updated");  
        
        $("#editType").empty();
        //$('#editType').append('<option selected="selected"></option>');
        $('#editType').append('<option value="G" selected>GENERICO</option>');
        $('#editType').append('<option value="I">INTERNO</option>');
        $('#editType').chosen();
        $("#editType").trigger("liszt:updated");
        
        var _status = $(this).data('status');
        if(_status=="1"){
            $("#editStatus").attr('checked','checked');
        }else{
            $("#editStatus").removeAttr('checked');
        }
        
        $("#editAction").val("update");        
        $("#modal").modal("show");
    });
};
var eliminar = function () {
    $(".trash").off().on('click', function (e) {
        e.preventDefault();        
        var tableid = $(this).data('tableid');
        if ($('input[name=row_sel]:checked', '#' + tableid).length) {
            $.colorbox({
                initialHeight: '0',
                initialWidth: '0',
                href: "#confirm_dialog",
                inline: true,
                opacity: '0.3',
                onComplete: function () {
                    $('.confirm_yes').off().on('click', function (e) {
                        e.preventDefault();
                        //Implementacion eliminar en base de datos
                        var _id = $('input:checkbox:checked.row_sel').map(function () {
                            return $(this).data('id');
                        }).get();
                        $('input[name=row_sel]:checked', '#' + tableid).closest('tr').fadeTo(300, 0, function () {
                            $(this).remove();
                            $('.row_sel', '#' + tableid).attr('checked', false);
                        });
                        $.colorbox.close();
                        $.ajax({
                            type: "POST",
                            url: "module/configuration/crud/configuration-user.php",
                            data: "action=delete&id="+ _id,
                            success: function () {
                                load();            
                            }        
                        });
                    });
                    $('.confirm_no').off().on('click', function (e) {
                        e.preventDefault();
                        $.colorbox.close();
                    });
                }
            });
        }
    });
};
var guardar = function () {
    $("#save").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editProfile']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editDescription: { required: true, minlength: 3 },
                editUser: { required: true, minlength: 3 },
                editName: { required: true, minlength: 3 },
                editPassword: { required: true, minlength: 3 },
                editEmail: { required: true, minlength: 3, email:true }                
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
        
        $("#modal").modal("hide");
        var _id = $("#editId").val();
        var _user = $("#editUser").val();
        var _name = $("#editName").val();
        var _password = $("#editPassword").val();
        var _description = $("#editDescription").val();
        var _mail = $("#editEmail").val();
        var _Pid = $("#editProfile option:selected").val();
        var _Rid = $("#editRole option:selected").val();
        var _Type = $("#editType option:selected").val();
        var _status = $("#editStatus").is(':checked');
        var _sta = "0";
        if(_status){_sta="1";}else{_sta="0";}
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/configuration/crud/configuration-user.php",
            data: "action="+ _action +"& id="+ _id+"& user="+ _user+"& name="+ _name+
                    "& description="+ _description+"& mail="+ _mail+"& profile="+ _Pid+
                    "& role="+ _Rid+"& type="+ _Type+"& status="+ _sta+"& password="+ _password,
            success: function () {
                load();       
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
        $("#editStatus").prop('checked',false);
        }
        return false;
        
    });
};

