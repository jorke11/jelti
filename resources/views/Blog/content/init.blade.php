@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row" style="padding-top: 2%">
        <div class="col-lg-10 col-lg-offset-1">

            <div class="row">
                <?php
                $cont = 0;
                ?>
                @foreach($data as $val)
                <div class="col-lg-4">
                    <div class="thumbnail">
                        <img src="{{$val["thumbnail"]}}" alt="...">
                        <div class="caption">
                            <h3>{{$val["title"]}}</h3>
                            <p>{!!$val["content"]!!}</p>
                            <p><a href="blog/{{$val["slug"]}}" class="btn btn-primary" role="button">Ver Mas</a> 
                            </p>
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