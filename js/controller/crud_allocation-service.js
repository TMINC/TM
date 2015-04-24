/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
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
        data: "action=select&option=0",
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
            plan();
            date();
            load_vehicle();
            save_date();
            wizard();
            wizard_titles();
            wizard_two();
        }        
    });
};

var unistyle = function (){
    $(".uni_style").uniform();  
};
var maskinput = function (){
   //$("#editTime").inputmask("99:99:99");
};
var popover = function (){
    $(".pop_over").popover({ html:true });
};
var chosen = function (){
    $(".chzn_edit").chosen();
};
var spinner = function(){
    $(".editPlanQuantity").spinner({min: 1});
};
var date_detail = function (){
    $('#dateOriginDate').datepicker();
    $('#dateDestinationDate').datepicker();
    var $dp_start = $('#dateOriginDate'),$dp_end = $('#dateDestinationDate');
    $dp_start.datepicker({ format: "dd/mm/yyyy" }).off().on('changeDate', function(){
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
    $dp_end.datepicker({format: "dd/mm/yyyy"}).off().on('changeDate', function(){
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
    $("#editDateOriginHour, #editDateDestinationHour").timepicker({
        defaultTime: 'current',
        minuteStep: 1,
        disableFocus: true,
        template: 'dropdown',
        showMeridian: false
    });
};
var multiselectable = function(){
    if($('#vehicle_select').length) {
        $('#vehicle_select').multiSelect({
            selectableHeader: '<div class="search-header"><input type="text" class="form-control" id="ms-search" autocomplete="off" placeholder="Ingrese t&eacute;rmino de b&uacute;squeda.."></div>',
            selectionHeader: "<div class='search-selected'></div>"
        });
    }
    if($('#ms-search').length) {  
        $('#ms-search').quicksearch($('.ms-elem-selectable', '#ms-vehicle_select' )).on('keydown', function(e){
            if (e.keyCode === 40){
                $(this).trigger('focusout');
                $('#ms-vehicle_select').focus();
                return false;
            }
        });
    }
};
var select_plan = function () {
    $('.editAdjudicationType').empty();
    $('.editAdjudicationType').append('<option selected="selected"></option>');
    $('.editAdjudicationType').append('<option value="0">DIRECTA</option>');
    $('.editAdjudicationType').append('<option value="1">SUBASTA</option>');
    $('.editAdjudicationType').chosen();
    $(".editAdjudicationType").trigger("liszt:updated");
};
var carrier_data = function (carrier, filtro){
    $("#"+carrier).empty();
    $.ajax({
        type: "POST",
        async: false,
        url: "module/master/crud/carrier.php",
        data: "action=consult&task=dyn&sel="+ carrier,
        success: function (data) { $("#"+carrier).append('<option selected="true"> </option>'); $("#"+carrier).append(data); }        
    });        
    chosen();
    $("#"+carrier).trigger("liszt:updated");
};
var select_plan_change = function(){
    $(".editAdjudicationType").change(function() {
        var _id = $(this).data('id');
        var _carrier = $(this).data('carrier');
        var _search = $(this).data('search');
        var _value = $("#"+_id+" option:selected").val();
        //alert(_carrier); NP
        if(_value=='0'){
            $('#'+_carrier).removeAttr('multiple'); 
        }else{
            $('#'+_carrier).attr('multiple', 'multiple'); 
        }       
        carrier_data(_carrier, '');
    });
    
};
var plan = function(){
    $(".plan").off().on('click', function (e) {
        e.preventDefault();
        var _id = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('id');
        }).get();
        var _customer = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('customer');
        }).get();
        var _customerBool = true;
        if(_id.length===0){
            $.sticky("INFO<br>[Orden(es) no seleccionada(s).]", {autoclose : 5000, position: "top-right", type: "st-info" });
        }else{
            var _nroCustomer = [];
            for(v = 0; v < _customer.length; v++){
                if (_nroCustomer.length > 0) {
                    for (i = 0; i < _nroCustomer.length; i++) {
                        if (_nroCustomer[i] !== _customer[v]) { _customerBool = false; }
                    }
                    if (_customerBool) { _nroCustomer.push(_customer[v]); }
                } else {
                    _nroCustomer.push(_customer[v]);
                }
            }
            if(_customerBool){
                select_plan();
                $('#plan').modal({ backdrop: 'static', keyboard: false });
                popover();
                spinner();
                multiselectable();
                vehicle();
                var _id = $('input:checkbox:checked.row_sel').map(function () {
                    return $(this).data('id');
                }).get();
                $('#editPlanOrderId').val(_id);//editDirectOrderId
                //Cargando la data de planificación
                $.ajax({
                    type: "POST",
                    url: "module/shipment/crud/shipment-detail.php",
                    data: "action=detail&option=1&id="+ _id,
                    success: function (response) {
                        $("#dt_detail_maintenance tbody").empty();
                        $('#dt_detail_maintenance').dataTable().fnDestroy();
                        $("#dt_detail_maintenance tbody").empty();
                        $('#dt_detail_maintenance').dataTable().fnDestroy();
                        $("#dt_detail_maintenance tbody").append(response);
                        load_truck_number();
                        plan_trip();
                        popover();
                    }        
                });
                save_plan();
            }else{
                $.sticky("ERROR<br>[Las ordenes seleccionadas no pertenecen al mismo cliente.]", {autoclose : 5000, position: "top-right", type: "st-error" });
            }
        }
    });
};
var plan_reload = function(){
   var _id = $('input:checkbox:checked.row_sel').map(function () {
        return $(this).data('id');
    }).get();
    var _customer = $('input:checkbox:checked.row_sel').map(function () {
        return $(this).data('customer');
    }).get();
    var _customerBool = true;
    if(_id.length===0){
        $.sticky("INFO<br>[Orden(es) no seleccionada(s).]", {autoclose : 5000, position: "top-right", type: "st-info" });
    }else{
        var _nroCustomer = [];
        for(v = 0; v < _customer.length; v++){
            if (_nroCustomer.length > 0) {
                for (i = 0; i < _nroCustomer.length; i++) {
                    if (_nroCustomer[i] !== _customer[v]) { _customerBool = false; }
                }
                if (_customerBool) { _nroCustomer.push(_customer[v]); }
            } else {
                _nroCustomer.push(_customer[v]);
            }
        }
        if(_customerBool){
            select_plan();
            $('#plan').modal({ backdrop: 'static', keyboard: false });
            popover();
            spinner();
            multiselectable();
            vehicle();
            var _id = $('input:checkbox:checked.row_sel').map(function () {
                return $(this).data('id');
            }).get();
            $('#editPlanOrderId').val(_id);//editDirectOrderId
            //Cargando la data de planificación
            $.ajax({
                type: "POST",
                url: "module/shipment/crud/shipment-detail.php",
                data: "action=detail&option=1&id="+ _id,
                success: function (response) {
                    $("#dt_detail_maintenance tbody").empty();
                    $('#dt_detail_maintenance').dataTable().fnDestroy();
                    $("#dt_detail_maintenance tbody").empty();
                    $('#dt_detail_maintenance').dataTable().fnDestroy();
                    $("#dt_detail_maintenance tbody").append(response);
                    load_truck_number();
                    plan_trip();
                    popover();
                }        
            });
            save_plan();
        }else{
            $.sticky("ERROR<br>[Las ordenes seleccionadas no pertenecen al mismo cliente.]", {autoclose : 5000, position: "top-right", type: "st-error" });
        }
    } 
};
var load_truck_number = function (){
    var _id = $('#editPlanOrderId').val();
    $.ajax({
        type: "POST",
        async: false,
        url: "module/shipment/crud/shipment-detail.php",
        data: "action=detail&option=3&id="+_id,
        success: function (data) {
            if(data==""){$("#vehicle_selection_number").text("0");}
            else{$("#vehicle_selection_number").text(data);}            
        }        
    });
};
var save_plan = function (){
    $("#adjudication_save").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editAdjudicationType']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_adjudication').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editAdjudicationType: { chosen: true }
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
            $("#adjudication").modal("hide");
            var _type = $("#editAdjudicationType option:selected").val();
            var _id = $('input:checkbox:checked.row_sel').map(function () {
                return $(this).data('id');
            }).get();
            if(_type===0){
                $('#adjudicationDirect').modal('show');
                $('#editDirectOrderId').val(_id);
            }else{
                alert("S");
            }
        }
        return false;
    });
};
var load_vehicle = function(){
   $.ajax({
        type: "POST",
        async: false,
        url: "module/shipment/crud/shipment-detail.php",
        data: "action=detail&option=2",
        success: function (data) {
           $("#vehicle_select").append(data);                
        }        
    });
};
var vehicle = function(){
    $("#vehicle_selection").off().on('click', function (e) {
        e.preventDefault();
        var _cntTruck = $("#vehicle_selection_number").text();
        if(_cntTruck==0){
            $("#vehicle_selection_modal").modal("show");
        }
   });   
};
var wizard = function(){
    $('#vehicle_wizard').stepy({
        titleClick : true,
        nextLabel:      'Siguiente <i class="glyphicon glyphicon-chevron-right"></i>',
        backLabel:      '<i class="glyphicon glyphicon-chevron-left"></i> Anterior',
        block  : true,
        errorImage : true,
        validate : true,
        next: function() {
            if ($("#vehicle_select").val().length > 0) {vehicle_table_number();
            spinner();}else{}
        },
        finish: function() {
            save_transport_allocation();
            $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
            $("#vehicle_selection_modal").modal('hide');
            plan_reload();
            return false;
        }
    });
    stepy_validation = $('#vehicle_wizard').validate({
        onfocusout: false,
        highlight: function(element) {
            $(element).closest('.form-group').addClass("f_error");
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass("f_error");
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').append(error);
        },
        rules: {
            'editNumber' : {
                required    : true,
                number      : true,
                minlength   : 1
            }
        },
        ignore  : ':hidden'
    });
};
var save_transport_allocation = function(){
    var _orders = $("#editPlanOrderId").val();
    var values = [];
    var veh_id = [];
    $(".editPlanQuantity ").each(function() {	
        values.push($(this).val().toString());
        veh_id.push($(this).data('id').toString());	
    });
    for(var x=0;x<values.length;x++){
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/shipment-detail.php",
            async: false,
            data: "action=saveAllocTransp&id="+ _orders +"&cnt="+ values[x]+"&veh_id="+ veh_id[x],
            success: function (response) {                             
            }        
        });
    }
    
};
var save_transport_allocation_detail = function(){
    var _orderdet = $("#OrderDetail_Id").val();
    var values = [];
    var veh_id = [];
    var carr_id = [];
    var carr_name = [];
    $(".editAdjudicationType ").each(function() {	
        values.push($(this).val().toString());//0(Directo),1(Subasta)
        veh_id.push($(this).data('id').toString());//ID,Classe,Typo,Cat	
    });
    $(".editCarrier ").each(function(){
        carr_id.push($(this).val().toString());//0(Directo),1(Subasta)
        carr_name.push($(this).text().toString());//ID,Classe,Typo,Cat	
    });
    
    for(var x=0;x<values.length;x++){
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/shipment-detail.php",
            async: false,
            data: "action=AllocTransportDet&option=insert&detID="+ _orderdet +"&adjType="+ values[x]+"&carrID="+ carr_id[x]+"&vehID="+veh_id[x],
            success: function (response) {                             
            }        
        });
    }
    
};
var wizard_titles = function (){
    $('.stepy-titles').each(function(){
        $(this).children('li').each(function(index){
            var myIndex = index + 1;
            $(this).append('<span class="stepNb">'+myIndex+'</span>');
        });
    });
};
var wizard_two = function(){
    $('#adjudication_wizard').stepy({
        titleClick : true,
        nextLabel:      'Siguiente <i class="glyphicon glyphicon-chevron-right"></i>',
        backLabel:      '<i class="glyphicon glyphicon-chevron-left"></i> Anterior',
        block  : true,
        errorImage : true,
        validate : true,
        next: function() {
            if ($("#vehicle_select_adjudication").val().length > 0) {vehicle_table_number_two();}else{}
        },
        finish: function() {
            save_transport_allocation_detail();
            $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
            $("#adjudication").modal('hide');
            plan_reload();
            return false;
        }
    });
    stepy_validation = $('#adjudication_wizard').validate({
        onfocusout: false,
        highlight: function(element) {
            $(element).closest('.form-group').addClass("f_error");
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass("f_error");
        },
        errorPlacement: function(error, element) {
            $(element).closest('.form-group').append(error);
        },
        rules: {
            'editNumber' : {
                required    : true,
                number      : true,
                minlength   : 1
            }
        },
        ignore  : ':hidden'
    });
};
var vehicle_table_number = function (){
    var sOut = "";
    var names =  [];
    var values = [];
    $("#vehicle_select option:selected").each(function() {   
        values.push($(this).val().toString());
        names.push($(this).text().toString()); 
    });
    $.ajax({
        type: "POST",
        url: "includes/draw.php",
        async: false,
        data: "action=drawVehicle&value="+ values +"&name="+ names,
        success: function (response) {
            sOut += response;                
        }        
    });
    $("#vehicle_table_number").html(sOut);
};
var plan_trip = function (){
    $(".plan_trip").off().on('click', function (e) {
        e.preventDefault();
        var _cntTruck = $("#vehicle_selection_number").text();
        if(_cntTruck==0){}else{
            load_vehicle_trip();
            multiselectable_trip();
            wizard_titles();
            $("#OrderDetail_Id").val($(this).data('id'));
            $("#adjudication").modal("show");
        }
    });   
};
var multiselectable_trip = function(){
    if($('#vehicle_select_adjudication').length) {
        $('#vehicle_select_adjudication').multiSelect({
            selectableHeader: '<div class="search-header"><input type="text" class="form-control" id="ms-search_adjudication" autocomplete="off" placeholder="Ingrese t&eacute;rmino de b&uacute;squeda.."></div>',
            selectionHeader: "<div class='search-selected'></div>"
        });
    }
    if($('#ms-search_adjudication').length) {  
        $('#ms-search_adjudication').quicksearch($('.ms-elem-selectable', '#ms-vehicle_select_adjudication' )).on('keydown', function(e){
            if (e.keyCode === 40){
                $(this).trigger('focusout');
                $('#ms-vehicle_select_adjudication').focus();
                return false;
            }
        });
    }
};
var load_vehicle_trip = function(){
   $.ajax({
        type: "POST",
        async: false,
        url: "module/shipment/crud/shipment-detail.php",
        data: "action=detail&option=4",
        success: function (data) {
           $("#vehicle_select_adjudication").append(data);                
        }        
    });
};
var vehicle_table_number_two = function (){
    var sOut = "";
    var names =  [];
    var values = [];
    $("#vehicle_select_adjudication option:selected").each(function() {			
        values.push($(this).val().toString());
        names.push($(this).text().toString());	
    });
    $.ajax({
        type: "POST",
        url: "includes/draw.php",
        async: false,
        data: "action=drawAdjudication&value="+ values +"&name="+ names,
        success: function (response) {
            sOut += response;                
        }        
    });
    $("#vehicle_table_number_adjudication").html(sOut);
    select_plan();
    select_plan_change();    
};
var table = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_maintenance').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }
    /* Formating function for row details */
    function fnFormatDetails(order_id){
        var sOut = '<table class="table table-striped table-bordered dTableR" id="order_detail">';
        sOut += '<thead><tr><th class="center">ORIGEN</th><th class="center">DESTINO</th><th class="center">VOLUMEN</th><th class="center">PESO</th><th class="center">DISTANCIA</th><th class="center">ACCI&Oacute;N</th></tr></thead><tbody>';
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/shipment.php",
            async: false,
            data: "action=detail&order="+ order_id,
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
                table_detail();
                date();
            }
        });
    }
};
var table_detail = function (){
    $('#order_detail').dataTable({
            "sDom": "<'row'<'col-sm-6'><'col-sm-6'f>r>t<'row'<'col-sm-5'i><'col-sm-7'>S>",
            "sScrollY": "80px",
            "aaSorting": [[1, "asc"]],
            "iDisplayLength": -1,
            "aLengthMenu": [[-1, 100, 50, 25], ["[ * ]", 100, 50, 25]],
            "oLanguage": {
                "sSearch": "Buscar por: ",
                "sLengthMenu": "Mostrar _MENU_ registro(s).",
                "sEmptyTable": "No hay registros para mostrar",
                "sInfo": "_START_ al _END_ de _TOTAL_ viaje(s)",
                "sInfoEmpty": "0 al 0 de 0 viaje(s)",
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
                    { "bSortable": false }
                ]
        });
};
var save_date = function (){
    $("#save_date").off().on('click', function (e) {
        e.preventDefault();        
        if($('#validation_date_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {                
                editDateOriginDate: { required: true },
                editDateOriginHour: { required: true },
                editDateDestinationDate: { required: true },
                editDateDestinationHour: { required: true }                             
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
            $("#modal_date").modal('hide');            
            var _date_id = $("#editDateId").val();
            var _date_origin_date = $("#editDateOriginDate").val();
            var _date_origin_hour = $("#editDateOriginHour").val(); 
            var _date_destination_date = $("#editDateDestinationDate").val();
            var _date_destination_hour = $("#editDateDestinationHour").val(); 
            var _date_action = $("#editDateAction").val(); 
            $.ajax({ type: "POST", 
                     url: "module/shipment/crud/shipment-detail.php", 
                     data: "action="+ _date_action +"& date_id="+ _date_id+"& date_origin_date="+ _date_origin_date+"& date_origin_hour="+ _date_origin_hour +"& date_destination_date="+ _date_destination_date+"& date_destination_hour="+ _date_destination_hour,
                success: function () {
                    $("#modal_date").modal("hide"); 
                    $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                    load();
                }        
            });
        }
        return false;
    });
};
var date = function (){
    $(".edit_date").off().on('click', function (e) {
        e.preventDefault();
        var _order_date_id = $(this).data('id'); $("#editDateId").val(_order_date_id);        
        var _date_origin_date = $(this).data('origin_date'); $("#editDateOriginDate").val(_date_origin_date);
        var _date_origin_hour = $(this).data('origin_hour'); $("#editDateOriginHour").val(_date_origin_hour);        
        var _date_destination_date = $(this).data('destination_date'); $("#editDateDestinationDate").val(_date_destination_date);
        var _date_destination_hour = $(this).data('destination_hour'); $("#editDateDestinationHour").val(_date_destination_hour);
        $("#editDateAction").val("update");        
        $("#modal_date").modal("show");
        date_detail();
        hour_detail();
    });   
};
