/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    description.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
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
    $("#editPlate").inputmask("A9A999");
    $("#editTuc").inputmask("99999999999");
};
var popover = function (){
    $(".pop_over").popover({ html:true });
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
        $("#editPlate").val("");
        $("#editTuc").val("");  
        
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
        
        
        $("#editClass").empty();
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
        
      
        
        $("#editCategory").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/vehicle-category.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editCategory").append('<option selected="true"> </option>'); $("#editCategory").append(data); }        
        });        
        chosen();
        $("#editCategory").trigger("liszt:updated");
        
        $("#editGroup").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/vehicle-group.php",
            data: "action=consult&sel="+ _sel,
            success: function (data) { $("#editGroup").append('<option selected="true"> </option>'); $("#editGroup").append(data); }        
        });        
        chosen();
        $("#editGroup").trigger("liszt:updated");
        
        $("#editWeight").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=3&sel=0",
            success: function (data) { $("#editMeasureWeight").empty();$("#editMeasureWeight").append('<option selected="true"> </option>');$("#editMeasureWeight").append(data); }        
        });
        chosen();
        $("#editMeasureWeight").trigger("liszt:updated"); 
        $("#editLenght").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=2&sel=0",
            success: function (data) { $("#editMeasureLenght").empty();$("#editMeasureLenght").append('<option selected="true"> </option>');$("#editMeasureLenght").append(data); }        
        });
        chosen();
        $("#editMeasureLenght").trigger("liszt:updated"); 
        
        $("#editWidth").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel=0",
            success: function (data) { $("#editMeasureWidth").empty();$("#editMeasureWidth").append('<option selected="true"> </option>');$("#editMeasureWidth").append(data); }        
        });
        chosen();
        $("#editMeasureWidth").trigger("liszt:updated"); 
        
       $("#editHeight").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel=0",
            success: function (data) { $("#editMeasureHeight").empty();$("#editMeasureHeight").append('<option selected="true"> </option>');$("#editMeasureHeight").append(data); }        
        });
        chosen();
        $("#editMeasureHeight").trigger("liszt:updated"); 
        
        
        
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _plate = $(this).data('plate'); $("#editPlate").val(_plate);        
        var _tuc = $(this).data('tuc'); $("#editTuc").val(_tuc);   
        
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
        
        
        var _class = $(this).data('class');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle-class.php",
            data: "action=consult&sel="+ _class,
            success: function (data) { $("#editClass").empty();$("#editClass").append(data); }        
        });
        chosen();
        $("#editClass").trigger("liszt:updated");
        
              
        var _category = $(this).data('category');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle-category.php",
            data: "action=consult&sel="+ _category,
            success: function (data) { $("#editCategory").empty();$("#editCategory").append(data); }        
        });
        chosen();
        $("#editCategory").trigger("liszt:updated");
        
        var _group = $(this).data('group');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle-group.php",
            data: "action=consult&sel="+ _group,
            success: function (data) { $("#editGroup").empty();$("#editGroup").append(data); }        
        });
        chosen();
        $("#editGroup").trigger("liszt:updated");
       
        var _weight = $(this).data('weight'); $("#editWeight").val(_weight);
       
        var _measure_weight = $(this).data('measure_weight');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=3&sel="+ _measure_weight,
            success: function (data) { $("#editMeasureWeight").empty();$("#editMeasureWeight").append(data); }        
        });
        chosen();
        $("#editMeasureWeight").trigger("liszt:updated");        
       
        var _lenght = $(this).data('lenght'); $("#editLenght").val(_lenght);
        
        var _measure_lenght = $(this).data('measure_lenght');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=2&sel="+ _measure_lenght,
            success: function (data) { $("#editMeasureLenght").empty();$("#editMeasureLenght").append(data); }        
        });
        chosen();
        $("#editMeasureLenght").trigger("liszt:updated");        
        
        var _width = $(this).data('width'); $("#editWidth").val(_width);
        
        var _measure_width = $(this).data('measure_width');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel="+ _measure_width,
            success: function (data) { $("#editMeasureWidth").empty();$("#editMeasureWidth").append(data); }        
        });
        chosen();
        $("#editMeasureWidth").trigger("liszt:updated");
        
        var _height = $(this).data('height'); $("#editHeight").val(_height);
       
        var _measure_height = $(this).data('measure_height');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel="+ _measure_height,
            success: function (data) { $("#editMeasureHeight").empty();$("#editMeasureHeight").append(data); }        
        });
        chosen();
        $("#editMeasureHeight").trigger("liszt:updated");
             
             
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
        $("[name='editType']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editClass']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editCategory']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editGroup']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureWeight']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureLenght']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show(); 
        //$("[name='editMeasureWidth']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        //$("[name='editMeasureHeight']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editPlate: { required: true },
                editTuc: { required: true },
                editWeight: { required: true },
                editLenght: { required: true },
                editWidth: { required: true },
                editHeight: { required: true },
                editType: { chosen: true },
                editClass: { chosen: true },
                editCategory: { chosen: true },
                editGroup: { chosen: true },
                editMeasureWeight: { chosen: true },
                editMeasureLenght: { chosen: true },
                //editMeasureWidth: { chosen: true },
                //editMeasureHeight: { chosen: true }
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
            var _plate = $("#editPlate").val();
            var _tuc = $("#editTuc").val();
            var _type = $("#editType option:selected").val();
            var _class = $("#editClass option:selected").val();
            var _category = $("#editCategory option:selected").val();
            var _group = $("#editGroup option:selected").val();
            var _weight = $("#editWeight").val();
            var _measure_weight = $("#editMeasureWeight option:selected").val();
            var _lenght = $("#editLenght").val();
            var _measure_lenght = $("#editMeasureLenght option:selected").val();
            var _width = $("#editWidth").val();
            var _measure_width = $("#editMeasureWidth option:selected").val();
            var _height = $("#editHeight").val();
            var _measure_height = $("#editMeasureHeight option:selected").val();
            var _status = $("#editStatus").is(':checked');
            var _action = $("#editAction").val();
            $.ajax({
                type: "POST",
                url: "module/master/crud/vehicle.php",
                data: "action="+ _action +"& id="+ _id+"& plate="+ _plate +"& tuc="+ _tuc+"& type_id="+ _type+"& class_id="+ _class+"& category_id="+ _category+"& group_id="+ _group+"& weight="+ _weight+"& measure_weight="+ _measure_weight+"& lenght="+ _lenght+"& measure_lenght="+ _measure_lenght+"& width="+ _width+"& measure_width="+ _measure_width+"& height="+ _height+"& measure_height="+ _measure_height+"& status="+ _status,
                success: function () {
                    load();  
                     $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            });
        }
        return false;
        
    });
};  