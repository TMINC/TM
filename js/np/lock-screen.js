/** 
 * Copyright (C) 2015 netpartners-international.com
 * By: Johnny Moscoso Rossel
 **/
(function ($) {
    var oldHide = $.fn.modal.Constructor.prototype.hide;    
    $.fn.modal.Constructor.prototype.hide = function (_relatedTarget) {
        if (this.isLocked) return; return oldHide.call(this, _relatedTarget);
    };
    $.fn.modal.Constructor.prototype.lock = function (_relatedTarget) {
        this.isLocked = true; e = $.Event('lock.bs.modal', { relatedTarget: _relatedTarget });
        this.$element.trigger(e);
    };
    $.fn.modal.Constructor.prototype.unlock = function (_relatedTarget) {
        this.isLocked = false; e = $.Event('unlock.bs.modal', { relatedTarget: _relatedTarget });
        this.$element.trigger(e);
    };    
    var timeout=900000; $.idleTimer(timeout);        
})(jQuery, window, document);

$(document).ready(function () {
    lockscreen.screen();
});

lockscreen = {    
    screen: function() {
        activity();
        enterActive();
        lock();
        unlock();
    }
};
var activity = function (){
    var username = $("#lockuser").val();
    $.post('includes/process_lock.php',{'activity': '3', 'username' : username},function(){});
};
var lock = function () {   
    $(document).bind("idle.idleTimer",function(){
        $('#lock-screen').modal('show');        
        $('#lock-screen').modal('lock');
        $('#lockscreenpass').val("");
        var username = $("#lockscreenuser").val();
        $.post('includes/process_lock.php',{'activity': '0', 'username' : username},function(data){
            $("#lock_message").html(data).show();  
        });
    });  
};

var unlock = function() {
    $('#unlock').off().on('click', function (e) {
        e.preventDefault();
        if($('#lock_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                lockscreenuser: { required: true, minlength: 3 },
                lockscreenpass: { required: true, minlength: 3 }
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
            var username = $("#lockscreenuser").val();
            var password = hex_sha512($("#lockscreenpass").val());
            $.post('includes/process_lock.php',{'activity': '1', 'user' : username,'password' : password},function(data){
                if(data){
                    $("#lock_message").removeClass("alert-info");
                    $("#lock_message").addClass("alert-danger");
                    $("#lock_message").html(data).show();                    
                }else{
                    $('#lock-screen').modal('unlock');
                    $('#lock-screen').modal('hide');
                    $(document).bind("active.idleTimer",function(){});
                }
            });
        }
        return false;        
    });
};
var enterActive = function(){
    $(window).keypress(function (e) {
        if (e.keyCode === 13) {
            if($('#lock_form').validate({
                onkeyup: false,
                errorClass: 'error',
                validClass: 'valid',
                rules: {
                    lockscreenuser: { required: true, minlength: 3 },
                    lockscreenpass: { required: true, minlength: 3 }
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
                var username = $("#lockscreenuser").val();
                var password = hex_sha512($("#lockscreenpass").val());
                $.post('includes/process_lock.php',{'activity': '1', 'user' : username,'password' : password},function(data){
                    if(data){
                        $("#lock_message").removeClass("alert-info"); $("#lock_message").addClass("alert-danger");
                        $("#lock_message").html(data).show();                    
                    }else{
                        $('#lock-screen').modal('unlock'); $('#lock-screen').modal('hide');
                        $(document).bind("active.idleTimer",function(){});
                    }
                });
            }
            return false;
        }
    });
};