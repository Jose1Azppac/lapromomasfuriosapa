<header id="header" class="header">
	<div class="cont__menu">
		<!-- // Logo -->
		<h1 class="logo">
			<a href="./">
				<span>Lays | La promo más furiosa</span>
				<figure>
					<img src="{{ asset('/img/logo.svg') }}" alt="">
				</figure>
			</a>
		</h1>
		<!-- // Logo -->
		<!-- // Menu -->
		<div class="menu">
			<div class="bg__menu"></div>
			<div class="opt__menu">
				<div>
					<nav>
						<ul>
							<li><a href="./#inicio">Inicio</a></li>
							<li><a href="./#dinamica">Dinámica</a></li>
							<li><a href="./#premios">Premios</a></li>
							<li><a href="{{route('ranking-semanal')}}">Ranking</a></li>
							<li><a href="{{route('ganadores')}}">Ganadores</a></li>
							@auth
							<!--// Usuario Logueado -->
							@if(env('COUNTRY_NOM') == 'ec' || env('COUNTRY_NOM') == 'pe')
							<li class="user__opt user__log log__02"><a href="{{route('perfil')}}">Perfil</a></li>
							<li class="user__opt user__log log__03"><a href="{{route('logout')}}">Cerrar Sesion</a></li>
							@else
							<li class="user__opt user__log log__01"><a href="{{route('juego')}}">Jugar</a>
							<li class="user__opt user__log log__02"><a href="{{route('perfil')}}">Perfil</a></li>
							<li class="user__opt user__log log__03"><a href="{{route('logout')}}">Cerrar Sesion</a></li>
							@endif
							<!--// Usuario Logueado -->
							@else
							<!--// Usuario Deslogueado -->
							<li class="user__opt user__des des__01"><a href="{{route('iniciar-sesion')}}">Iniciar sesión</a></li>
							<li class="user__opt user__des des__02"><a href="{{route('registro')}}">Regístrate</a></li>
							<!--// Usuario Deslogueado -->
							@endauth
							<li class="user__opt"><a href="#legales">Legales</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		<!-- // Menu -->
		<!-- // Bnt Mob -->
		<div class="btn__mb">
			<div class="bars">
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<!-- // Bnt Mob -->
	</div>
</header>