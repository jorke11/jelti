@extends('layouts.blog')
@section('content')

<div class="row" style="padding-top: 3%">

    <div class="col-lg-6 col-lg-offset-3">
        <div class="thumbnail">
            <img src="../{{$data["img"]}}">
            <div class="caption">
                <h4><a href="/productDetail/">{{$data["title"]}}</a></h4>
                <p>
                    {!!$data["content"]!!}
                </p>
                <div class="ratings">
                    <p class="pull-right">15 reviews</p>
                    <p>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star"></span>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="fb-comments" data-href="http://localhost/blog/prueba-desde-tinker-para-jelti" data-width="100%" data-numposts="10"></div>
    </div>
</div>

<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.11';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

@endsection