/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    Estados.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

Estados = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/shipment/crud/process-state-control.php",
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
            agregar_estados();
            activar_estados();
            agregar_datos();
            no_agregar_datos();
            no_agregar_estados();
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
var slider = function (){
    var slider = $( "<div id='rate' style='margin-left:5px;'></div>" ).insertAfter( $("#rate_sel") ).slider({
        min: 1,
        max: 11,
        range: 0,
        value: $("#rate_sel")[0].selectedIndex + 1,
        slide: function( event, ui ) {
            $("#rate_sel")[0].selectedIndex = ui.value - 1;
        }
    });
    $("#rate_sel").change(function() {
        slider.slider( "value", this.selectedIndex + 1 );
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
            url: "module/shipment/crud/process-state-control.php",
            data: "action=state&id="+_id,
            success: function (response) {
                $("#state_control_view").empty();
                $("#state_control_view").append(response);
                $("#modal_state").modal("show");                
                slider();
                activar_estados();
                $("#editID").val(_id);
            }
        });
    });
};
var activar_estados = function(){
    var cnt = $(".cnt_control").val();
    $("#cchargingStart").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#chargingStart").val(_date);$("#cchargingStart").attr("disabled", true);cnt++;calificar(cnt);
        var _id = $("#editID").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=chargingStart&start_charging="+_date+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
            }        
        });
    });
    $("#cchargingEnd").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#chargingEnd").val(_date);$("#cchargingEnd").attr("disabled", true);cnt++;calificar(cnt);
        var _id = $("#editID").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=chargingEnd&end_charging="+_date+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
            }        
        });
    });
    $("#ctransit").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#transit").val(_date);$("#ctransit").attr("disabled", true);cnt++;calificar(cnt);
        var _id = $("#editID").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=transit&transit="+_date+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
            }        
        });
    });
    $("#cArrivalDestination").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#arrivalDestination").val(_date);$("#cArrivalDestination").attr("disabled", true);cnt++;calificar(cnt);
        var _id = $("#editID").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=arrivalDestination&arrival_destination="+_date+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
            }        
        });
    });
    $("#cStartDownload").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#startDownload").val(_date);$("#cStartDownload").attr("disabled", true);cnt++;calificar(cnt);
        var _id = $("#editID").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=startDownload&start_download="+_date+"&id="+_id,
            success: function () {
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
            }        
        });
    });
    $("#cEndTransportation").off().on('click', function () {
        var d = new Date(); var _date = get_date(d);
        $("#endTransportation").val(_date);$("#cEndTransportation").attr("disabled", true);cnt++;calificar(cnt);
        $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success"}, "", "modal");
    });
    calificar(cnt);
};
var guardar = function (){
    $("#save").off().on('click', function () {
        var _id = $("#editID").val();
        var _last_state = $("#endTransportation").val();
        var _rate = $("#rate_sel option:selected").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action=update&campo=endTransportation&end_transportation="+_last_state+"&id="+_id+"&rate="+_rate,
            success: function () {
                $("#modal_state").modal("hide");
                $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
    });
};
var calificar = function (cnt){
    if(cnt===6){
        $.sticky("INFO<br>[Registre la calificación del servicio.]", {autoclose : 5000, position: "top-center", type: "st-info"}, "", "modal");
        $("#td_rate").removeClass("hide");
        $("#save").removeClass("hide");
        guardar();
    }
    if(cnt===9){$("#td_rate").removeClass("hide");}
};
var get_date = function(d){
    var ano = d.getFullYear();
    var mes = d.getMonth();
    var dia = d.getDate();
    var h = d.getHours();
    var m = d.getMinutes();
    var s = d.getSeconds();
    var date_format = ano+'-'+mes+'-'+dia+' '+h+':'+m+':'+s;
    return date_format;
};
var agregar_datos = function(){
    $(".add_transport").off().on('click', function () {
        var _carrier = $(this).data('carrier');$("#editCarrier").val(_carrier);
        var _name = $(this).data('vehicle');$("#editType").val(_name);
        var _vehicle = $(this).data('vehicle_id');
        var _driver = $(this).data('driver');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/driver.php",
            data: "action=consult&sel="+ _driver,
            success: function (data) { 
                $("#editDriver").empty();
                if(_driver>0){}else{$("#editDriver").append('<option selected="true"> </option>');}
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
                if(_plate>0){}else{$("#editPlate").append('<option selected="true"> </option>');}
                $("#editPlate").append(data);
            }        
        });
        chosen();
        $("#editPlate").trigger("liszt:updated");
        var _imei = $(this).data('imei');$("#editIMEI").val(_imei);
        $("#modal_transport").modal("show");
    });
};