$('#form-code').submit(function(e){
    e.preventDefault();
    console.log('jola');
    let codigo = '';
    var producto = $('input[name="producto"]:checked').val();
    if (producto == 'snacks_salados' || producto == 'Tortix') {
        codigo = $('#codigo').val();
    }else if(producto == 'galletas') {
        codigo = $('#lote').val();
    }



    if(codigo.trim() != ''){
        $.ajax({
            url: ajaxurl,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            dataType:'json',
            data:{
                codigo:codigo,
                producto:producto
              },
            success: function(data){
                if(data.code == 0){$('#err_msg').html('Este código no existe, intenta con otro'); $('#err_lb').css('display', 'block')}
                if(data.code == 1){window.location = gameurl}
                if(data.code == 2){$('#err_msg').html('Este código ya ha sido registrado, intenta con otro'); $('#err_lb').css('display', 'block')}
                if(data.code == 3){$('#err_msg').html('Lo haz hecho muy bien, vuelve mañana para seguir participando.'); $('#err_lb').css('display', 'block')}
            }
        })
    }
})
