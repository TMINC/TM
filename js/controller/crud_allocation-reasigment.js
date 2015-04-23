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
        data: "action=select&option=2",
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
var chosen = function (){
    $(".chzn_edit").chosen();
};
var reassign = function(){
    $(".reassign").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id');$("#editId").val(_id);
        var _ids = $(this).data('ids');$("#editOrderDetail").val(_ids);
        var _carrier_current_id = $(this).data('current_id');
        var _carrier_current = $(this).data('current_name');$("#editCarrierCurrent").val(_carrier_current);
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
        $("#adjudication").modal("show");
    });
};
var reassign_save = function (){
    $("#adjudication_save").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editCarrierNew']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
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
            var _ids = $("#editOrderDetail").val();
            var _carrier_current_id = $("#editCarrierNew option:selected").val();
            var _reason = $("#editReason").val();
            $.ajax({
                type: "POST",
                url: "module/shipment/crud/shipment.php",
                data: "action=reasigment&id="+_ids+"&carrier="+_carrier_current_id+"&reason="+_reason,
                success: function () {
                    $("#adjudication").modal("hide");
                    $.sticky("INFO<br>[Su solicitud ha sido procesada.]", {autoclose : 5000, position: "top-right", type: "st-success" });
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
    function fnFormatDetails(order_id){
        var sOut = '<table class="table table-striped table-bordered dTableR">';
        sOut += '<thead><tr><th class="center" style="width: 106px;">SERVICIO</th><th class="center">ORIGEN</th><th class="center">DESTINO</th><th class="center">VOLUMEN</th><th class="center">PESO</th><th class="center">DISTANCIA</th><th class="center">ACCI&Oacute;N</th></tr></thead><tbody>';
        $.ajax({
            type: "POST",
            url: "module/shipment/crud/shipment.php",
            async: false,
            data: "action=reassign&type=2&order="+ order_id,
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
                popover();
                reassign();
                reassign_save(); 
            }
        });
    }
};