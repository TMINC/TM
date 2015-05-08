/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    description.dt_maintenance();  
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        }, "Por favor, elige una opción válida."
    ); 
    var _status = '0';
});

description = {    
    dt_maintenance: function() {
        load(); 
        var _order_number = 0;
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/order/crud/order.php",
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
            detalle();
            multiseleccion();
            chosen(); 
            liberar();
        }        
    });
};
var load_detail =  function (id) {
    $.ajax({
        type: "POST",
        url: "module/order/crud/order-detail.php",
        data: "action=select&order_id="+id,
        success: function (response) {
            $("#dt_detail tbody").empty();
            $('#dt_detail').dataTable().fnDestroy();
            $("#dt_detail tbody").empty();
            $('#dt_detail').dataTable().fnDestroy();
            $("#dt_detail tbody").append(response);
            table_detail();
            popover();
            unistyle();
            editar_detail();
            agregar_detail();
            guardar_detail();
            eliminar_detail();
            date_detail();
            hour_detail();
            chosen();
            show_edit_detail();
        }        
    });
};
var date_detail = function (){
    $('#detailOriginDate').datepicker({format: "yyyy-mm-dd", language: 'es'});
    $('#detailDestinationDate').datepicker({format: "yyyy-mm-dd", language: 'es'});
    var $dp_start = $('#detailOriginDate'),$dp_end = $('#detailDestinationDate');
    $dp_start.datepicker().off().on('changeDate', function(){
        var dateText = $(this).data('date');
        var endDateTextBox = $dp_end.children('input');
        if (endDateTextBox.val() !== '') {
            var testStartDate = new Date(dateText);
            var testEndDate = new Date(endDateTextBox.val());
            if (testStartDate > testEndDate) { endDateTextBox.val(dateText); }
        }else{ endDateTextBox.val(dateText); }
        $dp_end.datepicker('setStartDate', dateText);
        $dp_start.datepicker('hide');
    });
    $dp_end.datepicker().off().on('changeDate', function(){
        var dateText = $(this).data('date');
        var startDateTextBox = $dp_start.children('input');
        if (startDateTextBox.val() !== '') {
            var testStartDate = new Date(startDateTextBox.val());
            var testEndDate = new Date(dateText);
            if (testStartDate > testEndDate) { startDateTextBox.val(dateText); }
        }else{ startDateTextBox.val(dateText); }
        $dp_start.datepicker('setEndDate', dateText);
        $dp_end.datepicker('hide');
    }); 
};  
var hour_detail = function(){
    $("#editDetailOriginHour, #editDetailDestinationHour").timepicker({
        defaultTime: 'current',
        minuteStep: 1,
        disableFocus: true,
        template: 'dropdown',
        showMeridian: false
    });
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
var table_detail = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_detail').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }
    if($('#dt_detail').length){
        $('#dt_detail').dataTable({
            "sDom": "<'row'<'col-sm-4'l><'col-sm-4 text-right'T><'col-sm-4'f>r>t<'row'<'col-sm-5'i><'col-sm-7'p>>",
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "print",
                        "sButtonText": "<i class='glyphicon glyphicon-print' /> Imprimir"
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
        $('#dt_detail_nav').off().on('click','li input',function(){
            fnShowHide($(this).val());
        });
    }
};
var agregar = function(){
    $(".add").off().on('click', function (e) {
        e.preventDefault();
        $(".save").removeClass('hide');
        $("#editId").val("");
        $("#editType").empty(); $("#editType").append('<option selected="true" />');
        for(i=1; i<3; i++){
            if(i===1){$("#editType").append('<option value="' + i + '">TRANSPORTE FRESCO</option>');}
            if(i===2){$("#editType").append('<option value="' + i + '">TRANSPORTE CONGELADO</option>');}
        } chosen(); $("#editType").trigger("liszt:updated");        
        $("#editVolume").val("0");        
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=2&sel=0",
            success: function (data) { $("#editMeasureVolume").empty();$("#editMeasureVolume").append('<option selected="true"> </option>');$("#editMeasureVolume").append(data); }        
        }); chosen(); $("#editMeasureVolume").trigger("liszt:updated");
        $("#editWeight").val("0");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=3&sel=0",
            success: function (data) { $("#editMeasureWeight").empty();$("#editMeasureWeight").append('<option selected="true" />');$("#editMeasureWeight").append(data); }        
        }); chosen(); $("#editMeasureWeight").trigger("liszt:updated"); 
        $("#editDistance").val("0");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=1&sel=0",
            success: function (data) { $("#editMeasureDistance").empty();$("#editMeasureDistance").append('<option selected="true" />');$("#editMeasureDistance").append(data); }        
        }); chosen(); $("#editMeasureDistance").trigger("liszt:updated");
        $("#editPrice").val("0");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editMeasurePrice").empty();$("#editMeasurePrice").append('<option selected="true" />');$("#editMeasurePrice").append(data); }        
        }); chosen(); $("#editMeasurePrice").trigger("liszt:updated");
        $("#editRealPrice").val("0");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editMeasureRealPrice").empty();$("#editMeasureRealPrice").append('<option selected="true" />');$("#editMeasureRealPrice").append(data); }        
        }); chosen(); $("#editMeasureRealPrice").trigger("liszt:updated");
        $.ajax({ type: "POST", async:false, url: "module/master/crud/customer.php", data: "action=consult&sel=0",
            success: function (data) { $("#editCustomer").empty(); $("#editCustomer").append('<option selected="true" />'); $("#editCustomer").append(data); }        
        }); chosen(); $("#editCustomer").trigger("liszt:updated");        
        $("#editAction").val("insert");        
    });
};

