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
            spinner();
            chosen();
            plan();
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
    $(".pop_over").popover();
};
var spinner = function(){
    $("#editPlanQuantity").spinner({min: 1});
};
var chosen = function (){
    $(".chzn_edit").chosen();
};
var select_plan = function () {
    $('#editAdjudicationType').empty();
    $('#editAdjudicationType').append('<option selected="selected"></option>');
    $('#editAdjudicationType').append('<option value="0">DIRECTA</option>');
    $('#editAdjudicationType').append('<option value="1">SUBASTA</option>');
    $('#editAdjudicationType').chosen();
    $("#editAdjudicationType").trigger("liszt:updated");
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
                var _id = $('input:checkbox:checked.row_sel').map(function () {
                    return $(this).data('id');
                }).get();
                $('#editDirectOrderId').val(_id);
                //save_plan();
            }else{
                $.sticky("ERROR<br>[Las ordenes seleccionadas no pertenecen al mismo cliente.]", {autoclose : 5000, position: "top-right", type: "st-error" });
            }
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
var plan_trip = function (){
    $(".plan_trip").off().on('click', function (e) {
        e.preventDefault();
        alert();
    });   
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
