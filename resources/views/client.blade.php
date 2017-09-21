@extends('layouts.client')
@section('content')
<style>

    .navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
        margin-left:150px;
        color: #13b671;          
        font-size: 20px;
        font-weight: bold;

    }
    .navbar-brand>img {
        display: inline;
    }
    .navbar-brand {
        padding: 10px 10px;
    }
    .navbar-default {
        background-color: white;
        box-shadow: 0 4px 4px -4px #9B9B9B;
    }
    .h3, h3 {
        color: #13b671;          
    }
    .navbar-form .form-control.search {
        width: 500px;
    }
    .color-superfuds{
        color: #13b671;
    }
    .white-label{
        color:white;
        font-size: 20px;
        text-shadow: 1px 1px 3px #000;
        font-weight:200;
        font-family: "Helvetica", Georgia, Serif;
        letter-spacing: 1px

    }
    .white-check{
        color:white;
        font-size: 12px;
        text-shadow: 1px 1px 3px #000;
        font-weight:200;
        font-family: "Helvetica", Georgia, Serif;
        letter-spacing: 1px

    }

    .green-bk{
        background: rgba(255,255,255,1);
        background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
        background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(0%, rgba(85,185,117,1)), color-stop(100%, rgba(92,230,214,1)));
        background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
        background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
        background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
        background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#5ce6d6', GradientType=1 );
    }
    .grey-bk{
        background: #fffcf8;
    }

</style>

<div class="row">
    <div class="col-lg-9 col-lg-offset-1">
        @if(Session::has('success'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success"><strong>Compra Realizada!</strong></div>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-9 col-lg-offset-1"><hr style="border-top: 1px solid #ccc"></div>
</div>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <img src="images/image_test.png" alt="Los Angeles" style="width:100%">
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<br>
<br>
<div class="row">
    <div class='col-md-10 col-lg-offset-1'>
        <div class="carousel slide media-carousel" id="mediaa">
            <div class="carousel-inner">
                <div class="item  active">
                    <div class="row">
                        <?php
                        $cont = 0;
                        foreach ($category as $i => $val) {
                            ?>
                            <div class="col-md-2">
                                <a class="fancybox thumbnail" rel="gallery1" href="shopping/<?php echo $val->id ?>">
                                    <img src="{{$val->image}}" alt="">
                                </a>
                            </div>
                            <?php
                            $cont++;
                            if ($cont == 4) {
                                $cont = 0;
                                ?>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <a class="left carousel-control" href="#media" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#media" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-lg-offset-2"><h4>Lo Nuevo</h4></div>
    <div class="col-lg-3 col-lg-offset-4"><h4>Ver Todo</h4></div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="carousel slide media-carousel" id="newproducts">
            <div class="carousel-inner">
                <div class="item  active">
                    <div class="row">
                        <?php
                        $cont = 0;
                        foreach ($category as $i => $val) {
                            ?>
                            <div class="col-md-2">
                                <a class="fancybox thumbnail" rel="gallery1" href="page/category/<?php echo $val->id ?>">
                                    <img src="{{$val->image}}" alt="">
                                </a>
                            </div>
                            <?php
                            $cont++;
                            if ($cont == 4) {
                                $cont = 0;
                                ?>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>


            <a class="left carousel-control" href="#newproducts" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#newproducts" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

            <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
            <a data-slide="next" href="#media" class="right carousel-control">›</a>
        </div>
    </div>
</div>
<br>
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-lg-offset-2"><h4>Sub-categorias</h4></div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            @foreach($subcategory as $val)
            <div class="col-lg-2">
                <div class="row"><div class="col-lg-12"><p class="text-center">{{ucwords($val->description)}}</p></div></div>
                <div class="row"><div class="col-lg-12"><img src="{{$val->img}}" alt="" class="img-responsive center-block" ></div></div>
            </div>
            @endforeach
        </div>
    </div>
    <br>
    <br>
</div> 
{!!Html::script('js/Ecommerce/Shopping.js')!!}
@endsection