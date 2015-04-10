/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    route.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            console.log(element);
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

route = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/route.php",
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
            chosen();
            agregar();
            editar();
            guardar();
            eliminar();
            multiseleccion();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
};
var maskinput = function (){
   $("#editTime").inputmask("99:99:99");
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
        $("#editName").val("");
        
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/center.php",
            data: "action=consult&sel=0",
            success: function (data) { $("#editOrigin").empty();$("#editOrigin").append('<option selected="true"> </option>');$("#editOrigin").append(data); }        
        });
        chosen();
        $("#editOrigin").trigger("liszt:updated"); 
        
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/center.php",
            data: "action=consult&sel=0",
            success: function (data) { $("#editDestination").empty();$("#editDestination").append('<option selected="true"> </option>');$("#editDestination").append(data); }        
        });
        chosen();
        $("#editDestination").trigger("liszt:updated");        
        
         $("#editDistance").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel=0",
            success: function (data) { $("#editMeasureDistance").empty();$("#editMeasureDistance").append('<option selected="true"> </option>');$("#editMeasureDistance").append(data); }        
        });
        chosen();
        $("#editMeasureDistance").trigger("liszt:updated");
          
        $("#editTime").val("");
        
         $("#editPrice").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editMeasurePrice").empty();$("#editMeasurePrice").append('<option selected="true"> </option>');$("#editMeasurePrice").append(data); }        
        });
        chosen();
        $("#editMeasurePrice").trigger("liszt:updated");
        
        $("#editRealPrice").val("");
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editMeasureRealPrice").empty();$("#editMeasureRealPrice").append('<option selected="true"> </option>');$("#editMeasureRealPrice").append(data); }        
        });
        chosen();
        $("#editMeasureRealPrice").trigger("liszt:updated");
        
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _name = $(this).data('name'); $("#editName").val(_name);
        
        var _origin_id = $(this).data('origin_id');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/center.php",
            data: "action=consult&sel="+ _origin_id,
            success: function (data) { $("#editOrigin").empty();$("#editOrigin").append(data); }        
        });
        chosen();
        $("#editOrigin").trigger("liszt:updated");
        
         var _destination_id = $(this).data('destination_id');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/center.php",
            data: "action=consult&sel="+ _destination_id,
            success: function (data) { $("#editDestination").empty();$("#editDestination").append(data); }
        });
        chosen();
        $("#editDestination").trigger("liszt:updated");  
        
        var _distance = $(this).data('distance'); $("#editDistance").val(_distance);
        var _time = $(this).data('time'); $("#editTime").val(_time);
        var _price = $(this).data('price'); $("#editPrice").val(_price);
        var _real_price = $(this).data('real_price'); $("#editRealPrice").val(_real_price); 
        
        var _measure_distance = $(this).data('measure_distance');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=1&sel="+ _measure_distance,
            success: function (data) { $("#editMeasureDistance").empty();$("#editMeasureDistance").append(data); }        
        });
        chosen();
        $("#editMeasureDistance").trigger("liszt:updated");
        var _measure_price = $(this).data('measure_price');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=6&sel="+ _measure_price,
            success: function (data) { $("#editMeasurePrice").empty();$("#editMeasurePrice").append(data); }        
        });
        chosen();
        $("#editMeasurePrice").trigger("liszt:updated");
        var _measure_real_price = $(this).data('measure_real_price');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/measure.php",
            data: "action=consult&type=6&sel="+ _measure_real_price,
            success: function (data) { $("#editMeasureRealPrice").empty();$("#editMeasureRealPrice").append(data); }        
        });
        chosen();
        $("#editMeasureRealPrice").trigger("liszt:updated");
        
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
                            url: "module/master/crud/route.php",
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
        $("[name='editOrigin']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDestination']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureDistance']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasurePrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureRealPrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editName: { required: true, minlength: 3 },
                editOrigin: { chosen: true },
                editDestination: { chosen: true },
                editDistance: { required: true, number: true },
                editMeasureDistance: { chosen: true },
                editTime: { required: true, minlength: 8 },
                editPrice: { required: true, number: true },
                editMeasurePrice: { chosen: true },
                editRealPrice: { required: true, number: true },
                editMeasureRealPrice: { chosen: true }
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
        var _name = $("#editName").val();
        var _origin = $("#editOrigin option:selected").val(); 
        var _destination = $("#editDestination option:selected").val(); 
        var _distance = $("#editDistance").val();
        var _measure_distance = $("#editMeasureDistance option:selected").val();
        var _time = $("#editTime").val();
        var _price = $("#editPrice").val();
        var _measure_price = $("#editMeasurePrice option:selected").val();
        var _real_price = $("#editRealPrice").val();
        var _measure_real_price = $("#editMeasureRealPrice option:selected").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/master/crud/route.php",
            data: "action="+ _action +"& id="+ _id+"& name="+ _name +"& origin="+ _origin+"& destination="+ _destination+"& distance="+ _distance+"& measure_distance="+ _measure_distance+"& time="+ _time+"& price="+ _price+"& measure_price="+ _measure_price+"& real_price="+ _real_price+"& measure_real_price="+ _measure_real_price+"& status="+ _status,
            success: function () {
                load(); 
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        }); 
        }
        return false;
        
    });
};