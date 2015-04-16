/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Nathalie Portugal
 **/
$(document).ready(function() {
    access.dt_maintenance();
    $.validator.addMethod(
        "chosen",
        function(value, element) {
            console.log(element);
            return (value === null ? false : (value.length === 0 ? false : true));
        },
        "Por favor, elige una opción válida."
    );
});
access = {    
    dt_maintenance: function() {             
        load();
    }
};
var load = function () {    
    $.ajax({
        type: "POST",
        url: "module/configuration/crud/system-access.php",
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
            editar();            
            guardar();
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
        });
    }
};
var editar = function(){
    $(".edit").off().on('click', function (e) {
        e.preventDefault();
        
        var _profileDsc = $(this).data('pdescription');
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consult&sel="+ _profileDsc,
            success: function (data) { $("#editProfile").empty();$("#editProfile").append(data); }        
        });
        chosen();
        $("#editProfile").trigger("liszt:updated");        
        
        var _roleDsc = $(this).data('description');
        var _per = $('#editProfile :selected').val();
        
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/configuration-role.php",
            data: "action=consultRole& sel="+_roleDsc+"& prof="+ _per,
            success: function (data) { $("#editDescription").empty();$("#editDescription").append(data); }        
        });
        chosen();
        $("#editDescription").trigger("liszt:updated");        
        
        var _role = $(this).data('id');
        var PR = [];
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/system-access.php",
            data: "action=consult&id="+ _role,
            success: function (data) { 
              PR.push(data);
            }        
        });
        //Sacando la lista de paginas disponibles
        $.ajax({
            type: "POST",
            async: false,
            url: "module/configuration/crud/system-access.php",
            data: "action=consultAll&dataRol="+PR,
            success: function (data) { 
                $("#editPages").empty();$("#editPages").append(data);
            }        
        });
        chosen();
        $("#editPages").trigger("liszt:updated"); 
        
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
var guardar = function () {
    $("#save").off().on('click', function (e) {
        e.preventDefault();
        $("[name='editProfile']").css("position", "absolute").css("z-index",   "-9999").css("width", "10%").chosen().show();
        if($('#validation_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                editDescription: { required: true, minlength: 3 }                
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
        var _Rid = $("#editDescription option:selected").val();
        var _accesos = $("#editPages").val();
        var _action = $("#editAction").val();
        $.ajax({
            type: "POST",
            url: "module/configuration/crud/system-access.php",
            data: "action="+ _action +"& id="+ _Rid+"& access_id="+ _accesos,
            success: function () {
                load();       
                $.sticky("Su solicitud ha sido procesada.", {autoclose : 5000, position: "top-right", type: "st-success" });
            }        
        });
        }
        return false;        
    });
};

