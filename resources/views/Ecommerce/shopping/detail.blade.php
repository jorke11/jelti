@extends('layouts.client')
@section('content')
<br>


<div class="row">

</div>
<div class="row">
    <div class="col-lg-12" style="padding: 0;">
        <img src="/{{$category->banner}}" class="img-responsive" style="width: 100%">
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        @foreach($subcategory as $val)
        <div class="col-lg-2">
            <div class="row"><div class="col-lg-12"><p class="text-center">{{ucwords($val->description)}}</p></div></div>
            <div class="row hover01"><div class="col-lg-12"><figure><img id="sub_{{$val->id}}]" src="/{{$val->img}}" alt="" class="img-responsive center-block" style="cursor:pointer" onclick="obj.selectedSubcategory()"></figure></div></div>
        </div>
        @endforeach
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<div style="background: #fffcf8;width: 100%;">
    <div class="row " style="padding-top: 20px;padding-left:50px;padding-right:50px;">
        @if (count($products)>0)
        <?php
        $cont = 0;
        ?>
        @foreach($products as $i => $val)

        <div class="col-sm-3 col-lg-3 col-md-3">
            <div class="thumbnail">
                <img src="https://placeholdit.imgix.net/~text?txtsize=39&txt=420%C3%97250&w=420&h=250">
                <div class="caption">
                    <h5 class="text-center"><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h5>
                    <p>
                    <h4 class="text-center">$ {{number_format($val->price_sf,2,",",".")}}</h4>
                    </p>
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