$(document).ready(function(){  
    //* boxes animation
    form_wrapper = $('.login_box');
    function boxHeight() {
        form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);	
    };
    form_wrapper.css({ marginTop : ( - ( form_wrapper.height() / 2) - 24) });
    $('.linkform a,.link_reg a').on('click',function(e){
        var target = $(this).attr('href'),
        target_height = $(target).actual('height');
        $(form_wrapper).css({
            'height': form_wrapper.height()
        });	
        $(form_wrapper.find('form:visible')).fadeOut(400,function(){
            form_wrapper.stop().animate({
                height : target_height,
                marginTop: ( - (target_height/2) - 24)
            },500,function(){
                $(target).fadeIn(400);
                $('.links_btm .linkform').toggle();
                $(form_wrapper).css({
                    'height' : ''
                });	
            });
        });
        e.preventDefault();
    });
    
    //* Start Validation
    $("#l_send").off().on('click', function(){
        if($('#login_form').validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                username: { required: true, minlength: 3 },
                password: { required: true, minlength: 3 }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            errorPlacement: function(error, element) {
                $(element).closest('.form-group').append(error);
            }
        }).form()){
            var username = $("#username").val();
            var password = hex_sha512($("#password").val());
            var remember = $("#remember:checked").val();
            if(remember == "on"){ remember=1; } else { remember=0; }
            $.post('includes/process_login.php',{'user' : username,'password' : password, 'remember' : remember},function(data){
                if(data){
                    $("#l_message").removeClass("alert-info");
                    $("#l_message").addClass("alert-danger");
                    $("#l_message").html(data).show();                    
                }else{
                    document.location = "./";
                }
            });
        }
        return false;
    });
    
    $("#p_send").off().on('click', function(){
        if($("#pass_form").validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                p_email: { required: true, minlength: 3, email: true }
            },
            highlight: function(element) {
                $(element).closest('div').addClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            unhighlight: function(element) {
                $(element).closest('div').removeClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            errorPlacement: function(error, element) {
                $(element).closest('div').append(error);
            }
         }).form()){
            var email = $("#p_email").val();
            $.post('controller/forgot_password.php',{'email' : email},function(data){
               $("#p_message").html(data).show();
            });
        }
     return false;
    });
    $("#r_send").off().on('click', function(){
        if($("#reg_form").validate({
            onkeyup: false,
            errorClass: 'error',
            validClass: 'valid',
            rules: {
                r_username: { required: true, minlength: 3 },
                r_password: { required: true, minlength: 3 },
                r_email: { required: true, minlength: 3, email: true }
            },
            highlight: function(element) {
                $(element).closest('div').addClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            unhighlight: function(element) {
                $(element).closest('div').removeClass("f_error");
                setTimeout(function() {
                    boxHeight()
                }, 200)
            },
            errorPlacement: function(error, element) {
                $(element).closest('div').append(error);
            }
        }).form()){
            var username = $("#r_username").val();
            var password = $("#r_password").val();
            var email = $("#r_email").val();
            $.post('controller/register.php',{'username' : username,'password' : password, 'email' : email},function(data){
                $("#r_message").html(data).show();
            });
        }
        return false;
    });
});
