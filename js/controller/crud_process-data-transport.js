/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 * Rv: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    transport.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});
transport = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/shipment/crud/process-data-transport.php",
        data: "action=select",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
            unistyle();
            popover();
            chosen();
            agregar_datos();
            agregar_estados();
            no_agregar_datos();
            no_agregar_estados();
            guardar();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var popover = function (){
    $(".pop_over").popover({html:true});
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
            "aaSorting": [[0, "desc"]],
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
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" }
                ],
            "sPaginationType": "bootstrap"
        });
        $('#dt_maintenance_nav').off().on('click','li input',function(){
            fnShowHide($(this).val());
        });
    }
};
var no_agregar_datos = function(){
    $(".no_add_transport").off().on('click', function (e) {
        e.preventDefault();
        $.sticky('INFO<br>[Subasta sin finalizar-Datos transporte, no disponible.]', {autoclose : 5000, position: "top-right", type: "st-info" });
    });
};
var agregar_datos = function(){
    $(".add_transport").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('allocation');$("#editID").val(_id);
        var _carrier = $(this).data('carrier');$("#editCarrier").val(_carrier);
        var _name = $(this).data('vehicle');$("#editType").val(_name);
        var _vehicle = $(this).data('vehicle_id');
        var _vehicle_aditional = $(this).data('vehicle_aditional');$("#editAditionalPlate").val(_vehicle_aditional);
        var _driver = $(this).data('driver');
        var cnt=0;
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/driver.php",
            data: "action=consult&sel="+ _driver,
            success: function (data) { 
                $("#editDriver").empty();
                if(_driver>0){cnt++;}else{$("#editDriver").append('<option selected="true"> </option>');}
                $("#editDriver").append(data);
            }        
        });
        chosen();
        $("#editDriver").trigger("liszt:updated");        
        var _plate = $(this).data('plate');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle.php",
            data: "action=plate&vehicle="+_vehicle+"sel="+ _plate,
            success: function (data) { 
                $("#editPlate").empty();
                if(_plate>0){cnt++;}else{$("#editPlate").append('<option selected="true"> </option>');}
                $("#editPlate").append(data);
            }        
        });
        chosen();
        $("#editPlate").trigger("liszt:updated");
        var _imei = $(this).data('imei');$("#editIMEI").val(_imei);
        if(_imei!==''){cnt++;}
        if(cnt===0){$("#editAction").val("insert");}else{$("#editAction").val("update");}
        if(cnt===3){$.sticky('INFO<br>[Edición finalizada, revise por <i>Control de Estado(s)</i>.]', {autoclose : 5000, position: "top-right", type: "st-info" });}else{$("#modal_transport").modal("show");}        
    });
};
var no_agregar_estados = function(){
    $(".no_add_state").off().on('click', function (e) {
       e.preventDefault();
       $.sticky('INFO<br>[Subasta sin finalizar-Control de estados, no disponible.]', {autoclose : 5000, position: "top-right", type: "st-info" });
    });
};  
var agregar_estados = function(){
    $(".add_state").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-data-transport.php",
            data: "action=state&id="+_id,
            success: function (response) {
                $("#state_control_view").empty();
                $("#state_control_view").append(response);
                $("#modal_state").modal("show");
            }
        });
    });
};
var guardar = function () {
    $("#save").off().on('click', function (e) {
        e.preventDefault();
        var _id = $("#editID").val();
        var _driver = $("#editDriver option:selected").val();
        var _vehicle = $("#editPlate option:selected").val();
        var _vehicle_aditional = $("#editAditionalPlate").val();
        var _imei = $("#editIMEI").val();
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-data-transport.php",
            data: "action="+_action+"&driver="+_driver+"&vehicle="+_vehicle+"&vehicle_aditional="+_vehicle_aditional+"&imei="+_imei+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;xito<br>[Su solicitud ha sido procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                load();
                $("#modal_transport").modal("hide");
            }        
        });
    });
};  