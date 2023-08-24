let tiempo          = 40000
let acumulado       = 0
let cronometrar     = false
let iconos          = [
        'mem01.webp',
        'mem02.webp',
        'mem03.webp',
        'mem04.webp',
        'mem05.webp',
        'mem06.webp',
        'mem07.webp',
        'mem08.webp',
        'mem09.webp',
        'mem10.webp',
]
let selecciones     = []
let cartas_totales  = 20
let aciertos        = 0

// Este numero tiene que ver con el delay en el CSS
let delay_start     = 2050

let tablero = document.getElementById('tablero')
let tarjetas = []
for (let index = 0; index < cartas_totales; index++) {
    tarjetas.push(`
    <div class="area-tarjeta" onclick="seleccionar_tarjeta(${index})">
        <div class="tarjeta" id="tarjeta_${index}">
            <div class="cara trasera" id="trasera_${index}">
                <img src="/pa/img/${iconos[0]}" alt=""></figure>
            </div>
            <div class="cara superior">
                    <figure><img src="/pa/img/logo_hot.webp" alt=""></figure>
            </div>
        </div>
    </div>
    `) 
    if(index%2==1){
    iconos.splice(0,1)
    }
}
tarjetas.sort(()=> Math.random() - 0.5)
tablero.innerHTML = tarjetas.join(" ")

let timerElement = document.getElementById('tiempo')
setInterval(function() {
    if(cronometrar){
        // tiempo++;
        // Convert milliseconds to seconds and milliseconds
        const seconds = Math.floor(tiempo / 1000)
        const milliseconds = tiempo % 1000

        // Format the time as "sec:milisec"
        const formattedTime = `${seconds.toString().padStart(2, '0')}:${milliseconds.toString().padStart(3, '0')}`

        // Update the timer element with the current time
        timerElement.textContent = formattedTime

        // Decrease the time by 10 milliseconds
        tiempo -= 10

        // Check if the timer has reached 0
        if (tiempo < 0) {
            let pop_end = document.querySelector('.mes02')
            let alerta = document.getElementById('msn__alert')

            clearInterval()
            cronometrar = false
            
            // Time is over, show modal with loader while getting the result
            $('#loading').css('display','inline-block')
            $('#puntos__acu').css('display','none')
            setTimeout(() => {
                pop_end.style.opacity = "1" 
            }, 10)
            pop_end.style.display = "block"
            alerta.style.opacity = "0"

            // Get the result and hide the loader then show the points
            $.ajax({
                url: score_url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data:{},
                success:    function(data){
                    $('#loading').css('display','none')
                    $('#puntos__acu').css('display','inline-block')
                    $('#puntos__acu').html(data.puntaje)
                }
            })
        }
    }
}, 10)

$('#iniciar_juego').click(function(e){
    e.preventDefault()
    // $.ajax({
    //     url: post_url,
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     type: "POST",
    //     data: {action:'init'},
    //     success:    function(data){console.log(data)},
    //     error:      function(data){console.log(data)}
    // });
    setTimeout(() => {
        acumulado = 0
        cronometrar = true
        pop_start.style.display = "none";
    }, delay_start);

    let pop_start = document.querySelector('.mes01');
        pop_start.style.opacity = "0";

    selecciones = []
    
    
    $('#iniciar_juego').remove()
    // Cards Anima
    var tarejta_me = $('#tablero .area-tarjeta'),
    tl = new TimelineLite();
    tl
    .staggerFromTo(tarejta_me, .9, {autoAlpha:0, scale:.4,}, {autoAlpha:1, scale:1, ease: Elastic.easeOut.config(1, 0.7)},0.10)
})


function seleccionar_tarjeta(index){
    let tarjeta = document.getElementById(`tarjeta_${index}`)
    if(tarjeta.style.transform != "rotateY(180deg)"){
        tarjeta.style.transform = "rotateY(180deg)"
        selecciones.push(index)
    }
    if(selecciones.length == 2){
        evaluar(selecciones)
        selecciones = []
    }
}

function evaluar(selecciones){
    setTimeout(() => {
        let trasera_seleccionada_1 = document.getElementById(`trasera_${selecciones[0]}`)
        let trasera_seleccionada_2 = document.getElementById(`trasera_${selecciones[1]}`)

        if(trasera_seleccionada_1.innerHTML != trasera_seleccionada_2.innerHTML){
            // No son la misma tarjeta, girar selecciones
            let tarjeta_seleccionada_1 = document.getElementById(`tarjeta_${selecciones[0]}`)
            let tarjeta_seleccionada_2 = document.getElementById(`tarjeta_${selecciones[1]}`)

            tarjeta_seleccionada_1.style.transform = "rotateY(0deg)"
            tarjeta_seleccionada_2.style.transform = "rotateY(0deg)"
        }
        else{
            // Son las mismas, aumentar el contador
            trasera_seleccionada_1.classList.add('active')
            trasera_seleccionada_2.classList.add('active')
            aciertos += 1
            $.ajax({
                url: post_url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                data:{},
                success:    function(data){
                    $('#loading').css('display','none')
                    $('#puntos__acu').css('display','inline-block')
                    $('#puntos__acu').html(data.puntaje)
                }
            })
            let contador = document.getElementById('contador')
                contador.innerHTML = aciertos
            
            // Termino del juego
            if(aciertos == (cartas_totales/2)){
                $('#loading').css('display','block')
                $('#puntos__acu').css('display','none')
                $.ajax({
                    url: score_url,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "POST",
                    data:{},
                    success:    function(data){
                        $('#loading').css('display','none')
                        $('#puntos__acu').css('display','inline-block')
                        $('#puntos__acu').html(data.puntaje)
                    }
                })
                cronometrar = false

                setTimeout(() => {
                    pop_end.style.opacity = "1" 
                }, delay_start)
                let pop_end = document.querySelector('.mes02')
                let alerta = document.getElementById('msn__alert')
                    pop_end.style.display = "block"
                    alerta.style.opacity = "0"
              
            }
        }

    }, 1000);
}