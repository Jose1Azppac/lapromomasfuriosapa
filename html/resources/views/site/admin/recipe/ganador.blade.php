@extends('layout_cms.master')
@section('title', 'Detalle participación')
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
                                <img src="{{ url('storage'.$detalleParticipacion->image_final)}}" alt="" class="img-fluid" />
                                
                            </div>
                        </div>       
                    </div>
                    <div class="details col-lg-5 col-md-12">
                        <h3 class="product-title m-b-0">{{$detalleParticipacion->title_recipe}}</h3>
                        <a href="{{url('/')}}/ver-receta/{{$detalleParticipacion->id.'/'.$detalleParticipacion->slug_recipe}}" target="_blank">Ver Receta</a>
                        <hr>
                        <p>No. ticket: {{$detalleParticipacion->ticket_number}}
                            <br>
                            Nombre del usuario: {{$detalleParticipacion->name}} {{$detalleParticipacion->last_name}}
                        </p>
                        <p>
                            Numero telefónico: <a href="tel:{{$detalleParticipacion->phone}}">{{$detalleParticipacion->phone}}</a><br>
                            Correo Electronico: {{$detalleParticipacion->email}}

                        </p>
                        <p>Folio del cupón de Liverpool:</p>
                        <input type="text" name="cupon_liverpool" id="cupon_liverpool" class="form-control" placeholder="Folio del cupon">
                        <br>
                            <select class="form-control" tabindex="-98" id="semana" name="semana">
                                <option>Seleccione a la semana que será ganador</option>
                                @foreach($semanas as $semana)
                                    <option value="{{$semana->id}}">Semana del {{$semana->inicio}} al {{$semana->final}} </option>
                                @endforeach()
                            </select>
                        
                        

                        <div class="action">
                            <button class="btn btn-primary btn-round waves-effect aceptar" type="button" data-value="{{$detalleParticipacion->id}}">Otorgar premio</button>
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
    height:100px;
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
            var semana = $('#semana').val();
            var cupon_folio = $('#cupon_liverpool').val();

            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[4];
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de aceptar el registro del consultorio?",
                text: "¡Estas a punto de aceptar un registro del consultorio!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#18ce0f",
                confirmButtonText: "Si, Aprobar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    AceptarMedico(valor,clase,semana,_token,cupon_folio);
                } else {
                    $this.val("");
                }
            });
        })

        function AceptarMedico(valor,clase,semana,_token,cupon_folio){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/otorgarpremio')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_recipe: valor,
                    action: clase,
                    semana: semana,
                    _token: _token,
                    cupon_folio: cupon_folio
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


        $(".rechazar").click(function(evento){
            event.preventDefault();
            var _token = $('meta[name="csrf-token"]').attr('content');
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[4]; 
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de rechazar el Ticket de compra?",
                text: "¡Estas a punto de rechazar al Ticket de compra!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Rechazar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    RecharzarTicket(valor,clase,_token);
                } else {
                    $this.val("");
                }
            });
        });

        function RecharzarTicket(valor,clase,_token){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/rechazarticket')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_consultorio: valor,
                    action: clase,
                    _token: _token
                },
                success:function(data){
                    if(data==1){
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