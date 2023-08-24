<section class="juego" id="juego">
	@include('modules.mod-flamas')
	<div class="container">
		<!-- // -->
		<div class="h__sect h__01">
			<h3>
				<i class="line l01"></i>
				¿Tienes lo que se necesita <br>
				<span>para poder ganar?</span>
				<i class="lna"></i>
				<i class="line l02"></i>
			</h3>
			<p>Juega al memorama y acumula puntos</p>
		</div>
		<!-- // -->
		<div class="cont__ani">
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item active">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem10.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem03.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem02.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item active">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem10.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item active">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem09.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item active">
					<div class="card c__front">
						<figure><img src="{{ asset('/img/mem09.webp') }}" alt=""></figure>
					</div>
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
			<div class="cont__card">
				<div class="card__item">
					<div class="card c__back">
						<figure><img src="{{ asset('/img/logo_hot.webp') }}" alt=""></figure>
					</div>
				</div>
			</div>
		</div>
		<div class="c__cta">
			<a href="{{route('juego')}}" class="cta cta01"><span>¡Juega ahora!</span></a>
		</div>
	</div>
</section>