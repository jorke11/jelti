@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 2%">
    <div class="col-lg-12" style="padding: 0;">
        <img src="http://via.placeholder.com/2000x100" class="img-responsive">
    </div>
</div>

{!! Form::open(['id'=>'frm','url' => 'payment/credit']) !!}

<input id="order_id" name="order_id" type="hidden">

<div class="row hidden" id="message-mount">
    <div class=" col-lg-offset-1 col-lg-10">
        <div class="alert alert-danger">El monto total debe ser Mayor a $10.000 Pesos</div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-lg-offset-1">
        <div id="content-detail">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-success" id="btnPay">
                            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Payment
                        </button>
                        <button type="button" class="btn btn-info" id="btnPayU">
                            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> PayU
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="text-right">Facturado</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="text-left">{{$client->business}}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="text-right">SubTotal</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="text-left"><span id="subtotalOrder"></span></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="text-right">Total</h4>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="text-left"><span id="totalOrder"></span></h4>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}


{!!Html::script('js/Ecommerce/Payment.js')!!}
@endsection