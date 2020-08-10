@extends('layouts.architectui')

@section('page_title', 'formulario 1')

@section('content')

    <div>
        <object data="http://glpi.ciev.local/marketplace/formcreator/front/formdisplay.php?id=2" width="400" height="300" type="text/html">
            Alternative Content
        </object>

    </div>



@endsection

@push('javascript')
    <script>
        $(document).ready(function () {
            $("#mydiv")
                .html('<object data=""/>');
        })
    </script>
@endpush
