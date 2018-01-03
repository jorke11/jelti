@extends('layouts.client')
@section('content')

<div class="container-fluid" style="padding-top: 6%">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="carousel slide media-carousel" id="newproducts">
                <div class="carousel-inner">
                    <div class="item  active">
                        <div class="row" style="padding-top: 1%;padding-bottom: 1%">
                            <?php
                            $cont = 0;
                            $max = count($subcategory) / 6;
                            $cur = 0;
                            foreach ($subcategory as $i => $val) {
//                            dd($val);
                                ?>
                                <div class="col-md-2" >
                                    <a class="fancybox thumbnail img-subcategory" style="padding:0px;border:0px;background-color: rgba(0,0,0,0)" rel="gallery1" href="_{{$val->id}}">
                                        <img src="{{url("/")."/".$val->img}}" alt="">
                                    </a>
                                </div>
                                <?php
                                $cont++;
                                if ($cont == 6) {
                                    $cur++;
                                    $cont = 0;
                                    if ($cur != $max) {
                                        ?>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row" style="padding-top: 1%;padding-bottom: 1%">
                                        <?php
                                    }
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
                <a class="right carousel-control" href="#newproducts" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <hr>
    </div>
</div>
@if(isset($_GET["search"]))
<div class="row row-space">
    <div class="col-lg-10">
        <h4>Resultados de la busqueda ({{count($products)}} productos relacionados):</h4>
    </div>
</div>
@endif

<section>
    <div class="row" style="padding-top: 2%;padding-bottom: 2%">
        <?php
        $cont = 0;
        foreach ($products as $value) {
            ?>
            <div class="col-lg-3">
                <div class="thumbnail" style="padding: 0">
                    <img src="/{{$value->thumbnail}}" alt="Pending">
                    <div class="caption" style="padding: 0">
                        <h5 class="text-center" style="min-height: 40px"><a href="/productDetail/{{$value->id}}" style="color:black;font-weight: 400;letter-spacing:2px"><?php echo $value->short_description; ?></a></h5>
                        @if(!Auth::guest())
                        <p>
                        <h4 class="text-center" style="color:black;font-weight: 400;">$ {{number_format($value->price_sf,2,",",".")}}</h4>
                        </p>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                @if(!Auth::guest())
                                <a href="/productDetail/{{$value->id}}" class="btn btn-success form-control" style="background-color: #30c594;">COMPRAR</a>
                                @else
                                <a href="/login" class="btn btn-success form-control" style="background-color: #30c594;">COMPRAR</a>
                                @endif

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
            <div class="row" style="padding-top: 2%;padding-bottom: 2%">
                <?php
            }
        }
        ?>
    </div>
    <div class="row row-center" style="padding-top: 2%;padding-bottom: 2%">
        <div class="col-lg-2 col-center">
            {{ $products->links() }}
        </div>
    </div>
</section>

@include("footer")

{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection