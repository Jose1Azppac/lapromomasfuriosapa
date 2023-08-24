<section class="ranking" id="ranking" style="display:none">
	<div class="container">
		<!-- // -->
		<div class="h__sect h__01">
			<h3>
				<i class="line l01"></i>
				Ranking
				<i class="lna"></i>
				<i class="line l02"></i>
			</h3>
		</div>
		<!-- // -->
		<!-- // -->
		<div class="c__cta btn__rank scrll">
			<div>
				<!--<a href="" class="cta cta01"><span>Diario</span></a>-->
				<a href="" class="cta cta02"><span>Bloques</span></a>
				<a href="" class="cta cta02"><span>Global</span></a>
			</div>
		</div>
		<!-- // -->
		<!-- // -->
		<div class="cont__sem scrll">
			<div>
				<!--<a href="" class="active">Semana 01</a>-->
				@foreach($weeks as $week)
					<a href="{{route('home',[ 'week' => $week->id ])}}"
                        class="{{ $week->status == 1 ? 'active' : null }}">Bloque {{$week->id}}</a>
				@endforeach
				<!--<a href="">Semana 02</a>
				<a href="">Semana 03</a>
				<a href="">Semana 04</a>
				<a href="">Semana 05</a>
				<a href="">Semana 06</a>
				<a href="">Semana 07</a>
				<a href="">Semana 08</a>
				<a href="">Semana 09</a>-->
			</div>
		</div>
		<!-- // -->
		<!-- // -->
		<!--<div class="slect__day">
            <div class="c__imp">
                <select id="operador">
                    <option value="0">Mar 11 de Abril</option>
                    <option value="1">Mier 12 de Abril</option>
                    <option value="2">Jue 13 de Abril</option>
                    <option value="3">Vie 14 de Abril</option>
                </select>
                <i><img src="{{ asset('/img/a_down.svg') }}" alt=""></i>
            </div>
        </div>-->
        <!-- // -->
        <!-- // -->
		<div class="cont__tab">
			<table>
				<thead>
					<tr>
						<td>Posición</td>
						<td>Usuario</td>
						<td>Puntos</td>
					</tr>
				</thead>
				<tbody>
                    @if($week)

                            <tr>
                                <td>1</td>
                                <td>Jose Francisco azpeitia</td>
                                <td>20</td>
                            </tr>

                    @endif
				</tbody>
			</table>
		</div>
		<!-- // -->
		<div class="nota">
			<p>Recuerda que este ranking es de carácter informativo y solo presenta resultados parciales que están sujetos a revisión y validación final.</p>
		</div>
		<div class="c__cta">
			<a href="{{route('ranking-semanal')}}" class="cta cta01"><span>Ver ranking completo</span></a>
		</div>
	</div>
</section>
