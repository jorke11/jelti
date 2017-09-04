@extends('layouts.client')
@section('content')
<br>
<div class="row">
    <div class="col-lg-12" style="padding: 0;">
        <img src="/{{$category->image_title}}" class="img-responsive" style="width: 100%">
    </div>
</div>
<br>
<br>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        @foreach($subcategory as $val)
        <div class="col-lg-2">
            <div class="row"><div class="col-lg-12"><p class="text-center">{{ucwords($val->description)}}</p></div></div>
            <div class="row"><div class="col-lg-12"><img src="/{{$val->img}}" alt="" class="img-responsive center-block" ></div></div>
        </div>
        @endforeach
    </div>
</div>
<br>
<br>
<br>
<br>
<br>

<div class="row">
    @if (count($products)>0)
    <?php
    $cont = 0;
    ?>
    @foreach($products as $i => $val)

    <div class="col-sm-3 col-lg-3 col-md-3">
        <div class="thumbnail">
            <img src="https://placeholdit.imgix.net/~text?txtsize=39&txt=420%C3%97250&w=420&h=250">
            <div class="caption">
                <h4><a href="/productDetail/{{$val->id}}">{{$val->title}}</a></h4>
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
    <div class="row">
        <?php
    }
    ?>
    @endforeach
    @else
    <div class="col-sm-3 col-lg-3 col-md-3">Dont found</div>
    @endif

</div>
@endsection