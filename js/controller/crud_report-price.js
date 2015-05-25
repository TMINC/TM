/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    report.dt_maintenance();
});

report = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/report/crud/report.php",
        data: "action=price",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $("#dt_maintenance tbody").append(response);
            table();
            unistyle();      
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var table = function(){
    $('#dt_maintenance').dataTable({
        "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "sScrollX": "100%",
        "sScrollXInner": '200%',
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
        "aaSorting": [[0, "asc"]],
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
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
            { "sType": "string" },
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
        "sPaginationType": "bootstrap",
        "bScrollCollapse": true 
    });
};
var tables = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_maintenance').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }
    if($('#dt_maintenance').length){
        $('#dt_maintenance').dataTable({
            "sDom": "<'row'<'col-sm-4'l><'col-sm-4 text-right'T><'col-sm-4'f>r>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "scrollX": true,
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
            "aaSorting": [[0, "asc"]],
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
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
                    { "sType": "string" },
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
        $('#dt_maintenance_nav').off().on('click','li input',function(){
            fnShowHide($(this).val());
        });
    }
};