/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    shipment.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
    $.validator.addMethod(
        "greaterThan",
        function (value, element, param) {
            var $min = $(param);
            if (this.settings.onfocusout) {
            $min.off(".validate-greaterThan").on("blur.validate-greaterThan", function () {
                $(element).valid();
            });
          }
          return parseInt(value) < parseInt($min.val());
        }, "El monto ingresado es mayor que la oferta actual.");
});

shipment = {    
    dt_maintenance: function() {
        load();
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/shipment/crud/shipment-auction.php",
        data: "action=select",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
            date_detail();
            hour_detail();
            unistyle();
            maskinput();
            popover();
            chosen();
            reassign();
            reassign_save();
            edit();
            offer();
            save_auction();
            save_offer();
            free();
            reset();
            see();
        }        
    });
};
var date_detail = function (){
    $('#startAuctionDate').datepicker({format: "yyyy-mm-dd", language: 'es'});
    $('#endAuctionDate').datepicker({format: "yyyy-mm-dd", language: 'es'});
    var $dp_start = $('#startAuctionDate'),$dp_end = $('#endAuctionDate');
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
    $("#editStartAuctionHour, #editEndAuctionHour").timepicker({
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
    $(".pop_over").popover({ html:true });
};
var chosen = function (){
    $(".chzn_edit").chosen();
};
var reassign = function(){
     $(".reassign").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id');$("#editId").val(_id);
        var _ids = $(this).data('ids');$("#editIds").val(_ids);
        var _carrier_current_id = $(this).data('current_id');$("#editCarrierCurrentID").val(_carrier_current_id);
        var _carrier_current = $(this).data('current_name');$("#editCarrierCurrent").val(_carrier_current);
        var _allocation = $(this).data('allocation');$("#editAllocationsID").val(_allocation);
        $("#editReason").val("");
        
        $("#editCarrierNew").empty();
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/carrier.php",
            data: "action=consult&task=exclude&sel="+ _carrier_current_id,
            success: function (data) { $("#editCarrierNew").append('<option selected="true"> </option>'); $("#editCarrierNew").append(data); }        
        });        
        chosen();
        $("#editCarrierNew").trigger("liszt:updated");
        $("#modal_adjudication").modal("show");
    });
};
var reassign_save = function (){
    $("#adjudication_save").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editCarrierNew']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_adjudication').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editCarrierNew: { chosen: true }
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
            var _id = $("#editId").val();
            var _ids = $("#editIds").val();
            var _carrier_current_id = $("#editCarrierCurrentID").val();
            var _carrier_new_id = $("#editCarrierNew option:selected").val();
            var _reason = $("#editReason").val();
            var _allocation = $("#editAllocationsID").val();
            $.ajax({
                type: "POST",
                url: "module/shipment/crud/reasigment.php",
                data: "action=reasigment&id="+_id+"&ids="+_ids+"&current="+_carrier_current_id+"&new="+_carrier_new_id+"&reason="+_reason+"&allocation="+_allocation,
                success: function () {
                    $("#modal_adjudication").modal("hide");
                    $.sticky("INFO<br>[Su solicitud ha sido procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                    load();
                }        
            });
        }
        return false;
    });
};
var see = function(){
    $(".see_offer").off().on('click', function (e) {
        e.preventDefault();
        var _exist = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('exist');
        }).get();
        var _id = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('auction');
        }).get();
        var _cnt = 0;
        for(i=0; i<_exist.length; i++){ 
            if(_exist[i]===0){
                _cnt++;
            }
        }
        if(_cnt===0){
            if(_exist.length===1){
                $('#modal_offer_see').modal('show');
                $.ajax({
                    type: "POST",
                    url: "module/shipment/crud/shipment-auction.php",
                    data: "action=sdetail&aucid="+_id[0],
                    success: function (response) {
                        $("#table_offer tbody").empty();
                        $("#table_offer tbody").append(response);
                    }        
                });
            }else{
                $.sticky("WARNING<br>[Porfavor, seleccione una &uacute;nica subasta.]", {autoclose : 5000, position: "top-right", type: "st-warning" });
            }
        }else{
            $.sticky("ERROR<br>[Existe subasta(s) que no han iniciado.]", {autoclose : 5000, position: "top-right", type: "st-error" });
        }
    });
};
        
