@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row row-space row-center" style="padding-top: 2%;padding-bottom: 2%;background-color: #FAF6EE;min-height: 110px">
        <div class="col-lg-1">
            <!--            <a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/alimentos-1.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/bebes-2.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/belleza-4.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/emprendimiento-7.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/hogar-3.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/mascotas-5.png" alt="">
            <!--</a>-->
        </div>
        <div class="col-lg-1">
            <!--<a style="padding:0px;border:0px;" rel="gallery1" href="shopping/">-->
            <img src="../images_blog/category/planeta-5.png" alt="">
            <!--</a>-->
        </div>
    </div>
    <div class="row" style="padding-top: 2%;padding-bottom: 3%">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="row row-space row" style="border:1px solid #ccc;padding: 0;margin: 0;" >
                <div class="col-lg-6" style="padding-left: 0">
                    <div class="row row-space">
                        <div class="col-lg-12">
                            <a href="{{url("blog/")}}" class="text-center center-block"><img src="../{{$last->img}}" class="img-responsive"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" >

                    <div class="row row-center" style="padding-top: 8%">
                        <div class="col-lg-4">
                            <!--<img src="../images_blog/category_line/belleza.png" alt="">-->
                            <img src="{{$last->img_category}}" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="padding-top: 2%">
                            <h2 class="text-center" >{{$last->title}}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="padding-top: 5%">
                            <p class="text-center"><a  href="{{url("blog/".$last->slug)}}" style="color:#30c594;font-size: 21px;font-weight: 700">Leer Más</a></p>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </div>
    <div class="row" style=";padding-bottom: 5%;background-color: #FAF6EE;padding-left: 5%;padding-right: 5%;">
        <br>
        <?php
        $cont = 0;
//        dd($data);
        ?>
        @foreach($data as $val)
        <div class="col-lg-4">
            <div class="thumbnail" style="padding: 0">
                <a href="{{url("blog/".$val["slug"])}}" ><img src="../{{$val["thumbnail"]}}" alt="..." class="img-responsive"></a>
                <div class="caption" >
                    <p class="text-center"><img src="../images_blog/category_line/belleza.png" alt="" width="30%"></p>
                    <h3 class="text-center"><a href="{{url("blog/".$val["slug"])}}">{{$val["title"]}}</a></h3>
                    <p style="min-height: 70px" class="text-center"><a href="{{url("blog/".$val["slug"])}}">{!!substr(strip_tags(trim($val["content"])),0,150)."..."!!}</a></p>
                    <!--<p><a href="blog/{{$val["slug"]}}" class="btn btn-primary" role="button">Ver Mas</a>--> 
                    <p  class="text-center text-muted">{{$val["timepost"]}}</p>
                </div>
            </div>
        </div>
        <?php
        $cont++;
        if ($cont == 3) {
            $cont = 0;
            ?>
        </div>
        <div class="row" style=";padding-bottom: 5%;background-color: #FAF6EE;padding-left: 5%;padding-right: 5%;">
            <?php
        }
        ?>
        @endforeach
    </div>
</div>



@endsection