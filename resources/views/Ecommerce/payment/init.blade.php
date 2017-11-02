@extends('layouts.client')
@section('content')
<br>
<div class="row">
    <!--{!! Form::open(['id'=>'frm','files' => true,'url' => 'payment/target']) !!}-->
    {!! Form::open(['id'=>'frm','files' => true,'url' => 'https://sandbox.gateway.payulatam.com/ppp-web-gateway/']) !!}
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
                            </div>
                            <div class="col-lg-6">
                                <h4>Orden De pago</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-detail">
<!--            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding-right:1%"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <img src="../assets/images/default.jpeg">
                                </div>
                                <div class="col-lg-7">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Titulo producto</h3>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="muted">Proveedor</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h4>$1000</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input type="number" id="quantity" name="quantity" class="form-control" min="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->


        </div>
    </div>

<!--    <input name="merchantId"    type="hidden"  value="{{$merchantId}}"   >
    <input name="accountId"     type="hidden"  value="{{$accountId}}" >
    <input name="description"   type="hidden"  value="{{$description}}"  >
    <input name="referenceCode" type="hidden"  value="{{$referenceCode}}" >
    <input name="amount"        type="hidden"  value="0" id="amount">
    <input name="tax"           type="hidden"  value="0" id="tax" >
    <input name="taxReturnBase" type="hidden"  value="0" id="taxReturnBase">
    <input name="currency"      type="hidden"  value="{{$currency}}" >
    <input name="signature"     type="hidden" id="signature" >
    <input name="test"          type="hidden"  value="1" >
    <input name="buyerEmail"    type="hidden"  value="{{$buyerEmail}}" >
    <input name="responseUrl"    type="hidden"  value="http://localhost:8000/payment/responsepay" >
    <input name="confirmationUrl"    type="hidden"  value="http://localhost:8000/payment/confirmationpay" >-->

    {!!Form::close()!!}


    <form method="post" action="https://sandbox.gateway.payulatam.com/ppp-web-gateway/">
        <input name="merchantId"    type="hidden"  value="{{$merchantId}}"   >
        <input name="accountId"     type="hidden"  value="{{$accountId}}" >
        <input name="description"   type="hidden"  value="{{$description}}"  >
        <input name="referenceCode" type="hidden"  value="{{$referenceCode}}" >
        <input name="amount"        type="hidden"  value="0">
        <input name="tax"           type="hidden"  value="0"  >
        <input name="taxReturnBase" type="hidden"  value="0" >
        <input name="currency"      type="hidden"  value="COP" >
        <input name="signature"     type="hidden"  value="613fb27115d9e4ee86564ed4caef9793"  >
        <input name="test"          type="hidden"  value="1" >
        <input name="buyerEmail"    type="hidden"  value="{{$buyerEmail}}" >
        <input name="responseUrl"    type="hidden"  value="http://localhost:8000/payment/responsepay" >
        <input name="confirmationUrl"    type="hidden"  value="http://localhost:8000/payment/confirmationpay" >
        <button type="submit" >Enviar</button>
    </form>

</div>


{!!Html::script('js/Ecommerce/Payment.js')!!}
@endsection