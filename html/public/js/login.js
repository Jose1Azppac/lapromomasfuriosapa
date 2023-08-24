$(document).ready(function () {
    //console.log('hdhddh');
    var domain = domainEnv;
    function isEmpty(str){
        if (str==""){
            return true;
        }else{
            return false;
        }
    }
    function isValidAlpha(str){
        const alphaExp = /^[a-zA-ZÀ-ÿ\u00f1\u00d1 ]{4,80}$/;
        var isAlpha = true;
        if(!alphaExp.test(String(str))){
            isAlpha = false;
        }else{
            isAlpha = true;
        }
        return isAlpha;
    }
    function isEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    
    $("body").on('click','#sendBtn',function (e) { 
        e.preventDefault();
        $(".error").html("");
        var sendData = true;
        var dataFormArr = $("#loginForm").serializeArray();
        var iTotalFields = dataFormArr.length;

          //console.log(dataFormArr);
        for(var i=0;i<iTotalFields;i++){
            field = dataFormArr[i];
            if(isEmpty(field.value)){
                sendData = false;
                $('#error_requerido').fadeIn();
               console.log("Este campo es requerido");
                break;
            }
            if(sendData){
                /**Validamos los campos de tipo alfa */
                var isAlpha = $("#"+field.name).attr("alpha"); 
                if(isAlpha){
                    var alpha = isValidAlpha(field.value);
                    //console.log(alpha);
                    if(!alpha){
                        sendData = false;
                        $("#error_"+field.name).append("Este campo no permite números, ni caracteres especiales");
                        break;
                    }
                }
                /**End Validacion ALpha  */
                /**Validamos los campos de tipo email */
                var isEmailField = $("#"+field.name).attr("email");
                if(isEmailField){
                    var emailValid = isEmail(field.value);
                    if(!emailValid){
                        sendData = false;
                        $('#error_email').fadeIn();
                        $("#error_"+field.name).append("El email que intenta registrar es inválido");
                        break;
                    }
                }
                /**End Validacion de Email */
            }
        }

        if(sendData){
            var formToSend = $("#loginForm");
            var emaillogin = $("#email").val();
            var passwordmail = $("#password").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: domain +"/logindatauser",
                method:'POST',
                dataType: "json",
                data: {
                    emaillogin: emaillogin,
                    passwordmail: passwordmail,
                },
                success:function(data){
                    if(data==1){
                    
                    window.location.href = domain + "/registrar-codigo";
                        
                        
                    }else if(data==2){
                        $('#error_email_correcto').fadeIn();
                        $('#error_email_password').fadeOut();
                        $('#error_email_no_validado').fadeOut();
                    }else if(data==3){
                        $('#error_email_password').fadeIn();
                        $('#error_email_correcto').fadeOut();
                        $('#error_email_no_validado').fadeOut();
                    }else if(data==4){
                        $('#error_email_no_validado').fadeIn();
                        $('#error_email_correcto').fadeOut();
                        $('#error_email_password').fadeOut();
                    }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        }
    });
});