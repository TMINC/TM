/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    description.dt_maintenance();
});

description = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/vehicle.php",
        data: "action=select",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
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
        $("#editPlate").val("");
        $("#editGenre").val("");
        $("#editType").empty();
        $("#editClass").empty();
        $("#editWeight").val("");
        $("#editMeasureWeight").val("");
        $("#editLength").val("");
        $("#editWidth").val("");
        $("#editHeight").val("");
        $("#editMeasureHeight").val("");
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/vehicle-class.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editClass").append('<option selected="true"> </option>'); $("#editClass").append(data); }        
        });        
        chosen();
        $("#editClass").trigger("liszt:updated");
        $("#editType").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/vehicle-type.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editType").append('<option selected="true"> </option>'); $("#editType").append(data); }        
        });        
        chosen();
        $("#editType").trigger("liszt:updated");
        $("#editName").val("");
        
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
        var _plate = $(this).data('plate'); $("#editPlate").val(_plate);
        var _genre = $(this).data('genre'); $("#editGenre").val(_genre);
        var _type = $(this).data('type');
        var _class = $(this).data('class');
        var _weight = $(this).data('weight'); $("#editWeight").val(_weight);
        var _measure_weight = $(this).data('measure_weight'); $("#editMeasureWeight").val(_measure_weight);
        var _length = $(this).data('length'); $("#editLength").val(_length);
        var _width = $(this).data('width'); $("#editWidth").val(_width);
        var _height = $(this).data('height'); $("#editHeight").val(_height);
        var _measure_height = $(this).data('measure_height'); $("#editMeasureHeight").val(_measure_height); 
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle-class.php",
            data: "action=consult&sel="+ _class,
            success: function (data) { $("#editClass").empty();$("#editClass").append(data); }        
        });
        chosen();
        $("#editClass").trigger("liszt:updated");
        var _type = $(this).data('type');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle-type.php",
            data: "action=consult&sel="+ _type,
            success: function (data) { $("#editType").empty();$("#editType").append(data); }        
        });
        chosen();
        $("#editType").trigger("liszt:updated");
        var _name = $(this).data('name'); $("#editName").val(_name);
        
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
                            url: "module/master/crud/vehicle.php",
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
        $(".modal").modal("hide");
        var _id = $("#editId").val();
        var _plate = $("#editPlate").val();
        var _genre = $("#editGenre").val();
        var _type = $("#editType option:selected").val();
        var _class = $("#editClass option:selected").val();
        var _weight = $("#editWeight").val();
        var _measure_weight = $("#editWeight").val();
        var _length = $("#editLength").val();
        var _width = $("#editWidth").val();
        var _height = $("#editHeight").val();
        var _measure_height = $("#editHeight").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/master/crud/vehicle.php",
            data: "action="+ _action +"& id="+ _id+"& plate="+ _plate +"& genre="+ _genre+"& type_id="+ _type+"& class_id="+ _class+"& weight="+ _weight+"& measure_weight="+ _measure_weight+"& length="+ _length+"& width="+ _width+"& height="+ _height+"& measure_height="+ _measure_height+"& status="+ _status,
            success: function () {
                load();            
            }        
        });
    });
};