var free = function(){
    $(".set_free").off().on('click', function (e) {
        e.preventDefault();
        var _exist = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('exist');
        }).get();
        var _cnt = 0;
        for(i=0; i<_exist.length; i++){ 
            if(_exist[i]===0){
                _cnt++;
            }
        }
        if(_cnt===0){
            var _id = $('input:checkbox:checked.row_sel').map(function () {
                return $(this).data('auction');
            }).get();
            $.colorbox({
                initialHeight: '0',
                initialWidth: '0',
                href: "#set_free_dialog",
                inline: true,
                opacity: '0.3',
                onComplete: function () {
                    $('.set_free_yes').off().on('click', function (e) {
                        e.preventDefault();
                        $.colorbox.close();
                        $.ajax({ type: "POST", url: "module/shipment/crud/shipment-auction.php", data: "action=free&id="+ _id,
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
        }else{
            $.sticky("ERROR<br>[Existe subasta(s) que no han iniciado.]", {autoclose : 5000, position: "top-right", type: "st-error" });
        }
    });
};
var reset = function(){
    $(".reset_offer").off().on('click', function (e) {
        e.preventDefault();
        var _exist = $('input:checkbox:checked.row_sel').map(function () {
            return $(this).data('exist');
        }).get();
        var _cnt = 0;
        for(i=0; i<_exist.length; i++){ 
            if(_exist[i]===0){
                _cnt++;
            }
        }
        if(_cnt===0){
            var _id = $('input:checkbox:checked.row_sel').map(function () {
                return $(this).data('auction');
            }).get();
            $.colorbox({
                initialHeight: '0',
                initialWidth: '0',
                href: "#reset_dialog",
                inline: true,
                opacity: '0.3',
                onComplete: function () {
                    $('.reset_yes').off().on('click', function (e) {
                        e.preventDefault();
                        $.colorbox.close();
                        $.ajax({ type: "POST", url: "module/shipment/crud/shipment-auction.php", data: "action=delete&id="+ _id,
                            success: function () {
                                load(); $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                            }        
                        });
                    });
                    $('.reset_no').off().on('click', function (e) {
                        e.preventDefault();
                        $.colorbox.close();
                    });
                }
            });
        }else{
            $.sticky("ERROR<br>[Existe subasta(s) que no han iniciado.]", {autoclose : 5000, position: "top-right", type: "st-error" });
        }
    });
};
var edit = function (){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _exist = $(this).data('exist');
        var _id = $(this).data('order');$("#editId").val(_id);
        var _detail_id = $(this).data('order_id');$("#editDetailId").val(_detail_id);
        var _carrier_id = $(this).data('participants');
        var _vehicle = $(this).data('vehicle');
        $("#editCarrier").empty();
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/carrier.php",
            data: "action=consult&task=dynu&sel="+_vehicle+"&act="+_carrier_id,
            success: function (data) { $("#editCarrier").append(data); }        
        });        
        chosen();
        $("#editCarrier").trigger("liszt:updated");
        if(_exist===0){
            $("#editBaseAmount").val("");
            $("#editInfo").val("");
            $("#editStartAuctionDate").val("");
            $("#editStartAuctionHour").val("");
            $("#editEndAuctionDate").val("");
            $("#editEndAuctionHour").val("");
            $("#editAction").val("insert");
        }else{
            var _price_start = $(this).data('price_start');$("#editBaseAmount").val(_price_start);
            var _info = $(this).data('info');$("#editInfo").val(_info);
            var _date_start = $(this).data('date_start');$("#editStartAuctionDate").val(_date_start);
            var _hour_start = $(this).data('hour_start');$("#editStartAuctionHour").val(_hour_start);
            var _date_end = $(this).data('date_end');$("#editEndAuctionDate").val(_date_end);
            var _hour_end = $(this).data('hour_end');$("#editEndAuctionHour").val(_hour_end);
            $("#editAction").val("update");
        }
        $('#modal_auction').modal('show');
    });
};
var save_auction = function (){
    $("#save_auction").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editCarrier']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_auction_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editCarrier: { chosen: true },
                editStartAuctionDate: { required: true },
                editStartAuctionHour: { required: true },
                editEndAuctionDate: { required: true },
                editEndAuctionHour: { required: true },
                editBaseAmount: { required: true, number: true }            
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
            var _order_id = $("#editId").val();
            var _order_detail_id = $("#editDetailId").val();
            var _info = $("#editInfo").val();
            var _carrier = $("#editCarrier option:selected").val(); 
            var _date_start = $("#editStartAuctionDate").val();
            var _hour_start = $("#editStartAuctionHour").val();
            var _date_end = $("#editEndAuctionDate").val();
            var _hour_end = $("#editEndAuctionHour").val();
            var _amount = $("#editBaseAmount").val();
            var _detail_action = $("#editAction").val();
            $.ajax({ 
                type: "POST", 
                url: "module/shipment/crud/shipment-auction.php", 
                data: "action="+ _detail_action +"& order_id="+ _order_id+"& order_detail_id="+ _order_detail_id+"& info="+ _info+"& carrier="+ _carrier +"& date_start="+ _date_start+"& hour_start="+ _hour_start+"& date_end="+ _date_end+"& hour_end="+ _hour_end+"& amount="+ _amount,
                success: function () {
                    load();
                    $("#modal_auction").modal("hide"); 
                    $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            });
        }
        return false;        
    });
};
var offer = function (){
    $(".offer").off().on('click', function (e) {
        e.preventDefault();
        var _exist= $(this).data('exist');
        if(_exist===1){
            $('#modal_offer').modal('show');
            var _id = $(this).data('id');$("#editIdAuction").val(_id);
            var _price_initial = $(this).data('price_start');$("#editInitialAmount").val(_price_initial);
            var _price_now = $(this).data('price_now');$("#editCurrentAmount").val(_price_now);
            $("#editOfferAmount").val("");
        }else{
            $.sticky("ERROR<br>[La subasta no ha sido completada.]", {autoclose : 5000, position: "top-right", type: "st-error" });
        }
    });
};
var save_offer = function (){
    $("#save_offer").off().on('click', function (e) {
        e.preventDefault();
        if($('#validation_offer_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editOfferAmount: {
                    greaterThan: '#editCurrentAmount',
                    required: true, 
                    number: true
                }           
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
            var _id = $("#editIdAuction").val();
            var _amount = $("#editOfferAmount").val();
            var _carrier = $("#userSesionID").val();
            $.ajax({ 
                type: "POST", 
                url: "module/shipment/crud/shipment-auction.php", 
                data: "action=idetail&aucid="+ _id+"&offer="+ _amount+"&carrier="+ _carrier,
                success: function () {
                    load();
                    $("#modal_offer").modal("hide"); 
                    $.sticky("&Eacute;XITO<br>[Solicitud procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
                }        
            });
        }
        return false;        
    });
};
var table = function () {
    function fnShowHide(iCol) {
        var oTable = $('#dt_maintenance').dataTable();
        var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
        oTable.fnSetColumnVis( iCol, bVis ? false : true );
    }
    /* Formating function for row details */
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
        $('#dt_maintenance_nav').off().on('click', 'li input', function(){
            fnShowHide($(this).val());
        });
    }
};