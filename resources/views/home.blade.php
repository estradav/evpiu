@extends('layouts.architectui')

@section('page_title', 'Home')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'home' ]) !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <h5 class="card-header">Home</h5>
                <div class="card-body">
                    @can('usuarios.online')
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            @if ($user->isOnline())
                                                <span class="badge badge-success">Online</span>
                                            @else
                                                <span class="badge badge-secondary">Offline</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Nada por aqui...
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@stop

@push('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').dataTable({
                language: {
                    url: '/Spanish.json'
                },
                order: [
                    [ 2, "desc" ]
                ]
            });

            
            setTimeout(function() {
                window.location.reload(true);
            }, 120000);
        });
    </script>
@endpush
