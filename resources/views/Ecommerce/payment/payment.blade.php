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
                    <div class="col-lg-2">Cliente</div>
                    <div class="col-lg-5">{{$client->business}}</div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Documento</div>
                    <div class="col-lg-5"><b>{{$client->document}}</b></div>
                </div>
                <div class="row">
                    <div class="col-lg-2">Dirección Envio</div>
                    <div class="col-lg-5"><b>{{$client->address_send}}</b></div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-2">Total</div>
                    <div class="col-lg-5"><b>{{$total}}</b></div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Tarjeta de Credito</label>
                            <input type="text" class="form-control input input-payment input-number" id="number" name="number" placeholder="Numero de tarjeta" maxlength="16" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Nombre como aparece en la tarjeta</label>
                            <input type="text" class="form-control input input-payment" id="name" name="name" placeholder="Nombre como aparece en la tarjeta" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Fecha de vencimiento</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <select class="form-control" id="month" name="month">
                                        @foreach($month as $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <select class="form-control" id="year" name="year">
                                        @foreach($years as $val)
                                        <option value="{{$val}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="tgarjeta">Código de Seguridad</label>
                            <input type="text" class="form-control input-number" id="crc" name="crc" placeholder="Código de Seguridad" maxlength="4" required>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <img src="{{url("images/tarjeta_codigo_seguridad.png")}}" width="70%">
                    </div>
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
