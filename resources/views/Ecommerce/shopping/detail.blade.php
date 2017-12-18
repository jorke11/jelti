@extends('layouts.client')
@section('content')
<!--<style>
    .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover{
        background-color: #30c594;
        border:1px solid #30c594;
        color:black;
    }

    .pagination>li>a, .pagination>li>span>a{
        color:black;
    }


    .form-control{
        border-radius: 0;
        background-color: #30c594;
    }
</style>-->
<div class="row" style="padding-bottom: 3%;padding-top: 3%">

    @if($category->banner!='')
    <img src="{{url("/")."/".($category->banner)}}" class="img-responsive" style="width: 100%">
    @else
    <img src="http://via.placeholder.com/2000x180" class="img-responsive">
    @endif
</div>



<div class="container-fluid">
    <div class="row row-space">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="carousel slide media-carousel" id="newproducts">
                <div class="carousel-inner">
                    <div class="item  active">
                        <div class="row" style="padding-top: 1%;padding-bottom: 1%">
                            <?php
                            $cont = 0;
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
                <a class="right carousel-control" href="#newproducts" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>


@foreach($categoryAssoc as $val)
@if(count($val->products)>0)
<div class="row" style="padding-top: 2%;padding-bottom: 2%">
    <div class="col-lg-12">
        <p class="text-center" style="font-size:25px"><span class="underline">{{$val->description}}</span></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">

    </div>
</div>


<section style="background-color: #FAF6EE;padding-top: 1%;padding-bottom: 2%">   
    <!--<div class="container-fluid">-->
    <div class="row" >
        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
            <div class="carousel slide media-carousel" id="newproducts_{{$val->id}}">
                <div class="carousel-inner">
                    <div class="item  active">
                        <div class="row">
                            <?php
                            $cont = 0;
                                dd($val->products);
                            foreach ($val->products as $i => $value) {
                                ?>
                                <div class="col-md-3 col-sm-2 col-xs-2">
                                    <div class="thumbnail" style="border: 0;padding: 0">
                                        <img src="{{url("/")."/".$value->thumbnail}}">
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

                <a class="left carousel-control" href="#newproducts_{{$val->id}}" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#newproducts_{{$val->id}}" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
        </div>
        <!--</div>-->
    </div>

</section>
@endif
@endforeach
@include("footer")

{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection