@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 2%">
    <div class="col-lg-12" style="padding: 0;">
        <img src="http://via.placeholder.com/2000x100" class="img-responsive">
    </div>
</div>
<div class="row">
    {!! Form::open(['id'=>'frm','url' => 'payment/credit']) !!}

    <input id="order_id" name="order_id" type="hidden">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">

                                <button type="submit" class="btn btn-success" id="btnPay">
                                    <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Payment
                                </button>
                                <button type="button" class="btn btn-info" id="btnPayU">
                                    <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> PayU
                                </button>
                            </div>
                            <div class="col-lg-6">
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

        <div id="content-detail">
        </div>
    </div>
    {!!Form::close()!!}
</div>

{!!Html::script('js/Ecommerce/Payment.js')!!}
@endsection