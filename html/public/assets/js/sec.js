// ! OFUSCAR EL CODIGO CON: https://skalman.github.io/UglifyJS-online/
// Verificar si la consola esta abierta o si llega a abrirse.
let consoleOpened = false;
function checkConsole() {
  if(consoleOpened && window.innerHeight === 0) {
    consoleOpened = false;
  } else if(!consoleOpened && window.innerHeight > 0) {
    let mensaje = `%cHas abierto la consola de desarrollador, se considera trampa, tu participacion será anulada y tu comportamiento será reportado.`
    console.log(mensaje, 'color: red; font-size: 20px;');
    consoleOpened = true;
    $('.lb02').css('display', 'block')
    $('#game_title').html(`
      <i class="line l01"></i>
      Vuelve a <br>
      <span>jugar</span>
      <i class="lna"></i>
      <i class="line l02"></i>
    `)
    $('.cont__juego').remove()
    $.ajax({
      url: cheater_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      data: {action:'La consola web ha sido abierta'}
    });
  }
}

// window.addEventListener("resize", checkConsole);
document.onkeydown = (e) => {
  using_command = false
  using_command = ''
  if (e.key == 123) {
    e.preventDefault();
    using_command=true;
    using_command='key 123';
  }
  if (e.key == 'F12') {
    e.preventDefault();
    using_command=true;
    using_command='key F12';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'I') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+shift+I';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'i') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+shift+i';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'C') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+shift+C';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'c') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+shift+c';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'J') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+shift+J';
  }
  if (e.ctrlKey && e.shiftKey && e.key == 'j') {
    e.preventDefault();
    using_command=true;
    using_command='ctrl+shift+j';
}
  if (e.ctrlKey && e.key == 'U') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+U';
  }
  if (e.ctrlKey && e.key == 'u') {
      e.preventDefault();
      using_command=true;
      using_command='ctrl+u';
  }
  if(using_command){
    $('.lb02').css('display', 'block')
    $('#game_title').html(`
      <i class="line l01"></i>
      Vuelve a <br>
      <span>jugar</span>
      <i class="lna"></i>
      <i class="line l02"></i>
    `)
    $('.cont__juego').remove()
    $.ajax({
      url: cheater_url,
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      data: {action:`Se han presionado las siguientes teclas => ${using_command}`}
    });
  }
}

document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
