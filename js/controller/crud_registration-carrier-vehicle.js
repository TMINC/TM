/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Angel Silva Figueroa
 **/
$(document).ready(function() {
    registration.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

registration = {    
    dt_maintenance: function() {
        load();             
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/registration-carrier-vehicle.php",
        data: "action=select",
        success: function (response) {
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").empty();
            $('#dt_maintenance').dataTable().fnDestroy();
            $("#dt_maintenance tbody").append(response);
            table();
            unistyle();
            chosen();
            agregar();
            guardar();
            eliminar();
            multiseleccion();
        }        
    });
};
var unistyle = function (){
    $(".uni_style").uniform();  
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
       $("#editCarrier").empty();
        var _sel='0';
        $.ajax({
            type: "POST",
            async:false,
            url: "module/master/crud/carrier.php",
            data: "action=consult&task=exclude&sel="+ _sel,
            success: function (data) { $("#editCarrier").append('<option selected="true"> </option>'); $("#editCarrier").append(data); }        
        });        
        chosen();
        $("#editCarrier").trigger("liszt:updated");    
        
        var _plate = $(this).data('plate');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/vehicle.php",
            data: "action=plates&sel="+ _plate,
            success: function (data) { 
                $("#editPlate").empty();
                if(_plate>0){cnt++;}else{$("#editPlate").append('<option selected="true"> </option>');}
                $("#editPlate").append(data);
            }        
        });
        chosen();
        $("#editPlate").trigger("liszt:updated");
        
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
                        var _carrier_id = $('input:checkbox:checked.row_sel').map(function () {
                            return $(this).data('carrier_id');
                        }).get();
                        var _vehicle_id = $('input:checkbox:checked.row_sel').map(function () {
                            return $(this).data('vehicle_id');
                        }).get();
                        $('input[name=row_sel]:checked', '#' + tableid).closest('tr').fadeTo(300, 0, function () {
                            $(this).remove();
                            $('.row_sel', '#' + tableid).attr('checked', false);
                        });
                        $.colorbox.close();
                        $.ajax({
                            type: "POST",
                            url: "module/master/crud/registration-carrier-vehicle.php",
                            data: "action=delete& carrier_id="+ _carrier_id+"& vehicle_id="+ _vehicle_id,
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
        $("[name='editCarrier']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        $("[name='editPlate']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editCarrier: { chosen: true },
                editPlate: { chosen: true }
                
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
             var _carrier = $("#editCarrier option:selected").val();
             var _vehiculo = $("#editPlate option:selected").val();
        $.ajax({
            type: "POST",
            url: "module/master/crud/registration-carrier-vehicle.php",
            data: "action=insert& carrier_id="+ _carrier+"& vehicle_id="+ _vehiculo,
            success: function () {
                load();       
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
        }
        return false;
        
    });
};