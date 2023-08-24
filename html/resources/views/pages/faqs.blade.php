@extends('layouts.master')
@section('title') FAQ's | La promo más furiosa @endsection

@section('content')
<main>
    <!-- // -->
    <div class="bal">
        <span></span>
    </div>
    <!-- // -->
    @include('modules.mod-flamas')
    <section>
        <div class="container">
            <!-- // -->
            <div class="h__sect">
                <h3>Faq's</h3>
            </div>
            <!-- // -->
            <!-- // -->
            <div class="cont__faqs">
                <h3>1.  ¿Cómo puedo participar?</h3>
                <div>
                    <ul>
                        <li>
                            <p>Participación con productos Frito Lay: Debes adquirir los productos que participan en la Promoción “La Promo Más Furiosa”, podrás identificarlos ya que poseen una tira externa. Introduce el código alfanumérico de la tira interna en www.PromocionesFritoLay.com, diviértete con el juego de memoria y acumula tantos puntos puedas para ser uno de los ganadores.</p>
                        </li>
                        <li>
                            <p>Participación con productos Gamesa: Debes adquirir los productos que participan en la Promoción “La Promo Más Furiosa”, Introduce el código de lote, que está impreso en el empaque en www.PromocionesFritoLay.com, diviértete con el juego de memoria y acumula tantos puntos puedas para ser uno de los ganadores.</p>
                        </li>
                    </ul>
                    <br>
                    <p>NOTA: Debes guardar todos los empaques de GAMESA ya que en el caso de ser ganador se solicitarán para poder entregar a los premios, de no tener los empaques no se entregará el premio y se pasará al siguiente posible ganador.</p>
                </div>
                <h3>2.  ¿Hay algún límite de participaciones diarias?</h3>
                <div>
                    <p>Podrás ingresar 15 códigos al día (11 de productos Frito Lay y 4 de productos Gamesa)</p>
                </div>
                <h3>3.  ¿Cada cuánto se anuncian a los ganadores?</h3>
                <div>
                    <p>Los ganadores se anuncian una vez que las participaciones se evalúan por completo, debido a esta evaluación, puede tomar de 3 a 4 semanas, posterior al cierre de bloque.</p>
                </div>
                <h3>4.  ¿Cómo se define al ganador del premio mayor (Viaje F1 MX)?</h3>
                <div>
                    <p>Una vez finalizada la promoción, se sacará un top #25 de cada bloque de participación, los cuales se unirán en un nuevo grupo del cual se procederá a invitar a un rally presencial para determinar al ganador final. No podrán participar en este rally:</p>
                    <br>
                    <ul>
                        <li>
                            <p>Personas que ya fueron ganadores de viajes o acompañantes de ganadores de viajes en promociones de Frito Lay o Gamesa en los últimos 2 años.</p>
                        </li>
                        <li>
                            <p>Ganadores de premios de dinero de $300 en adelante o su equivalente en dólares de La Promoción o de promociones pasadas de Frito Lay y Gamesa en los últimos 2 años.</p>
                        </li>
                    </ul>
                </div>
                <h3>5.  ¿Cómo sabré si fui ganador de algún premio?</h3>
                <div>
                    <p>Una vez evaluadas las participaciones de los posibles ganadores, y todo esté bien, nos pondremos en contacto contigo por correo electrónico o teléfono. Por favor, estar atento a tu correo electrónico/ teléfono.</p>
                </div>
                <h3>6.  ¿Cuántos años debo tener para participar?</h3>
                <div>
                    <p>Ese necesario tener al menos 18 años para participar en la promoción, es decir, ser mayor de edad.</p>
                </div>
                <h3>7.  ¿Hasta cuando puedo participar?</h3>
                <div>
                    <p>La promoción tiene una vigencia total del 20 de julio al 15 de septiembre del 2023, la cual se dividirá en los siguientes bloques de participación:</p>
                    <div>
                        <table>
                            <tr>
                                <td>Bloque 1</td>
                                <td>20 – 30 de julio</td>
                            </tr>
                            <tr>
                                <td>Bloque 2</td>
                                <td>31 julio – 13 agosto</td>
                            </tr>
                            <tr>
                                <td>Bloque 3</td>
                                <td>14 – 27 agosto</td>
                            </tr>
                            <tr>
                                <td>Bloque 4</td>
                                <td>28 agosto – 15 septiembre</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <h3>8.  ¿Mi premio es redimible por efectivo?</h3>
                <div>
                    <p>Los únicos premios en efectivo son los premios de $1,000. Los premios que no son en efectivo no pueden ser redimibles por efectivo.</p>
                </div>
                <h3>9.  ¿Qué hago si mi pregunta no aparece aquí?</h3>
                <div>
                    <p>Puedes contactarte a: contactopa@promocionesfritolay.com</p>
                </div>
            </div>
            <!-- // -->
        </div>
    </section>
</main>

@section('page-script')
<!-- Aqui van los demás scripts -->
<script>
    window.onload = function() {
        var
        bars = $('.loader div div')
        prom = $('.prom figure')
        loader = $('.loader')

        tl = new TimelineLite();
        tl
        .to(prom, .8,{y: '100%', delay: 1})
        .staggerFromTo(bars,3,{scaleY:1,},{scaleX:0, ease: Elastic.easeOut.config(1, 0.7)},0.15, '-=.7')
        .to(loader,.1,{autoAlpha: 0, display: 'none'}, '-=1')
    }
</script>
@stop
@endsection
