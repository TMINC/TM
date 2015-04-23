/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
$(document).ready(function() {
    help.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            console.log(element);
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});
help = {    
    dt_maintenance: function() {
        load();
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/configuration/crud/help.php",
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
    
    /* Formating function for row details */
    function fnFormatDetails(help_id){
        var sOut = '<table class="table table-striped table-bordered dTableR" id="help_reply">';
        sOut += '<thead><tr><th class="center">SOPORTE TM</th><th class="center">REVIEWS</th><th class="center">DESCRIPCI&Oacute;N</th><th class="center"><a style="cursor:pointer;" class="add_review hint--left hint--info" data-hint="Agregar Respuesta" data-id="'+help_id+'"><i class="glyphicon glyphicon-comment" /></a></th></tr></thead><tbody>';
        $.ajax({
            type: "POST",
            url: "module/configuration/crud/help.php",
            async: false,
            data: "action=reply&help="+ help_id,
            success: function (response) {
                sOut += response;                
            }        
        });
        sOut += '</tbody></table>';
        return sOut;
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
                    { "bSortable": false },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "bSortable": false }
                ],
            "sPaginationType": "bootstrap"
        });
        $('#dt_maintenance_nav').off().on('click', 'li input', function(){
            fnShowHide($(this).val());
        });
        $('#dt_maintenance').off().on('click', 'tbody tr td img', function(){
            var oTable = $('#dt_maintenance').dataTable();
            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)){
                this.src = "img/details_open.png";
                oTable.fnClose(nTr);
            }else{
                this.src = "img/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails($(this).data('id')), 'details');
                $(".details").css("padding", "0 0 0 36px");
                like();
                agregar_comentario();
                guardar_comentario();
            }
        });
    }
};
var agregar_comentario = function(){
    $(".add_review").off().on('click', function (e) {
        e.preventDefault();
        $("#editDescription").empty();
        var help_id = $(this).data('id');$("#editHelpId").val(help_id);
        $("#editActionComment").val("insert");   
        $("#modal_comment").modal("show");
    });
};
var guardar_comentario = function () {
    $("#save_comment").off().on('click', function (e) {
        e.preventDefault();
        if($('#validation_form_comment').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editDescription: { required: true }
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
            var _id = $("#editId").val();
            var _help_id = $("#editHelpId").val();
            var _description = $("#editDescription").val();
            var _action = $("#editActionComment").val();
            $.ajax({
                type: "POST",
                url: "module/configuration/crud/help-reply.php",
                data: "action="+_action +"&id="+ _id+"&help="+ _help_id+"&description="+ _description,
                success: function () {
                    $("#modal_comment").modal("hide");load();       
                    $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            });  
        }
        return false;        
    });
};


var agregar = function(){
    $(".add").off().on('click', function (e) {
        e.preventDefault();
        $("#editForm").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/configuration/crud/system-form.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editForm").append('<option selected="true"> </option>'); $("#editForm").append(data); }        
        });        
        chosen();
        $("#editForm").trigger("liszt:updated");   
        $("#editLevel").empty(); $("#editForm").append('<option selected="true"></option>');
        for(i=1; i<5; i++){
            if(i===1){$("#editLevel").append('<option value="' + i + '">BAJA</option>');}
            if(i===2){$("#editLevel").append('<option value="' + i + '">NORNAL</option>');}
            if(i===3){$("#editLevel").append('<option value="' + i + '">ALTA</option>');}
            if(i===4){$("#editLevel").append('<option value="' + i + '">URGENTE</option>');}
        } chosen(); $("#editLevel").trigger("liszt:updated");
        $("#editText").val("");  
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var like = function(){
   $(".like").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id');
        var _count = $(this).data('review');
        _count = _count+1;
        $.ajax({
            type: "POST",
            url: "module/configuration/crud/help.php",
            data: "action=review&reply_id="+ _id+"&count="+ _count,
            success: function () {
                load();$.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
    });
};
var editar = function(){
   $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _user = $(this).data('user'); $("#editUser").val(_user);          
        
        var _form = $(this).data('form');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/system-form.php",
            data: "action=consult&sel="+ _form,
            success: function (data) { $("#editForm").empty();$("#editForm").append(data); }        
        });
        chosen();
        $("#editForm").trigger("liszt:updated");        
         var _level = $(this).data('level');var sel='selected'; $("#editLevel").empty();
        for(i=1; i<5; i++){
            if(i===_level){sel='selected';}else{sel='';}
            if(i===1){$("#editLevel").append('<option value="' + i + '" ' + sel + '>BAJA</option>');}
            if(i===2){$("#editLevel").append('<option value="' + i + '" ' + sel + '>NORMAL</option>');}
            if(i===3){$("#editLevel").append('<option value="' + i + '" ' + sel + '>ALTA</option>');}
            if(i===4){$("#editLevel").append('<option value="' + i + '" ' + sel + '>URGENTE</option>');}
        } chosen(); $("#editLevel").trigger("liszt:updated");        
        var _text = $(this).data('text'); $("#editText").val(_text);  
        var _status = $(this).data('status');
        if(_status=="1"){ $("#editStatus").attr('checked','checked');}
        else{ $("#editStatus").removeAttr('checked'); }
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
                            url: "module/configuration/crud/help.php",
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
         $("[name='editForm']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
         $("[name='editLevel']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
              
                editUser: { required: true },
                editText: { required: true },
                editForm: { chosen: true },
                editLevel: { chosen: true }
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
        var _form = $("#editForm option:selected").val();
        var _level = $("#editLevel option:selected").val();       
        var _text = $("#editText").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/configuration/crud/help.php",
            data: "action="+ _action +"& id="+ _id+"& user="+ _user+"& form_id="+ _form+"& level="+ _level+"& text="+ _text+"& status="+ _status,
            success: function () {
                load();       
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
  
        }
        return false;
        
    });
};

