/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
$(document).ready(function() {
    driver.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});

driver = {    
    dt_maintenance: function() {
        load();     
        $("#editType").change(function(){
           var _val = $('#editType :selected').val();
           if(_val=="2"){
               $(".Prov").addClass("hide");
           }
           else{$(".Prov").removeClass("hide");}
           
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
           
        });
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/master/crud/driver.php",
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
    $("#editLicense").inputmask("A99999999");
    $("#editDni").inputmask("99999999");
    $("#editDateBirth").inputmask("99/99/9999");
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
        $("#editLicense").val("");
        $("#editFirstName").val("");
        $("#editLastName").val("");
        $("#editAddress").val("");
        $("#editPhone").val("");
        $("#editDateBirth").val("");
        $("#editDni").val("");
        $("#editBloodType").val("");
        $("#editType").empty();
        $("#editType").append('<option selected="true"> </option>');
        $("#editType").append('<option value="1">DEPENDIENTE</option>');
        $("#editType").append('<option value="2">INDEPENDIENTE</option>');
        $("#editType").append('<option value="3">DEPENDIENTE-INDEPENDIENTE</option>');        
        chosen();
        $("#editType").trigger("liszt:updated");
        
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
        
        $("#editStatus").removeAttr('checked');
        $("#editAction").val("insert");        
    });
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        var _id = $(this).data('id'); $("#editId").val(_id);
        var _license = $(this).data('license'); $("#editLicense").val(_license);
        var _fname = $(this).data('fname'); $("#editFirstName").val(_fname);
        var _lname = $(this).data('lname'); $("#editLastName").val(_lname);
        var _address = $(this).data('address'); $("#editAddress").val(_address);
        var _phone = $(this).data('phone'); $("#editPhone").val(_phone);
        var _date_birth = $(this).data('date_birth'); $("#editDateBirth").val(_date_birth);
        var _dni = $(this).data('dni'); $("#editDni").val(_dni);
        var _blood_type = $(this).data('blood_type'); $("#editBloodType").val(_blood_type);
        
        var _type = $(this).data('type');var sel='selected';
        $("#editType").empty();
        for(i=1; i<4; i++){
            if(i==_type){sel='selected';}else{sel='';}
            if(i==1){$("#editType").append('<option value="' + i + '" ' + sel + '>DEPENDIENTE</option>');}
            if(i==2){$("#editType").append('<option value="' + i + '" ' + sel + '>INDEPENDIENTE</option>');}
            if(i==3){$("#editType").append('<option value="' + i + '" ' + sel + '>DEPENDIENTE-INDEPENDIENTE</option>');}
        }  
        chosen();
        $("#editType").trigger("liszt:updated");
        
         var _carrier = $(this).data('carrier');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/master/crud/carrier.php",
            data: "action=consult&task=exclude&sel="+ _carrier,
            success: function (data) { $("#editCarrier").empty();$("#editCarrier").append(data); }        
        });
        chosen();
        $("#editCarrier").trigger("liszt:updated");
        
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
                            url: "module/master/crud/driver.php",
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
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editLicense: { required: true },
                editFirstName: { required: true },
                editLastName: { required: true },
                editAddress: { required: true },
                editPhone: { required: true, number: true },
                editDateBirth: { required: true },
                editDni: { required: true, number: true },
                editBloodType: { required: true },
                editType: { chosen: true }
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
        var _license = $("#editLicense").val();
        var _fname = $("#editFirstName").val();
        var _lname = $("#editLastName").val();
        var _address = $("#editAddress").val();
        var _phone = $("#editPhone").val();
        var _date_birth = $("#editDateBirth").val();
        var _dni = $("#editDni").val();
        var _blood_type = $("#editBloodType").val();
        var _type = $("#editType option:selected").val();
        var _carrier = $("#editCarrier option:selected").val();
        var _status = $("#editStatus").is(':checked');
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/master/crud/driver.php",
            data: "action="+ _action +"& id="+ _id+"& license="+ _license+"& fname="+ _fname+"& lname="+ _lname+"& address="+ _address+"& phone="+ _phone+"& date_birth="+ _date_birth+"& dni="+ _dni+"& blood_type="+ _blood_type+"& carrier="+ _carrier +"& type="+ _type+"& status="+ _status,
            success: function () {
                load();            
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });    
        }
        return false;
        
    });
};