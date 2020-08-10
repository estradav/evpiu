@extends('layouts.architectui')

@section('page_title', 'Requerimientos admistracion')

@section('action_recaptcha')
    {!! htmlScriptTagJsApi([ 'action' => 'mesa_ayuda_requerimientos_admon' ]) !!}
@endsection

@section('content')
    <div class="main-card mb-3 card">
        <div class="card-body">
            <embed src="http://glpi.ciev.local/marketplace/formcreator/front/formdisplay.php?id=1" width="100%" height="1100" quality="high" type="text/html" id="object">
        </div>
    </div>

@endsection
@push('styles')
    <style>
        #document. #header {
            display: none;
        }
    </style>
@endpush
