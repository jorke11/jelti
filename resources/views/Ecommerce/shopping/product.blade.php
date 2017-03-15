@extends('layouts.dash')

@section('content')
@section('title','Shop')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-12">
        {{ucwords($product["title"])}}
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <div class="row">
            <div class="thumbnail" style="height: 120px;width:120px">
                <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Pro1&w=120&h=120">
                <div class="caption">
                    <p><a href="#" class="btn btn-success" role="button">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><span class="badge">42</span>
                        </a>
                        <a href="#" class="btn btn-default" role="button">
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><span class="badge">0</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="thumbnail" style="height: 120px;width:120px">
                <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Pro2&w=120&h=120">
                <div class="caption">
                    <p><a href="#" class="btn btn-success" role="button">
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><span class="badge">42</span>
                        </a>
                        <a href="#" class="btn btn-default" role="button">
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><span class="badge">0</span>
                        </a>
                    </p>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="thumbnail" style="height: 120px;width:120px">
                    <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Pro3&w=120&h=120">
                    <div class="caption">
                        <p><a href="#" class="btn btn-success" role="button">
                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><span class="badge">42</span>
                            </a>
                            <a href="#" class="btn btn-default" role="button">
                                <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><span class="badge">0</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-lg-6">
        <div class="thumbnail" style="height: 420px;width:710px">
            <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Product_{{$product["id"]}}&w=700&h=350">
            <div class="caption">
                <p><a href="#" class="btn btn-success" role="button">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><span class="badge">42</span>
                    </a>
                    <a href="#" class="btn btn-default" role="button">
                        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><span class="badge">0</span>
                    </a>
                </p>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <h4>Description</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" id="product_id" name="product_id" value="{{$product["id"]}}">
                {{$product["short_description"]}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h4>Detail</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {{$product["description"]}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                Quantity {{$product["packaging"]}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h4>Price</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                $ {{number_format($product["price_cust"],2,",",".")}}
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h4>Quantity X{{$product["packaging"]}}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <input class="form-control" id="quantity" name="quantity" value="1">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <button class="btn btn-success form-control" id="AddProduct">Add</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <h4>Comment</h4>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <textarea type="text" class="form-control" placeholder="Your comment!" id="txtComment"></textarea>
    </div>
    <div class="col-lg-1">
        <button class="btn btn-success" type="button" id="addComment">Submit</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="list-group" id="contentComment">
        </div>
    </div>
</div>

{!!Html::script('js/Ecommerce/detailProduct.js')!!}
@endsection