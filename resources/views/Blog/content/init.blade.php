@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row" style="padding-top: 2%;padding-bottom: 5%">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="row row-space" style="border:1px solid #000;padding: 0;margin: 0;" >
                <div class="col-lg-6" style="padding-left: 0">
                    <a href="blog/{{$last->slug}}"><img src="{{$last->thumbnail}}" style="width:100%;height: 400px"></a>
                </div>
                <div class="col-lg-6" >
                    
                    <div class="row">
                        <div class="col-lg-12" style="padding-top: 15%">
                            <h2 class="text-center" >{{$last->title}}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="padding-top: 10%">
                            <p class="text-center"><a  href="blog/{{$last->slug}}" style="color:#30c594;font-size: 21px;font-weight: 700">Leer Más</a></p>
                        </div>
                    </div>
                    
                </div> 
            </div>

            <div class="row" style="padding-top: 2%">
                <?php
                $cont = 0;
                ?>
                @foreach($data as $val)
                <div class="col-lg-4">
                    <div class="thumbnail" style="padding: 0">
                        <a href="blog/{{$val["slug"]}}" ><img src="{{$val["thumbnail"]}}" alt="..." style="width: 100%"></a>
                        <div class="caption" style="background-color: #FFFCF8">
                            <h3 class="text-center">{{$val["title"]}}</h3>
                            <!--<p>{!!substr($val["content"],0,200)!!}</p>-->
                            <p style="min-height: 70px" class="text-justify">{!!substr(strip_tags($val["content"]),0,150)."..."!!}</p>
                            <!--<p><a href="blog/{{$val["slug"]}}" class="btn btn-primary" role="button">Ver Mas</a>--> 
                            <p  class="text-center">Hace 1 minuto</p>
                        </div>
                    </div>
                </div>
                <?php
                $cont++;
                if ($cont == 3) {
                    $cont = 0;
                    ?>
                </div>
                <div class="row">
                    <?php
                }
                ?>
                @endforeach
            </div>
        </div>
    </div>
</div>


@endsection