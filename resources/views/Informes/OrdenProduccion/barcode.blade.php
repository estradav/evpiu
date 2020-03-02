@foreach($Orders as $Order)

    <div class="row" style="height: 141px;margin: 36px;padding: 0px;">
        <div class="col">
            <strong>CANTIDAD:</strong>{{ $Order->ORGQTY_10 }} <br/>
            <strong>ID PIEZA:</strong>{{ $Order->PRTNUM_10 }} <br/>
            <strong>PEDIDO:</strong>{{ substr($Order->ORDREF_10,0,12) }}<br/>
            <strong>MARCA:</strong>{{ $Order->LOTNUM_10 }}<br/>
            <strong>REFERENCIA:</strong>{{ $Order->UDFREF_10 }}<br/>
        </div>
        <div class="col-4 text-center" style="  margin: 0;">
            <h3>CONTROL DE PRODUCION </h3>
            <h3></h3>
            {{ $code = '31'.$Order->ORDNUM_10.'00001' }} <br>
            <img class="center-block"  src="data:image/png;base64,{{DNS1D::getBarcodePNG($code, "C128")}}"><br>


            <h3></h3>
        </div>
        <div class="col-4">
            <strong>FECHA CREACION:</strong>{{ $Order->FechaCreacion }}<br/>
            <strong>FECHA IMPRESION:</strong>{{ Carbon\Carbon::now() }} <br/>
        </div>
    </div>
    <hr>
@endforeach

<style>
    .code {
        height: 80px !important;
    }

    hr {
        display: block;
        position: relative;
        padding: 0;
        margin: 8px auto;
        height: 0;
        width: 100%;
        max-height: 0;
        font-size: 1px;
        line-height: 0;
        clear: both;
        border: none;
        border-top: 1px solid #000000;
    }
</style>
