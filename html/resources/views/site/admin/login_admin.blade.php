@extends('layout_cms.authentication')
@section('title', 'admin')

@section('content')
<div class="col-md-12 content-center">
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12">
            <div class="company_detail">
                <h4 class="logo"><img src="{{ asset('img/logo.svg') }}" alt="Logo" style="margin-top: 30px;"></h4>
                <h2>El sabor que nos une<sup></sup></h2><h3><strong> Acceso al </strong>administrador.</h3>
                <p>Favor de colocar su cuenta de correo electronico y la contraseña que se le asigno.</p>                        
                <div class="footer">
                    <!-- <ul  class="social_link list-unstyled">
                        <li><a href="https://thememakker.com" title="ThemeMakker"><i class="zmdi zmdi-globe"></i></a></li>
                        <li><a href="https://themeforest.net/user/thememakker" title="Themeforest"><i class="zmdi zmdi-shield-check"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/thememakker/" title="LinkedIn"><i class="zmdi zmdi-linkedin"></i></a></li>
                        <li><a href="https://www.facebook.com/thememakkerteam" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>
                        <li><a href="http://twitter.com/thememakker" title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
                        <li><a href="http://plus.google.com/+thememakker" title="Google plus"><i class="zmdi zmdi-google-plus"></i></a></li>
                        <li><a href="https://www.behance.net/thememakker" title="Behance"><i class="zmdi zmdi-behance"></i></a></li>
                    </ul> -->
                    <hr>
                    <!-- <ul class="list-unstyled">
                        <li><a href="http://thememakker.com/contact/" target="_blank">Contact Us</a></li>
                        <li><a href="http://thememakker.com/about/" target="_blank">About Us</a></li>
                        <li><a href="http://thememakker.com/services/" target="_blank">Services</a></li>
                        <li><a href="javascript:void(0);">FAQ</a></li>
                    </ul> -->
                </div>
            </div>
        </div>                        
        <div class="col-lg-5 col-md-12 offset-lg-1">
            <div class="card-plain">
                <div class="header">
                    <h5>Log in</h5>
                </div>
                <form class="form" method="POST" action="{{route('cms.verificar')}}">
                    {{csrf_field()}}
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Correo electronico" id="email" name="email">
                        <span class="input-group-addon"><i class="zmdi zmdi-account-circle"></i></span>
                    </div>
                    <div class="input-group">
                        <input type="password" placeholder="Password" class="form-control" id="password" name="password">
                        <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                    </div>
                     <div class="footer">
                       <!--  <a href="" class="btn btn-primary btn-round btn-block">Entrar</a> -->
                       <button type="submit" class="btn btn-primary btn-round btn-block">Entrar</button>
                     </div>                      
                </form>
               
            </div>
        </div>
    </div>
</div>

@stop