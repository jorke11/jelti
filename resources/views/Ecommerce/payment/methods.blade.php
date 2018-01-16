@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 2%">
    <div class="col-lg-12" style="padding: 0;">
        <img src="http://via.placeholder.com/2000x100" class="img-responsive">
    </div>
</div>
<div class="row">
    {!! Form::open(['id'=>'frm','files' => true,'url' => 'payment/target']) !!}
    <input id="order_id" name="order_id" type="hidden">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            @foreach($banks as $val)
                            <div class="col-lg-2"><input type="radio" name="payment">{{$val["description"]}}</div>
                            @endforeach
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

{!!Html::script('js/Ecommerce/Methods.js')!!}
@endsection