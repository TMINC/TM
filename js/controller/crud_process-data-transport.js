/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    Transport.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

Transport = {    
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
            exit_state();
            agregar_datos ();
            agregar_estados();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var popover = function (){
    $(".pop_over").popover({html:true});
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

var exit_state = function (){
    $("#exit_state").off().on('click', function (e) {
        e.preventDefault();
        $("#modal_state").modal("hide");
        load();
    });
};

var agregar_datos = function(){
    $(".add_transport").off().on('click', function (e) {
        e.preventDefault();
       $("#editDriver").val("");
        $("#editPlate").val("");
        $("#editIMEI").val("");
        $("#modal_transport").modal("show");
    });
};

var agregar_estados = function(){
    $(".add_state").off().on('click', function (e) {
        e.preventDefault();
        $("#chargingStart").val("");
        $("#chargingEnd").val("");
        $("#transit").val("");
        $("#ArrivalDestination").val("");
        $("#StartDownload").val("");
        $("#EndTransportation").val("");
        $("#modal_state").modal("show");
    });
};
var editar = function(){
   
};
var guardar = function () {
    $("#save").off().on('click', function (e) {
        e.preventDefault();
        var _start_charging = $("#chargingStart").val();
        var _end_charging = $("#chargingEnd").val();
        var _transit = $("#transit").val();
        var _arrival_destination = $("#ArrivalDestination").val();
        var _start_download = $("#StartDownload").val();
        var _end_transportation = $("#EndTransportation").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/process-state-control.php",
            data: "action="+ _action +"& start_charging="+ _start_charging+"& end_charging="+ _end_charging +"& transit="+ _transit+"& arrival_destination="+ _arrival_destination+"& start_download="+ _start_download+"& end_transportation="+ _end_transportation+"& status="+ _status,
            success: function () {
                load();  
                 $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
    });
};  