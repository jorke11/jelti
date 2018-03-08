@extends('layouts.blog')
@section('content')
<meta property="og:url"           content="{{url(Request::path())}}" />
<meta property="og:type"          content="http://www.superfuds.com/" />
<meta property="og:title"         content="SuperFuds" />
<meta property="og:description"   content="{{$data["title"]}}" />
<meta property="og:image"         content="{{url($category->image)}}" />

<div class="fb-share-button" data-href="http://www.superfuds.com/blog/top-10-nuestros-mejores-productos-2017" 
     data-layout="button" data-size="small" data-mobile-iframe="true">
    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.superfuds.com%2Fblog%2Ftop-10-nuestros-mejores-productos-2017&amp;src=sdkpreparse" 
       class="fb-xfbml-parse-ignore">Compartir</a></div>


<div id="fb-root"></div>
<div class="fb-share-button" 
     data-href="https://www.your-domain.com/your-page.html" 
     data-layout="button_count"></div>

<div class="container-fluid">
    <div class="row row-space row-center" style="padding-top: 2%;background-color: #FAF6EE;min-height: 100px;padding-bottom: 3%">
        <div class="col-lg-2">
            <a class="fancybox thumbnail" style="padding:0px;border:0px;display: inline" rel="gallery1" href="shopping/">
                @if(isset($category->image))
                <img src="{{url($category->image)}}" alt="">
                @endif
            </a>
        </div>
    </div>
    <div style="width: 100%;background-color: #FFFCF8;padding-top: 1%">
        <div class="row">

            <di                      v class="col-lg-8 col-lg-offset-2">
                <div class="thumbnail">
                    <img src="../{{$data["img"]}}">
                    <div class="caption">
                        <h2 class="text-center">{{$data["title"]}}</h2>
                        <p class="text-justify">
                            {!!$data["content"]!!}
                        </p>
                        <div class="ratings" style="padding-bottom: 2%">
                            <p class="pull-right">{{$writer->name}} {{$writer->last_name}} ({{date("Y-m-d",strtotime($data["created_at"]))}})</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    @if(count($products)>0)
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
                                <div class="col-sm-3 col-lg-3 col-md-3">
                                    <div class="thumbnail" style="padding: 0px">
                                        <img src="{{url($val->thumbnail)}}" onclick="objPage.redirectProduct('{{$value->slug}}')">
                                        <div class="caption" style="padding: 0px">
                                            <h5 class="text-center" style="height: 35px"><a href="/productDetail/{{$val->slug}}">{{$val->title}}</a></h5>
                                            <p>
                                            <h4 class="text-center">$ {{number_format($val->price_sf,0,",",".")}}</h4>
                                            </p>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <a href="/productDetail/{{$val->slug}}" class="btn btn-success form-control" style="background-color: #30c594;border:0px  ">Comprar</a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
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
            </div>
        </div>
    </div>
    @endif

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
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{url(Request::path())}}&amp;src=sdkpreparse"><img  src="{{ asset('images/facebook.png') }}"></a>
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
            {!! Form::open(['id'=>'frm']) !!}
            <input type="hidden" id="id" name='id' value="{{$data["id"]}}">
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
                            <button class="btn btn-success" style="width:100%;background-color: #30c594" type="submit">Enviar</button>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div>
    </div>

    <div class="row row-space">
        <div class="col-lg-7 col-lg-offset-3">
            @foreach($comments as $val)
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4>{{$val->title}}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="text-muted">{{$val->name}} {{$val->last_name}}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <p class="text-muted">{{$val->created_at}}</p>
                                </div>
                            </div>
                            <div class="row row-space">
                                <div class="col-lg-12">
                                    <p class="text-justify">
                                        {{$val->content}}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" style='cursor: pointer;font-size: 25px;'></span>&nbsp;<span class="badge">42</span>&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" style='cursor: pointer;font-size: 25px'></span>&nbsp;<span class="badge">0</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <span class="glyphicon glyphicon-comment" aria-hidden="true" style='cursor: pointer;font-size: 25px' onclick="obj.modalComment({{$val->id}})"></span>&nbsp;<span class="badge" >0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<script>
    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1";
    fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    
</script>

@endsection