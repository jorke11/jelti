@extends('layouts.client')
@section('content')
<br>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-lg-1">
                <h4>Categoria</h4>
            </div>
            <div class="col-lg-3">
                <a href="/payment">
                    <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                    <span class="badge">
                        <span id="quantityOrders"></span>
                    </span></a>
            </div>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <hr style="    border-top: 1px solid #8c8c8c;">
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="row">
            <div class="col-lg-7">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Product_{{$product["id"]}}&w=730&h=350" alt="">
                            <div class="carousel-caption">

                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <!--                <div class="thumbnail" >
                                    <img src="https://placeholdit.imgix.net/~text?txtsize=50&txt=Product_{{$product["id"]}}&w=730&h=350">
                                    <div class="caption">
                                        <p><a href="#" class="btn btn-success" role="button">
                                                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span><span class="badge">42</span>
                                            </a>
                                            <a href="#" class="btn btn-default" role="button">
                                                <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span><span class="badge">0</span>
                                            </a>
                                        </p>
                                    </div>
                                </div>-->
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                {{ucwords($product["title"])}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-muted">Unidades {{$product["units_sf"]}} &nbsp;
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </h4>
                            </div>
                        </div>

                    </div>
                </div>
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
                        <h4>Precio $ {{number_format($product["price_sf"],2,",",".")}}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="text-muted">Codigo: {{$product["reference"]}}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <hr>
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
                        <button class="btn btn-success form-control" id="AddProduct">Comprar</button>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>&nbsp;<span class="badge">42</span>&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>&nbsp;<span class="badge">0</span>&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>&nbsp;<span class="badge">10</span>
                        
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-muted">Productos Relacionados</h2>
            </div>
        </div>
    </div>

</div>

<!--<div class="row">
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
</div>-->

{!!Html::script('js/Ecommerce/detailProduct.js')!!}
@endsection