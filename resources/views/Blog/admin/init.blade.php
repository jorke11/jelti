@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row" >
        <div class="col-lg-12">
            <table class="table table-condensed table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Autor</th>
                        <th>Contenido</th>
                        <th>Etiqueta</th>
                        <th>Url</th>
                        <th class="foo">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $val)
                    <tr>
                        <td>{{$val->title}}</td>
                        <td>{{$val->user_id}}</td>
                        <td>{!! $val->content !!}</td>
                        <td>{{$val->tags}}</td>
                        <td>{{$val->slug}}</td>
                        <td>
                            <a href="blog/{{$val->id}}/edit" class="btn btn-warning">Editar</a>
                            <a href="blog/{{$val->id}}/delete" class="btn btn-danger">Borrar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection