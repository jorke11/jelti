@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 2%">
    <div class="col-lg-12" style="padding: 0;">
        <img src="http://via.placeholder.com/2000x100" class="img-responsive">
    </div>
</div>
{!! Form::open(['id'=>'frm','url'=>'payment/target']) !!}
<input id="order_id" name="order_id" type="hidden" value='{{$id}}'>

<div class="row row-center">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row ">
                    <div class="col-lg-2">Nombre</div>
                    <div class="col-lg-5">Jorge</div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Apellido</div>
                    <div class="col-lg-5">Pinedo</div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Documento</div>
                    <div class="col-lg-5"><b>103239555</b></div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-2">Dirección Envio</div>
                    <div class="col-lg-5"><b>{{$client->address_send}}</b></div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-2">Tarjeta de Credito</div>
                    <div class="col-lg-5"><input type="text" name="target_number" id="target_numbers" class="form-control input" maxlength="16"></div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Expira (YYYY/MM)</div>
                    <div class="col-lg-3"><input type="text" name="expirate" id="expirate" class="form-control" placeholder="YYYY / MM" maxlength="7"></div>
                    <div class="col-lg-3">Código de Seguridad</div>
                    <div class="col-lg-3"><input type="text" name="crc" id="crc" class="form-control" maxlength="4"x></div>
                </div>
            </div>
            <div class="panel-footer">
                <button type="submit" id="btnPayment" class="btn btn-success">Pagar</button>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}

{!!Html::script('js/Ecommerce/Methods.js')!!}
@endsection