/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    carrier.dt_maintenance();
});

carrier = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/carrier.php",
        data: "action=select",
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
            agregar();
            editar();
            guardar();
            eliminar();
            multiseleccion();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var maskinput = function (){
    $("#editCode").inputmask("99999999999");
};
var popover = function (){
    $(".pop_over").popover();
};
var multiseleccion = function () {
    $('.sel_row').off().on('click', function () {
        var tableid = $(this).data('tableid');
        $('#' + tableid).find('.row_sel').attr('checked', this.checked);
    });
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
                    { "bSortable": false }
                ],
            "sPaginationType": "bootstrap"
        });
        $('#dt_maintenance_nav').off().on('click','li input',function(){
            fnShowHide($(this).val());
        });
    }
};
var agregar = function(){
    $(".add").off().on('click', function (e) {
        e.preventDefault();
        $("#editId").val("");
        $("#editName").val("");
        $("#editAddress").val("");
        $("#editPhoneName").val("");
        $("#editWebName").val("");
        $("#editCode").val("");
        $("#editAgent").val("");
        $("#editPhoneAgent").val("");
        $("#editEmailAgent").val("");
        $("#editContact").val("");
        $("#editPhoneContact").val("");
        $("#editEmailContact").val("");
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _name = $(this).data('name'); $("#editName").val(_name);
        var _address = $(this).data('address'); $("#editAddress").val(_address);
        var _phone_name = $(this).data('phone_name'); $("#editPhoneName").val(_phone_name);
        var _web_name = $(this).data('web_name'); $("#editWebName").val(_web_name);
        var _code = $(this).data('code'); $("#editCode").val(_code);
        var _agent = $(this).data('agent'); $("#editAgent").val(_agent);
        var _phone_agent = $(this).data('phone_agent'); $("#editPhoneAgent").val(_phone_agent);
        var _email_agent = $(this).data('email_agent'); $("#editEmailAgent").val(_email_agent);
        var _contact = $(this).data('contact'); $("#editContact").val(_contact);
        var _phone_contact = $(this).data('phone_contact'); $("#editPhoneContact").val(_phone_contact);
        var _email_contact = $(this).data('email_contact'); $("#editEmailContact").val(_email_contact);
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
                            url: "module/master/crud/carrier.php",
                            data: "action=delete& id="+ _id,
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
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editName: { required: true, minlength: 3 },
                editAddress: { required: true, minlength: 3 },
                editPhoneName: { required: true },
                editWebName: { required: true, url: true},
                editCode: { required: true, number: true },
                editAgent: { required: true, minlength: 3 },
                editPhoneAgent: { required: true },
                editEmailAgent: { required: true, email: true },
                editContact: { required: true, minlength: 3 },
                editPhoneContact: { required: true },
                editEmailContact: { required: true, email: true }
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
        var _name = $("#editName").val();
        var _address = $("#editAddress").val();
        var _phone_name = $("#editPhoneName").val();
        var _web_name = $("#editWebName").val();
        var _code = $("#editCode").val();
        var _agent = $("#editAgent").val();
        var _phone_agent = $("#editPhoneAgent").val();
        var _email_agent = $("#editEmailAgent").val();
        var _contact = $("#editContact").val();
        var _phone_contact = $("#editPhoneContact").val();
        var _email_contact = $("#editEmailContact").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/master/crud/carrier.php",
            data: "action="+ _action +"& id="+ _id+"& name="+ _name+"& address="+ _address+"& phone_name="+ _phone_name+"& web_name="+ _web_name+"& code="+ _code+"& agent="+ _agent+"& phone_agent="+ _phone_agent+"& email_agent="+ _email_agent+"& contact="+ _contact+"& phone_contact="+ _phone_contact+"& email_contact="+ _email_contact+"& status="+ _status,
            success: function () {
                load(); 
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        }); 
        }
        return false;
        
    });
};