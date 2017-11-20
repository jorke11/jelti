@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row" style="padding-top: 2%">
        <div class="col-lg-8">

            <div class="row">
                <?php
                $cont = 0;
                ?>
                @foreach($data as $val)
                <div class="col-lg-4">
                    <div class="thumbnail">
                        <img src="{{$val["img"]}}" alt="...">
                        <div class="caption">
                            <h3>{{$val["title"]}}</h3>
                            <p>{{$val["content"]}}</p>
                            <p><a href="blog/{{$val["id"]}}" class="btn btn-primary" role="button">Leer</a> 
                                @if(Auth::user()!=null)
                                <a href="blog/{{$val["id"]}}/edit" class="btn btn-success" role="button">Editar</a> 
                                <a href="blog/{{$val["id"]}}/delete" class="btn btn-danger" role="button">Elimintar</a>
                                @endif
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
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>


@endsection