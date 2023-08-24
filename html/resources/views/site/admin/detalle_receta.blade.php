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
                        <label>Ticket de compra</label>
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active" id="product_1">
                                <img src="{{ url('storage/'.$detalleParticipacion->imagen_lote)}}" alt="" class="imageTicket"  />

                                
                            </div>
                        </div>
                        <br>             
                    </div>
                    <div class="details col-lg-5 col-md-12">
                        <p>
                            Nombre del usuario: {{$detalleParticipacion->name}}
                        </p>
                        <p>
                            Correo Electronico: {{$detalleParticipacion->email}}

                        </p>
                        <p>
                            Telefono: {{$detalleParticipacion->phone}}

                        </p>
                        <hr>
                        <label>Puntos del ticket</label>
                        <input type="text" name="puntos_ticket" id="puntos_ticket">
                        <hr>
                        <div class="alert alert-warning">
                            <strong>Atencion Admin!</strong> Verifica el ticket de compra para que la participacion sea valida.
                        </div>

                        <div class="action">
                            <!-- <div class="checkbox">
                                <input id="is_online" name="is_online" type="checkbox" value="1">
                                <label for="is_online">
                                    Es online?
                                </label>
                            </div> -->
                            <button class="btn btn-success btn-round waves-effect aceptar" type="button" data-value="{{$detalleParticipacion->id}}">Aceptar ticket</button>
                            <button class="btn btn-danger btn-round waves-effect rechazar" type="button" data-value="{{$detalleParticipacion->id}}">Rechazar ticket</button>
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
            var semana = $('#semana').val();
            var puntos = $('#puntos_ticket').val();
            var valor = $(this).attr('data-value');
            var resultClase =  $(this).attr('class').split(' ');
            var clase = resultClase[4];
            // var online = $('input[name=is_online]:checked').val();
            // if(online == 1){
                
            // }else{
            //     online = 0;
            // }
            $this = $(this);
            $thisB = this;
            swal({
                title: "¿Estás seguro de aceptar el Ticket de compra?",
                text: "¡Estas a punto de aceptar un Ticket de compra!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#18ce0f",
                confirmButtonText: "Si, Aprobar!",
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    AceptarMedico(valor,clase,_token,puntos);
                } else {
                    $this.val("");
                }
            });
        })

        function AceptarMedico(valor,clase,_token,puntos){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                url: "{{ url('cms/aceptarticket')}}",
                method:'POST',
                dataType: "json",
                data: {
                    id_recipe: valor,
                    action: clase,
                    puntos: puntos,
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