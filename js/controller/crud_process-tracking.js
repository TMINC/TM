/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    shipment.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            console.log(element);
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

shipment = {    
    dt_maintenance: function() {
        load();
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/shipment/crud/shipment.php",
        data: "action=select&option=1",
        success: function (response) {
            var datos = (typeof response.d) == 'string' ? eval('(' + response.d + ')') : response.d;
                for (var i = 0; i < datos.length; i++) {
                    var _id = datos[i].iIDViaje;
                    var _origen = datos[i].cOrigen;
                    var _destino = datos[i].cDestino;
                    var _vehiculo = datos[i].cClaseVehiculo + ' - ' + datos[i].cTipoVehiculo;
                    var _vehiculoII = datos[i].cClaseVehiculoII + ' - ' + datos[i].cTipoVehiculoII;
                    var _ubicacion = datos[i].cCoordenadas;
                    var _transportista = datos[i].cProvTransp;
                    var _estado = datos[i].cEstado;
                     $(".dt_tracking tbody").append('<tr><td>' + _id + '<a class="show_on_map splashy-map hint--top hint--success" data-hint="Ubicar en el Mapa." style="float:right;"></a></td>' +
                        '<td>' + _origen + '</td>' +
                        '<td>' + _destino + '</td>' +
                        '<td>' + _vehiculo + '</td>' +
                        '<td>' + _ubicacion + '</td>' +
                        '<td class="address">' + _transportista + '</td>' +
                        '<td>' + _estado + '</td>' +
                        '<td><a style="cursor:pointer;"class="cancel splashy-marker_rounded_remove hint--left hint--error" data-hint="Cancelar Viaje" data-viaje="' + _id + '"style="float:right;"></a></td></tr>');
                }
                dt_tracking();
                cancelarViaje();
            table();
            unistyle();
            maskinput();
            popover();
            chosen();
            reassign();
        }        
    });
};

var dt_tracking = function () {
    function fnShowHide(iCol) {
        var oTable = $('.dt_tracking').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis(iCol, bVis ? false : true);
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
    function fnFormatDetails(order_id){
        var sOut = '<table class="table table-striped table-bordered dTableR">';
        sOut += '<thead><tr><th class="center">NUM SERVICIO</th><th class="center">ORIGEN</th><th class="center">DESTINO</th><th class="center">TIPO DE VEH&Iacute;CULO</th><th class="center">UBICACI&Oacute;N</th><th class="center">PROVEEDOR</th><th class="center">ESTADO</th><th class="center">ACCI&Oacute;N</th></tr></thead><tbody>';
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/shipment.php",
            async: false,
            data: "action=gps&order="+ order_id,
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
            if (oTable.fnIsOpen(nTr)){
                this.src = "img/details_open.png";
                oTable.fnClose(nTr);
            }else{
                this.src = "img/details_close.png";
                oTable.fnOpen(nTr, fnFormatDetails($(this).data('id')), 'details');
                $(".details").css("padding", "0 0 0 36px");
            }
        });
    }
};