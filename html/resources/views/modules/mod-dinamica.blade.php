<section class="dinamica" id="dinamica">
	@include('modules.mod-flamas')
	<!-- // -->
	<div class="bal">
		<span></span>
	</div>
	<!-- // -->
	<div class="container">
		<!-- // -->
		<div class="h__sect h__01">
			<h3>
				<i class="line l01"></i>
				Sigue estos pasos <br>
				<span>para participar</span>
				<i class="lna"></i>
				<i class="line l02"></i>
			</h3>
		</div>
		<!-- // -->
		<!-- // -->
		<div class="cont__pas">
			<div class="paso paso01">
				<div class="graf__paso">
					<figure>
						<img src="{{ asset('/img/paso01.webp') }}" alt="">
					</figure>
				</div>
				<div class="info__pas">
					<div class="num__pas">
						<span>1</span>
					</div>
					<div class="txt__pas">
						Compra Lay's, Cheetos, Doritos, Chokis, Emperador
					</div>
				</div>
			</div>
			<div class="paso paso02 codig">
				<!-- <div class="graf__paso">
					<figure>
						<img src="{{ asset('/img/paso02.svg') }}" alt="">
					</figure>
				</div> -->
				<div class="info__pas">
					<div class="num__pas">
						<span>2</span>
					</div>
					<div class="txt__pas">
						<a href="{{route('registrar-codigo')}}">Registra tus códigos o No. de lote de galletas</a>
					</div>
				</div>
			</div>
			<div class="paso paso03">
				<div class="graf__paso">
					<figure>
						<img src="{{ asset('/img/paso03.webp') }}" alt="">
					</figure>
				</div>
				<div class="info__pas">
					<div class="num__pas">
						<span>3</span>
					</div>
					<div class="txt__pas">
						Acumula puntos ¡y podrías ganar premios furiosos!
					</div>
				</div>
			</div>
		</div>
		<!-- // -->
	</div>
</section>