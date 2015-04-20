/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    shipment.dt_maintenance();
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
        data: "action=select&option=5",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
            popover();
            unistyle();
            show_all_location();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var popover = function (){
    $(".pop_over").popover();
};
var show_all_location = function() {
    $('.all_signal_gps').off().on('click', function (e) {
        e.preventDefault();
        $('#g_map').gmap3('destroy');
        $('#g_map').gmap3();
        var show_lat_lng = $(this).data('all_coordinate');
        var points = [], map;
        var latLng_array = show_lat_lng.split('/');        
        for(v = 0; v < latLng_array.length; v++){
            var _latLng_array = latLng_array[v].split(',');
            points.push(_latLng_array);
        }
        $('#g_map').gmap3({
            map:{
                options:{
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false,
                    center: points[0]
                }
            }
        });
        $.each(points, function(i, point){
            var panorama = new Panorama();
            panorama.setMap(map);        
            $("#g_map").gmap3({
                marker:{
                    latLng: point,
                    options:{title: "Click para ver", draggable: true},
                    callback: function(marker){
                        panorama.setMarker(marker);
                    },
                    events:{
                        click: function(){
                            panorama.open();
                        }
                    }
                },
                infowindow:{
                    options:{
                        content: "<div id='iw"+i+"' class='infow'></div>"
                    },
                    callback: function(infowindow){
                        panorama.setInfowindow(infowindow);
                    },
                    events:{
                        domready: function(){
                            panorama.run("iw"+i);
                        }
                    }
                }
            });
        });
    });
};
var show_location = function() {
    $('.signal_gps').off().on('click', function (e) {
        e.preventDefault();
        $('#g_map').gmap3('destroy');
        $('#g_map').gmap3();
        var show_lat_lng = $(this).data('coordinate').toString();
        var latLng_array = show_lat_lng.split(',');
        var points = [], map;
        points.push(latLng_array);
        $('#g_map').gmap3({
            map:{
                options:{
                    zoom: 12,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    streetViewControl: false,
                    center: points[0]
                }
            }
        });
        $.each(points, function(i, point){
            var panorama = new Panorama();
            panorama.setMap(map);        
            $("#g_map").gmap3({
                marker:{
                    latLng: point,
                    options:{title: "Click para ver", draggable: true},
                    callback: function(marker){
                        panorama.setMarker(marker);
                    },
                    events:{
                        click: function(){
                            panorama.open();
                        }
                    }
                },
                infowindow:{
                    options:{
                        content: "<div id='iw"+i+"' class='infow'></div>"
                    },
                    callback: function(infowindow){
                        panorama.setInfowindow(infowindow);
                    },
                    events:{
                        domready: function(){
                            panorama.run("iw"+i);
                        }
                    }
                }
            });
        });
    });
};
var display = function(){
    
};
var table = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_maintenance').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }
    /* Formating function for row details */
    function fnFormatDetails(order_id){
        var sOut = '<table class="table table-striped table-bordered dTableR" id="dt_location">';
        sOut += '<thead><tr><th class="center">NRO.SERVICIO</th><th class="center">ORIGEN</th><th class="center">DESTINO</th><th class="center">UBICACI&Oacute;N</th><th class="center">GPS&nbsp;MENSAJE</th><th class="center">ACCI&Oacute;N</th></tr></thead><tbody>';
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
                popover();
                show_location();
            }
        });
    }
};