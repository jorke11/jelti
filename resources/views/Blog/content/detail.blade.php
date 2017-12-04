@extends('layouts.blog')
@section('content')
<!--<div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">{{$data["title"]}}</h1>
    </div>
</div>-->
<!--<div class="row">
<img src="{{url("images/header_blog.png")}}" width="100%" height="250px">
</div>-->
<div style="width: 100%;background-color: #FFFCF8">
    <div class="row">

        <div class="col-lg-8 col-lg-offset-2">
            <div class="thumbnail">
                <img src="../{{$data["img"]}}">
                <div class="caption">
                    <h2 class="text-center">{{$data["title"]}}</h2>
                    <p class="text-justify">
                        {!!$data["content"]!!}
                    </p>
                    <div class="ratings" style="padding-bottom: 2%">
                        <p class="pull-right">Mariana Villegas ({{date("Y-m-d",strtotime($data["created_at"]))}})</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-space">
        <div class="col-lg-8 col-lg-offset-2" style="background-color: #fff">
            <div class="row">
                <div class="col-lg-4">
                    <hr>
                </div>
                <div class="col-lg-4">
                    <h2 class="text-center" style="color:#30c594">Compra estos productos</h2>
                </div>
                <div class="col-lg-4">
                    <hr>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-lg-8 col-lg-offset-2" >
            <div class="carousel slide media-carousel" id="newproducts">
                <div class="carousel-inner">
                    <div class="item  active">
                        <div class="row" style="padding-top: 2%;padding-bottom: 2%">
                            <?php
                            $cont = 0;
                            foreach ($products as $i => $val) {
                                ?>
                                <div class="col-sm-3 col-lg-2 col-md-3">
                                    <div class="thumbnail" style="padding: 0px">
                                        <img src="{{url($val->thumbnail)}}">
                                        <div class="caption" style="padding: 0px">
                                            <h5 class="text-center" style="height: 35px"><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h5>
                                            <p>
                                            <h4 class="text-center">$ {{number_format($val->price_sf,2,",",".")}}</h4>
                                            </p>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="/productDetail/{{$val->id}}" class="btn btn-success form-control" style="background-color: #30c594;border:0px  ">Comprar</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php
                                $cont++;
                                if ($cont == 6) {
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
            </div>
        </div>
    </div>

    <div class="row row-space">
        <div class="col-lg-8 col-lg-offset-2" style="background-color: #fff">
            <div class="row">
                <div class="col-lg-4">
                    <hr>
                </div>
                <div class="col-lg-4">
                    <h2 class="text-center">Comparte este artículo</h2>
                </div>
                <div class="col-lg-4">
                    <hr>
                </div>
            </div>
            <div class="row" style="padding-top: 3%">
                <div class="col-lg-7 col-lg-offset-3"  style="background-color: #fff;padding-left: 10%;padding-bottom: 5%">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="#"><img  src="{{ asset('images/facebook.png') }}"></a>
                        </div>
                        <div class="col-lg-3">
                            <a href="#"><img  src="{{ asset('images/instagram.png') }}"></a>
                        </div>                                                                                
                        <div class="col-lg-3">
                            <a href=""><img  src="{{ asset('images/twitter.png') }}"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row row-space">
        <div class="col-lg-8 col-lg-offset-2" style="background-color: #fff">
            <div class="row row-space">
                <div class="col-lg-12">
                    <h2 class="text-center">Comenta</h2>
                </div>
            </div>
            <div class="row row-space">
                <div class="col-lg-6 col-lg-offset-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Titulo:</label>
                                <input type="text" class="form-control" id="title" name='title'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Cuentanos tu experiencia:</label>
                                <textarea class="form-control" rows="7" name="comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Tu nombre:</label>
                                <input type="text" class="form-control" id="name" name='name'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">Tu Email:</label>
                                <input type="text" class="form-control" id="email" name='email'>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-success" style="width:100%;background-color: #30c594">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection