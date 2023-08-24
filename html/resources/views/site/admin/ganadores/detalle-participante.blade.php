@extends('layout_cms.master')
@section('title', 'Detalle participante')
@section('parentPageTitle', 'Dashboard')
@section('content')
<!-- Basic Examples -->

    <div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="preview col-lg-3 col-md-12">
                        
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="product_1">
                              

                                
                            </div>
                        </div>
                        <br>             
                    </div>
                    <div class="details col-lg-5 col-md-12">
                        <p>
                            Nombre del usuario: {{$detalle_users->name}}
                        </p>
                        <p>
                            Correo Electronico: {{$detalle_users->email}}

                        </p>
                        <p>
                            Telefono: {{$detalle_users->phone}}

                        </p>
                        <hr>
                       
                        <div class="alert alert-warning">
                            <strong>Atencion Admin!</strong> Verifica los datos del usuario antes de confirmar que es ganador semanal
                        </div>

                        <div class="action">
                            <div class="">
                                <label>SEMANAS</label>
                                <select id="semana_select" name="semana_select">
                                    <option value="0">Selecciona la semana</option>
                                    @foreach($semanas as $semana)
                                        <option value="{{$semana->id}}">{{$semana->inicio }} al {{ $semana->final}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <hr>
                            <button class="btn btn-success btn-round waves-effect aceptar" type="button" data-value="{{$detalle_users->id}}">Confirmar ganador</button>

                            <button class="btn btn-danger btn-round waves-effect quitar" type="button" data-value="{{$detalle_users->id}}">Quitar del ranking</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #END# Basic Examples --> 
<div class="row clearfix">
    <div class="col-md-12 col-lg-12">
        <div class="card active-bg">
            <div class="body">
                <p class="copyright m-b-0 text-white">Copyright 2021 © Saladitas</p>
            </div>
        </div>
    </div>
</div>
<div id="overlay"></div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/sweetalert/sweetalert.css') }}">
<style type="text/css">
.imageTicket {
    height:100%;
}
#overlay{
  position: fixed;
  top:0;
  left:0;
  width:100%;
  height:100%;
  background: rgba(0,0,0,0.8) none 50% / contain no-repeat;
  cursor: pointer;
  transition: 0.3s;
  
  visibility: hidden;
  opacity: 0;
}
#overlay.open {
  visibility: visible;
  opacity: 1;
}

#overlay:after { /* X button icon */
  content: "\2715";
  position: absolute;
  color:#fff;
  top: 10px;
  right:20px;
  font-size: 2em;
}
</style>
@stop

@section('page-script')
<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset('cms_front/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>

<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/tables/jquery-datatable.js') }}"></script>
<script src="{{ asset('cms_front/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function(){

        $('button.dropdown-toggle').hide();


        $('.imageTicket').on('click', function() {
          $('#overlay')
            .css({backgroundImage: `url(${this.src})`})
            .addClass('open')
            .one('click', function() { $(this).removeClass('open'); });
        });



        $(".aceptar").click(function(event){
            event.preventDefault();
            
            var _token = $('meta[name="csrf-token"]').attr('content');
            var semana = $('#semana_select').val();
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[4];
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de declarar al usuario ganador?",
                text: "¡Estas a punto de declarar un ganador!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#18ce0f",
                confirmButtonText: "Si, Aprobar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    AceptarMedico(valor,clase,_token,semana);
                } else {
                    $this.val("");
                }
            });
        })

        $(".quitar").click(function(event){
            event.preventDefault();
            
            var _token = $('meta[name="csrf-token"]').attr('content');
            
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[4];
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de quitar al usuario del ranking?",
                text: "¡Estas a punto de remover al usuario del ranking!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#18ce0f",
                confirmButtonText: "Si, Remover!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    QuitarUsuario(valor,clase,_token);
                } else {
                    $this.val("");
                }
            });
        })

        function QuitarUsuario(valor,clase,_token){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/quiteuserranking')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_recipe: valor,
                    action: clase,
                    _token: _token
                },
                success:function(data){
                    if(data == 1){
                        location.href = '{{route("participantes.index")}}';
                    }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        }

        function AceptarMedico(valor,clase,_token,semana){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/ganadorbycms')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_recipe: valor,
                    action: clase,
                    semana: semana,
                    _token: _token
                },
                success:function(data){
                    if(data == 1){
                        location.href = '{{route("participantes.index")}}';
                    }
                },
                error: function(resp){
                    console.log('algo salio mal');
                }
            });
        }
    });
</script>
@stop