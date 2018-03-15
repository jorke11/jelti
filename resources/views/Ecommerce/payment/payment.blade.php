@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 2%">
    <div class="col-lg-12" style="padding: 0;">
        <img src="http://via.placeholder.com/2000x100" class="img-responsive">
    </div>
</div>
{!! Form::open(['id'=>'frm','url'=>'payment/target']) !!}
<input id="order_id" name="order_id" type="hidden" value='{{$id}}'>
@if(Session::has('error'))
<div class="row row-center">
    <div class="col-lg-4">
        <div class="alert alert-danger">{{Session::get('error')}}</div>
    </div>
</div>
@endif


<div class="row row-center">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Subtotal</label>
                            <input type="text" class="form-control input input-payment input-number" id="subtotal" value="{{$subtotal}}" readonly="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Total a Pagar</label>
                            <input type="text" class="form-control input input-payment input-number" id="total" value="{{$total}}" readonly="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Cliente</label>
                            <input type="text" class="form-control input input-payment input-number" id="client" value="{{$client->business}}" readonly="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tgarjeta">Documento</label>
                            <input type="text" class="form-control input input-payment input-number" id="document" value="{{$client->document}}" readonly="">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tgarjeta">Pais</label>
                            <select class="form-control" id="country_id">
                                @foreach($countries as $val)
                                <option value="{{$val["code"]}}">{{$val["description"]}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Dirección Envio</label>
                            <input type="text" class="form-control input input-payment input-number" id="address_send" value="{{$client->address_send}}" readonly="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Dirección Facturacion</label>
                            <input type="text" class="form-control input input-payment input-number" id="address_invoice" value="{{$client->address_invoice}}" readonly="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Tarjeta de Credito</label>
                            <input type="text" class="form-control input input-payment input-number" id="number" name="number" placeholder="Numero de tarjeta" maxlength="16" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="tgarjeta">Nombre como aparece en la tarjeta</label>
                            <input type="text" class="form-control input input-payment input-alpha" id="name" name="name" placeholder="Nombre como aparece en la tarjeta" required autocomplete="off" maxlength="15">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
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
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tgarjeta">Código de Seguridad</label>
                            <input type="text" class="form-control input-number" id="crc" name="crc" placeholder="Código de Seguridad" maxlength="4" required autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="tgarjeta">Coutas</label>
                            <select id="dues" name="dues" class="form-control">
                                <option value="1">1</option>
                                @for($i=2;$i<=36;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <img src="{{url("images/visa.png")}}" class="img-responsive hidden-xs">
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
