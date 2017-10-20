@extends('layouts.client')
@section('content')

<div class="row">

</div>
<div class="row">
    <div class="col-lg-12" style="padding: 0;">
        <img src="/{{$category->banner}}" class="img-responsive" style="width: 100%">
    </div>
</div>
<br>
<br>
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
        @foreach($products as $i => $val)

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
                <img src="https://placeholdit.imgix.net/~text?txtsize=39&txt=420%C3%97250&w=420&h=250">
                <div class="caption">
                    <h5 class="text-center"><a href="/productDetail/{{$val->id}}" style="color:black;font-weight: 400">{{$val->title}}</a></h5>
                    @if(Auth::user()!=null)
                    <p>
                    <h4 class="text-center" style="color:black;font-weight: 400">$ {{number_format($val->price_sf,2,",",".")}}</h4>
                    </p>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/productDetail/{{$val->id}}" class="btn btn-success form-control">Comprar</a>
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
</div>
{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection