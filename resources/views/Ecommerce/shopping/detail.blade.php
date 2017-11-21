@extends('layouts.client')
@section('content')

<div class="row" style="padding-bottom: 3%">
    @if($category->banner!='')
    <img src="{{url($category->banner)}}" class="img-responsive" style="width: 100%">
    @else
    <img src="http://via.placeholder.com/2000x180" class="img-responsive">
    @endif
</div>

<div class="row" style="padding-bottom: 3%">
    <div class="col-lg-8 col-lg-offset-2">
        @foreach($subcategory as $val)
        <div class="col-lg-2">
            <div class="row">
                <div class="row hover01"><div class="col-lg-12"><figure><img id="sub_{{$val->id}}" src="/{{$val->img}}" alt="" class="img-responsive center-block" style="cursor:pointer" onclick="obj.selectedSubcategory()"></figure></div></div>
            </div>
            <div class="row" style="padding-top: 1%">
                <div class="col-lg-12" style="padding-top: 10%">
                    <p class="text-center" style="color:#9b9b9b">{{ucwords($val->description)}}</p>
                </div>

            </div>

        </div>
        @endforeach
    </div>
</div>

<div style="background: #fffcf8;width: 100%;">
    <div class="row " style="padding-top: 2%;padding-left: 2%;padding-right: 2%">
        @if (count($products)>0)
        <?php
        $cont = 0;
        ?>
        @foreach($products as $i => $value)

        <div class="col-sm-3 col-lg-3 col-md-3">
            <div class="thumbnail" style="border: 0;padding: 0">
                <div class="row" style="padding-bottom: 2%;padding-top: 2%">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                @foreach($subcategory as $val)
                                <div class="col-lg-2">
                                    <div class="row">
                                        <div class="row hover01">
                                            <div class="col-lg-12">
                                                <img width="60%" id="sub_{{$val->id}}" src="/{{$val->img}}" alt="" class="img-responsive center-block" style="cursor:pointer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <img src="http://via.placeholder.com/420x250">
                <div class="caption">
                    <h5 class="text-center"><a href="/productDetail/{{$value->id}}" style="color:black;font-weight: 400">{{$value->title}}</a></h5>
                    @if(!Auth::guest())
                    <p>
                    <h4 class="text-center" style="color:black;font-weight: 400">$ {{number_format($value->price_sf,2,",",".")}}</h4>
                    </p>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            @if(!Auth::guest())
                            <a href="/productDetail/{{$value->id}}" class="btn btn-success form-control">Comprar</a>
                            @else
                            <a href="/login" class="btn btn-success form-control">Comprar</a>
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
        <div class="row" style="padding-top: 20px;padding-left:50px;padding-right:50px;">
            <?php
        }
        ?>
        @endforeach
        @else
        <div class="col-sm-3 col-lg-3 col-md-3">Dont found</div>
        @endif

    </div>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-6">
            {{ $products->appends(['sort' => 'titiel'])->links() }}
        </div>
    </div>
</div>
{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection