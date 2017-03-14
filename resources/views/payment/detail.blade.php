@extends('layouts.dash')

@section('content')
@section('title','Shop')
@section('subtitle','Management')
<div class="row">
    @if (count($products)>0)
    @foreach($products as $i => $val)
    <div class="col-sm-3 col-lg-3 col-md-3">
        <div class="thumbnail">
            <img src="https://placeholdit.imgix.net/~text?txtsize=39&txt=420%C3%97250&w=420&h=250">
            <div class="caption">
                <h4 class="pull-right">$ {{number_format($val->price_cust,2,",",".")}}</h4>
                <h4><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h4>
                <p>
                    See more snippets like this online store item at 
                </p>
                <div class="ratings">
                    <p class="pull-right">15 reviews</p>
                    <p>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if($i == 3)
        </div>
        <div class="row">
    @endif
    @endforeach
    @else
    <div class="col-sm-3 col-lg-3 col-md-3">Dont found</div>
    @endif
</div>
@endsection