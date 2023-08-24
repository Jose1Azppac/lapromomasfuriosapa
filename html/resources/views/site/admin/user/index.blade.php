@extends('layout_cms.master')
@section('parentPageTitle', 'Participantes')
@section('title', 'Participantes')

    
@section('sub-action-bar')

@stop


@section('content')
<!-- usuarios -->
@csrf
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Usuarios</strong></h2>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Accion</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #END# usuarios --> 
@stop

@section('page-popup')

@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('cms_front/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('cms_front/plugins/sweetalert/sweetalert.css') }}">
@stop

@section('page-script')





<script type="text/javascript">

    function reloadBtns() {
        $('.sweetalert-button-confirm').on('click', function () {
            var $userId = $(this).data('id');
            showConfirmMessage( $userId );
        });
    }

    function showConfirmMessage( userId ) {
        swal({
            title: "ALERTA",
            text: "¡No podrás recuperar este usuario!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "¡Sí, bórralo!",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function (isConfirm) {
            if (isConfirm) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = { 
                    "id": userId
                };

                var type = "DELETE";
                var ajaxurl = '{{ url('/dashboard') }}' + '/user/' + userId;
                $.ajax({
                    type: type,
                    url: ajaxurl,
                    data: formData,
                    dataType: 'JSON',
                    success: function (data) {
                        swal("¡Eliminado!", "El usuario has sido borrado.", "success");
                        $('.yajra-datatable').DataTable().ajax.reload( reloadBtns );

                    },
                    error: function (data) {
                        swal("ERROR!", "ERROR", "error");
                    }
                });                
            } else {
                swal("¡Cancelado!", "El Usuario esta a Salvo", "error");
            }
        });
    }

    $(function () {

        @if(session()->get('success'))
            showNotification('bg-green', '{{ session()->get('success') }}', 'top', 'center', '', '');  
        @endif

        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
    
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            initComplete: function(settings, json) {
                 $('.sweetalert-button-confirm').on('click', function () {
                    var $userId = $(this).data('id');
                    showConfirmMessage( $userId );
                });
            },
            ajax: "{{ route('participantes.index') }}",
            order: [ [0, 'desc'] ],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        }); 
    });
</script>

<!-- Notification --> 
<script src="{{ asset('cms_front/bundles/libscripts.bundle.js') }}"></script> 
<script src="{{ asset('cms_front/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/ui/notifications.js') }}"></script>

<!-- Jquery Sweet Alert --> 
<script src="{{ asset('cms_front/plugins/sweetalert/sweetalert.min.js') }}"></script>

<!-- Jquery DataTable Plugin Js --> 
<script src="{{ asset('cms_front/bundles/datatablescripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('cms_front/plugins/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('cms_front/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('cms_front/js/pages/tables/jquery-datatable.js') }}"></script>
@stop