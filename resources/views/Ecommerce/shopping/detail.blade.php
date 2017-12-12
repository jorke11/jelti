@extends('layouts.client')
@section('content')
<style>
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
</style>

<div class="row" style="padding-bottom: 3%;padding-top: 3%">
    @if($category->banner!='')
    <img src="{{url("/")."/".($category->banner)}}" class="img-responsive" style="width: 100%">
    @else
    <img src="http://via.placeholder.com/2000x180" class="img-responsive">
    @endif
</div>

<div class="row row-space">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="carousel slide media-carousel" id="newproducts">
            <div class="carousel-inner">
                <div class="item  active">
                    <div class="row" style="padding-top: 1%;padding-bottom: 1%">
                        <?php
                        $cont = 0;

                        foreach ($subcategory as $i => $val) {
                            ?>
                            <div class="col-md-1" >
                                <a class="fancybox thumbnail img-subcategory" style="padding:0px;border:0px;background-color: rgba(0,0,0,0)" rel="gallery1" href="_{{$val->id}}">
                                    <img src="{{url("/")."/".$val->image}}" alt="">
                                </a>
                            </div>
                            <?php
                            $cont++;
                            if ($cont == 11) {
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
        </div>
    </div>
</div>


<div style="background: #fffBF2;width: 100%;padding-top:2%">
    <div class="row" >
        <div class="col-lg-10 col-lg-offset-1">
            @if (count($products)>0)
            <?php
            $cont = 0;
            ?>
            @foreach($products as $i => $value)

            <div class="col-sm-2 col-lg-2 col-md-3" style="width: 20%">
                <div class="thumbnail" style="border: 0;padding: 0">
                    <div class="row" >
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    @if($value->characteristic!=null)
                                    @foreach($value->characteristic as $val)
                                    <div class="col-lg-2">
                                        <div class="row">
                                            <div class="row hover01">
                                                <div class="col-lg-12">
                                                    <img width="60%" id="sub_{{$val->id}}" src="/{{$val->thumbnail}}" alt="" class="img-responsive center-block" style="cursor:pointer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <img src="{{url("/")."/".$value->thumbnail}}">
                    <div class="caption" style="padding: 0">
                        <h5 class="text-center" style="height: 38px"><a href="/productDetail/{{$value->id}}" style="color:black;font-weight: 400;letter-spacing:2px"><?php echo $value->short_description; ?></a></h5>
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
            if ($cont == 5) {
                $cont = 0;
                ?>
            </div>
            <div class="row" >
                <div class="col-lg-10 col-lg-offset-1">
                    <?php
                }
                ?>
                @endforeach
                @else
                <div class="col-sm-3 col-lg-3 col-md-3">Dont found</div>
                @endif

            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-lg-offset-6">
                {{ $products->appends(['sort' => 'titiel'])->links() }}
            </div>
        </div>
    </div>
    {!!Html::script('js/Ecommerce/Detail.js')!!}
    @endsection