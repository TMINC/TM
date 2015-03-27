/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    center.dt_maintenance();
});

center = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/center.php",
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
            chosen();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var maskinput = function (){
   
};
var popover = function (){
    $(".pop_over").popover();
};
var chosen = function (){
    $(".chzn_edit").chosen();
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
        $('#dt_maintenance_nav').on('click','li input',function(){
            fnShowHide($(this).val());
        });
    }
};
var agregar = function(){
    $(".add").off().on('click', function (e) {
        e.preventDefault();
        $("#editId").val("");
        $("#editCustomer").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/customer.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editCustomer").append('<option selected="true"> </option>'); $("#editCustomer").append(data); }        
        });        
        chosen();
        $("#editCustomer").trigger("liszt:updated");
        $("#editName").val("");
        $("#editType").empty();
        $("#editType").append('<option value="" selected="true"> </option>');
        $("#editType").append('<option value="1">CENTRO DE ACOPIO</option>');
        $("#editType").append('<option value="2">PLANTA</option>');
        $("#editType").append('<option value="3">PUERTO DESTINO</option>');        
        chosen();
        $("#editType").trigger("liszt:updated");
        $("#editAddress").val("");
        $("#editLatitud").val("");
        $("#editLongitud").val("");
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _customer = $(this).data('customer');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/customer.php",
            data: "action=consult&sel="+ _customer,
            success: function (data) { $("#editCustomer").empty();$("#editCustomer").append(data); }        
        });
        chosen();
        $("#editCustomer").trigger("liszt:updated");
        var _name = $(this).data('name'); $("#editName").val(_name);
        var _type = $(this).data('type');var sel='selected';
        $("#editType").empty();
        for(i=1; i<4; i++){
            if(i==_type){sel='selected';}else{sel='';}
            if(i==1){$("#editType").append('<option value="' + i + '" ' + sel + '>CENTRO DE ACOPIO</option>');}
            if(i==2){$("#editType").append('<option value="' + i + '" ' + sel + '>PLANTA</option>');}
            if(i==3){$("#editType").append('<option value="' + i + '" ' + sel + '>PUERTO DESTINO</option>');}
        }  
        chosen();
        $("#editType").trigger("liszt:updated");
        var _address = $(this).data('address'); $("#editAddress").val(_address);
        var _latitud = $(this).data('latitud'); $("#editLatitud").val(_latitud);        
        var _longitud = $(this).data('longitud'); $("#editLongitud").val(_longitud);
        var _status = $(this).data('status');
        if(_status=="1"){
            $("#editStatus").attr('checked','checked');
        }else{
            $("#editStatus").removeAttr('checked');
        }
        $("#editAction").val("update");        
        $(".modal").modal("show");
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
                            url: "module/master/crud/center.php",
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
                editCustomer: { required: true, minlength: 3 },
                editName: { required: true, minlength: 3 },
                editType: { required: true },
                editAddress: { required: true, minlength: 3 },
                editLatitud: { required: true, minlength: 3 },
                editLongitud: { required: true, minlength: 3 }
                
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
            $(".modal").modal("hide");
            var _id = $("#editId").val();
            var _customer = $("#editCustomer option:selected").val();
            var _name = $("#editName").val();
            var _type = $("#editType option:selected").val();
            var _address = $("#editAddress").val();
            var _latitud = $("#editLatitud").val();
            var _longitud = $("#editLongitud").val();
            var _status = $("#editStatus").is(':checked');
            var _action = $("#editAction").val();
            $.ajax({
                type: "POST",
                url: "module/master/crud/center.php",
                data: "action="+ _action +"& id="+ _id+"& name="+ _name +"& address="+ _address+"& type="+ _type+"& latitud="+ _latitud+"& longitud="+ _longitud+"& customer="+ _customer+"& status="+ _status,
                success: function () {
                    load();   
                    $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            }); 
        }
        return false;        
    });
};