var liberar = function () {
    $(".set_free").off().on('click', function (e) {
        e.preventDefault();
        var tableid = $(this).data('tableid');
        if ($('input[name=row_sel]:checked', '#' + tableid).length) {
            var _detail = $('input:checkbox:checked.row_sel').map(function () {
                return $(this).data('detail');
            }).get();
            var _cntDetail = 0;
            for(i=0; i<_detail.length; i++){ if(_detail[i]===0){_cntDetail++;}}
            if(_cntDetail){
                $.sticky("ERROR<br>[Orden(es) no cuenta(n) con detalle.]", {autoclose : 5000, position: "top-right", type: "st-error" });
            }else{
                $.colorbox({
                    initialHeight: '0',
                    initialWidth: '0',
                    href: "#set_free_dialog",
                    inline: true,
                    opacity: '0.3',
                    onComplete: function () {
                        $('.set_free_yes').off().on('click', function (e) {
                            e.preventDefault();
                            //Implementacion eliminar en base de datos
                            var _id = $('input:checkbox:checked.row_sel').map(function () {
                                return $(this).data('id');
                            }).get();
                            $.colorbox.close();
                            $.ajax({ type: "POST", url: "module/order/crud/order.php", data: "action=status&status=2& id="+ _id,
                                success: function () {
                                    load(); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                                }        
                            });
                        });
                        $('.set_free_no').off().on('click', function (e) {
                            e.preventDefault();
                            $.colorbox.close();
                        });
                    }
                }); 
            }    
        }
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _volume = $(this).data('volume'); $("#editVolume").val(_volume);
        var _weight = $(this).data('weight'); $("#editWeight").val(_weight);
        var _distance = $(this).data('distance'); $("#editDistance").val(_distance);
        var _price = $(this).data('price'); $("#editPrice").val(_price);
        var _real_price = $(this).data('real_price'); $("#editRealPrice").val(_real_price);        
        var _type = $(this).data('type');var sel='selected'; $("#editType").empty();
        for(i=1; i<3; i++){
            if(i===_type){sel='selected';}else{sel='';}
            if(i===1){$("#editType").append('<option value="' + i + '" ' + sel + '>TRANSPORTE FRESCO</option>');}
            if(i===2){$("#editType").append('<option value="' + i + '" ' + sel + '>TRANSPORTE CONGELADO</option>');}
        } chosen(); $("#editType").trigger("liszt:updated");
        var _measure_volume = $(this).data('measure_volume');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=2&sel="+ _measure_volume,
            success: function (data) { $("#editMeasureVolume").empty();$("#editMeasureVolume").append(data); }        
        }); chosen(); $("#editMeasureVolume").trigger("liszt:updated");       
        var _measure_weight = $(this).data('measure_weight');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=3&sel="+ _measure_weight,
            success: function (data) { $("#editMeasureWeight").empty();$("#editMeasureWeight").append(data); }        
        }); chosen(); $("#editMeasureWeight").trigger("liszt:updated");        
        var _measure_distance = $(this).data('measure_distance');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=1&sel="+ _measure_distance,
            success: function (data) { $("#editMeasureDistance").empty();$("#editMeasureDistance").append(data); }        
        }); chosen(); $("#editMeasureDistance").trigger("liszt:updated");
        var _measure_price = $(this).data('measure_price');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel="+ _measure_price,
            success: function (data) { $("#editMeasurePrice").empty();$("#editMeasurePrice").append(data); }        
        }); chosen(); $("#editMeasurePrice").trigger("liszt:updated");
        var _measure_real_price = $(this).data('measure_real_price');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel="+ _measure_real_price,
            success: function (data) { $("#editMeasureRealPrice").empty();$("#editMeasureRealPrice").append(data); }        
        }); chosen(); $("#editMeasureRealPrice").trigger("liszt:updated");
        var _customer = $(this).data('customer');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/customer.php", data: "action=consult&sel="+ _customer,
            success: function (data) { $("#editCustomer").empty();$("#editCustomer").append(data); }        
        }); chosen(); $("#editCustomer").trigger("liszt:updated");        
        _status = $(this).data('status');
        if(_status>1){$(".save").addClass('hide');}
        else{$(".save").removeClass('hide');}        
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
                        $.ajax({ type: "POST", url: "module/order/crud/order.php", data: "action=delete& id="+ _id,
                            success: function () {
                                load(); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
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
        $("[name='editCustomer']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editType']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureVolume']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureWeight']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureDistance']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasurePrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editMeasureRealPrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
         if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editCustomer: { chosen: true },
                editType: { chosen: true },
                editVolume: { required: true, number: true },
                editMeasureVolume: { chosen: true },
                editWeight: { required: true, number: true },
                editMeasureWeight: { chosen: true },
                editDistance: { required: true, number: true },
                editMeasureDistance: { chosen: true },
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
            var _type = $("#editType option:selected").val();
            var _volume = $("#editVolume").val(); 
            var _measure_volume = $("#editMeasureVolume option:selected").val();
            var _weight = $("#editWeight").val();
            var _measure_weight = $("#editMeasureWeight option:selected").val();
            var _distance = $("#editDistance").val();
            var _measure_distance = $("#editMeasureDistance option:selected").val();
            var _price = $("#editPrice").val();
            var _measure_price = $("#editMeasurePrice option:selected").val();
            var _real_price = $("#editRealPrice").val();
            var _measure_real_price = $("#editMeasureRealPrice option:selected").val();
            var _customer = $("#editCustomer option:selected").val();
            var _action = $("#editAction").val();
            $.ajax({ type: "POST", url: "module/order/crud/order.php", data: "action="+ _action +"&id="+ _id+"&type="+ _type +"&volume="+ _volume+"&measure_volume="+ _measure_volume+"&weight="+ _weight+"&measure_weight="+ _measure_weight+"&distance="+ _distance+"&measure_distance="+ _measure_distance+"&price="+ _price+"&measure_price="+ _measure_price+"&real_price="+ _real_price+"&measure_real_price="+ _measure_real_price+"&customer="+ _customer,
                success: function () {
                    load(); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            });
        }
        return false;        
    });
}; 
var detalle = function(){
    $(".detail").off().on('click', function (e) {
        e.preventDefault();
        _order_number = $(this).data('id');
        $("#detail_order_number").text(_order_number);
        _status = $(this).data('status');
        load_detail(_order_number);
        exit_detail();
        $('#detail').modal({ backdrop: 'static', keyboard: false });
        $("#editDetailId").val(_order_number);
    });
};
var show_edit_detail = function(){
    if(_status>1){$(".accciones").addClass('hide');$(".saveD").addClass('hide');$(".edit_detail").addClass('hide');}
        else{$(".accciones").removeClass('hide');$(".saveD").removeClass('hide');$(".edit_detail").removeClass('hide');}  
};
var exit_detail = function (){
    $("#exit_detail").off().on('click', function (e) {
        e.preventDefault();
        $("#detail").modal("hide");
        load();
    });
};
var agregar_detail = function(){
    $(".add_detail").off().on('click', function (e) {
        e.preventDefault();        
        $("#editDetailId").val(_order_number);
        $("#editOrderDetailId").val("");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/center.php", data: "action=consult&sel=0",
            success: function (data) { $("#editDetailOrigin").empty();$("#editDetailOrigin").append('<option selected="true"> </option>');$("#editDetailOrigin").append(data); }        
        }); chosen(); $("#editDetailOrigin").trigger("liszt:updated");       
        $.ajax({ type: "POST", async: false, url: "module/master/crud/center.php", data: "action=consult&sel=0",
            success: function (data) { $("#editDetailDestination").empty();$("#editDetailDestination").append('<option selected="true"> </option>');$("#editDetailDestination").append(data); }        
        }); chosen(); $("#editDetailDestination").trigger("liszt:updated");        
        $("#editDetailVolume").val("");        
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=2&sel=0",
            success: function (data) { $("#editDetailMeasureVolume").empty();$("#editDetailMeasureVolume").append('<option selected="true"> </option>');$("#editDetailMeasureVolume").append(data); }        
        }); chosen(); $("#editDetailMeasureVolume").trigger("liszt:updated");
        $("#editDetailWeight").val("");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=3&sel=0",
            success: function (data) { $("#editDetailMeasureWeight").empty();$("#editDetailMeasureWeight").append('<option selected="true"> </option>');$("#editDetailMeasureWeight").append(data); }        
        }); chosen(); $("#editDetailMeasureWeight").trigger("liszt:updated"); 
        $("#editDetailDistance").val("");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=1&sel=0",
            success: function (data) { $("#editDetailMeasureDistance").empty();$("#editDetailMeasureDistance").append('<option selected="true"> </option>');$("#editDetailMeasureDistance").append(data); }        
        }); chosen(); $("#editDetailMeasureDistance").trigger("liszt:updated");
        $("#editDetailPrice").val("");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editDetailMeasurePrice").empty();$("#editDetailMeasurePrice").append('<option selected="true"> </option>');$("#editDetailMeasurePrice").append(data); }        
        }); chosen(); $("#editDetailMeasurePrice").trigger("liszt:updated");        
        $("#editDetailRealPrice").val("");
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel=0",
            success: function (data) { $("#editDetailMeasureRealPrice").empty();$("#editDetailMeasureRealPrice").append('<option selected="true"> </option>');$("#editDetailMeasureRealPrice").append(data); }        
        }); chosen(); $("#editDetailMeasureRealPrice").trigger("liszt:updated");
        $("#editDetailOriginDate").val("");
        $("#editDetailOriginHour").val("");
        $("#editDetailDestinationDate").val("");
        $("#editDetailDestinationHour").val("");
        $("#editDetailNote").val("");
        $("#editDetailAction").val("insert");        
    });
};

