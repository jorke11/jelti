@extends('layouts.blog')
@section('content')

<div class="row" style="padding-top: 3%">
   
    <div class="col-lg-6 col-lg-offset-3">
        <div class="thumbnail">
            <img src="http://via.placeholder.com/1050x500">
            <div class="caption">
                <h4><a href="/productDetail/">{{$data["title"]}}</a></h4>
                <p>
                   {{$data["content"]}}
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
</div>
@endsection