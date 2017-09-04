@extends('layouts.client')
@section('content')
<br>
<div class="row">
    {!! Form::open(['id'=>'frm','files' => true,'url' => 'payment/target']) !!}
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h4>Orden De pago</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <button type="submit" class="btn btn-success" id="btnPay">
                    <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Payment
                </button>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <table class="table table-condensed table-hover" id="tblReview">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Descripción</th>
                            <th>Cantidad</th>
                            <th width="140px">Precio</th>
                            <th width="10px">Del</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>


{!!Html::script('js/Ecommerce/Payment.js')!!}
@endsection