var editar_detail = function(){
    $(".edit_detail").off().on('click', function (e) {
        e.preventDefault();        
        var _detail_id = $(this).data('detail_id'); $("#editOrderDetailId").val(_detail_id);
        var _origin_id = $(this).data('origin_id');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/center.php", data: "action=consult&sel="+ _origin_id,
            success: function (data) { $("#editDetailOrigin").empty();$("#editDetailOrigin").append(data); }        
        }); chosen(); $("#editDetailOrigin").trigger("liszt:updated");
        var _origin_date = $(this).data('origin_date'); $("#editDetailOriginDate").val(_origin_date);
        var _origin_hour = $(this).data('origin_hour'); $("#editDetailOriginHour").val(_origin_hour);        
        var _destination_id = $(this).data('destination_id');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/center.php", data: "action=consult&sel="+ _destination_id,
            success: function (data) { $("#editDetailDestination").empty();$("#editDetailDestination").append(data); }
        }); chosen(); $("#editDetailDestination").trigger("liszt:updated");  
        var _destination_date = $(this).data('destination_date'); $("#editDetailDestinationDate").val(_destination_date);
        var _destination_hour = $(this).data('destination_hour'); $("#editDetailDestinationHour").val(_destination_hour);        
        var _detail_volume = $(this).data('volume'); $("#editDetailVolume").val(_detail_volume);
        var _detail_weight = $(this).data('weight'); $("#editDetailWeight").val(_detail_weight);
        var _detail_distance = $(this).data('distance'); $("#editDetailDistance").val(_detail_distance);
        var _detail_measure_volume = $(this).data('measure_volume');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=2&sel="+ _detail_measure_volume,
            success: function (data) { $("#editDetailMeasureVolume").empty();$("#editDetailMeasureVolume").append(data); }        
        }); chosen(); $("#editDetailMeasureVolume").trigger("liszt:updated");       
        var _detail_measure_weight = $(this).data('measure_weight');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=3&sel="+ _detail_measure_weight,
            success: function (data) { $("#editDetailMeasureWeight").empty();$("#editDetailMeasureWeight").append(data); }        
        }); chosen(); $("#editDetailMeasureWeight").trigger("liszt:updated");        
        var detail_measure_distance = $(this).data('measure_distance');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=1&sel="+ detail_measure_distance,
            success: function (data) { $("#editDetailMeasureDistance").empty();$("#editDetailMeasureDistance").append(data); }        
        }); chosen(); $("#editDetailMeasureDistance").trigger("liszt:updated");
        var _detail_price = $(this).data('price'); $("#editDetailPrice").val(_detail_price);
        var _detail_measure_price = $(this).data('measure_price');
        $.ajax({ type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel="+ _detail_measure_price,
            success: function (data) { $("#editDetailMeasurePrice").empty();$("#editDetailMeasurePrice").append(data); }        
        }); chosen(); $("#editDetailMeasurePrice").trigger("liszt:updated");
        var _detail_real_price = $(this).data('real_price'); $("#editDetailRealPrice").val(_detail_real_price);           
        var _detail_measure_real_price = $(this).data('measure_real_price');
        $.ajax({type: "POST", async: false, url: "module/master/crud/measure.php", data: "action=consult&type=6&sel="+ _detail_measure_real_price,
            success: function (data) { $("#editDetailMeasureRealPrice").empty();$("#editDetailMeasureRealPrice").append(data); }        
        }); chosen(); $("#editDetailMeasureRealPrice").trigger("liszt:updated");        
        var _detail_note = $(this).data('note'); $("#editDetailNote").val(_detail_note);
        $("#editDetailAction").val("update");        
        $("#modal_detail").modal("show");
    });   
};
var eliminar_detail = function(){
  $(".trash_detail").off().on('click', function (e) {
        e.preventDefault();        
        var tableid = $(this).data('tableid');
        if ($('input[name=row_sel_detail]:checked', '#' + tableid).length) {
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
                        var _id = $('input:checkbox:checked.row_sel_detail').map(function () {
                            return $(this).data('id');
                        }).get();
                        $('input[name=row_sel_detail]:checked', '#' + tableid).closest('tr').fadeTo(300, 0, function () {
                            $(this).remove();
                            $('.row_sel_detail', '#' + tableid).attr('checked', false);
                        });
                        $.colorbox.close();
                        $.ajax({
                            type: "POST",
                            url: "module/order/crud/order-detail.php",
                            data: "action=delete&order_detail_id="+_id+"& order_id="+ _order_number,
                            success: function () {
                                load_detail(_order_number); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success" }, "", "modal");
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

var guardar_detail = function(){
   $("#save_detail").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editDetailOrigin']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailDestination']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailMeasureVolume']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailMeasureWeight']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailMeasureDistance']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailMeasurePrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editDetailMeasureRealPrice']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_detail_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editDetailOrigin: { chosen: true },
                editDetailOriginDate: { required: true },
                editDetailOriginHour: { required: true },
                editDetailDestination: { chosen: true },
                editDetailDestinationDate: { required: true },
                editDetailDestinationHour: { required: true },
                editDetailVolume: { required: true },
                editDetailMeasureVolume: { chosen: true },
                editDetailWeight: { required: true },
                editDetailMeasureWeight: { chosen: true },
                editDetailDistance: { required: true },
                editDetailMeasureDistance: { chosen: true },
                editDetailPrice: { required: true, number: true },
                editDetailMeasurePrice: { chosen: true },
                editDetailRealPrice: { required: true, number: true },
                editDetailMeasureRealPrice: { chosen: true }                
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
            var _order_id = $("#editDetailId").val();
            var _order_detail_id = $("#editOrderDetailId").val();
            var _origin = $("#editDetailOrigin option:selected").val(); 
            var _origin_date = $("#editDetailOriginDate").val();
            var _origin_hour = $("#editDetailOriginHour").val(); 
            var _destination = $("#editDetailDestination option:selected").val(); 
            var _destination_date = $("#editDetailDestinationDate").val();
            var _destination_hour = $("#editDetailDestinationHour").val();
            var _detail_volume = $("#editDetailVolume").val(); 
            var _detail_measure_volume = $("#editDetailMeasureVolume option:selected").val();
            var _detail_weight = $("#editDetailWeight").val();
            var _detail_measure_weight = $("#editDetailMeasureWeight option:selected").val();
            var _detail_distance = $("#editDetailDistance").val();
            var _detail_measure_distance = $("#editDetailMeasureDistance option:selected").val();
            var _detail_price = $("#editDetailPrice").val();
            var _detail_measure_price = $("#editDetailMeasurePrice option:selected").val();
            var _detail_real_price = $("#editDetailRealPrice").val();
            var _detail_measure_real_price = $("#editDetailMeasureRealPrice option:selected").val();
            var _detail_note = $("#editDetailNote").val();
            var _detail_action = $("#editDetailAction").val();
            $.ajax({ type: "POST", url: "module/order/crud/order-detail.php", data: "action="+ _detail_action +"& order_id="+ _order_id+"& order_detail_id="+ _order_detail_id+"& origin="+ _origin+"& origin_date="+ _origin_date +"& origin_hour="+ _origin_hour+"& destination="+ _destination+"& destination_date="+ _destination_date+"& destination_hour="+ _destination_hour+"& volume="+ _detail_volume+"& measure_volume="+ _detail_measure_volume+"& weight="+ _detail_weight+"& measure_weight="+ _detail_measure_weight+"& distance="+ _detail_distance+"& measure_distance="+ _detail_measure_distance+"& detail_price="+ _detail_price+"& detail_measure_price="+ _detail_measure_price+"& detail_real_price="+ _detail_real_price+"& detail_measure_real_price="+ _detail_measure_real_price+"& detail_note="+ _detail_note,
                success: function () {
                    load_detail(_order_id);
                    $("#modal_detail").modal("hide"); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-center", type: "st-success" }, "", "modal");
                }        
            });
        }
        return false;        
    });
}; 