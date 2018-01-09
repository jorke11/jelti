@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h2 class="text-center">Nuevo articulo</h2>
        </div>
    </div>
    <div class="row">
        {!! Form::open(['route' => 'admin.blog.store','files' => true,'method'=>'POST','id'=>"frm"]) !!}
        <div class="col-lg-8 col-lg-offset-2">
            @include('Blog.admin.form')
            <div class="row" style="padding-bottom: 5%">    
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success form-control input-sm">Nuevo</button>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
</div>

@endsection