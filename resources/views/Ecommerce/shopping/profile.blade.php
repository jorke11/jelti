@extends('layouts.client')
@section('content')
<style>
    @import url(http://fonts.googleapis.com/css?family=Lato:400,700);
    body
    {
        font-family: 'Lato', 'sans-serif';
    }
    .profile 
    {
        min-height: 355px;
        display: inline-block;
    }
    figcaption.ratings
    {
        margin-top:20px;
    }
    figcaption.ratings a
    {
        color:#f1c40f;
        font-size:11px;
    }
    figcaption.ratings a:hover
    {
        color:#f39c12;
        text-decoration:none;
    }
    .divider 
    {
        border-top:1px solid rgba(0,0,0,0.1);
    }
    .emphasis 
    {
        border-top: 4px solid transparent;
    }
    .emphasis:hover 
    {
        border-top: 4px solid #1abc9c;
    }
    .emphasis h2
    {
        margin-bottom:0;
    }
    span.tags 
    {
        background: #1abc9c;
        border-radius: 2px;
        color: #f5f5f5;
        font-weight: bold;
        padding: 2px 4px;
    }
    .dropdown-menu 
    {
        background-color: #34495e;    
        box-shadow: none;
        -webkit-box-shadow: none;
        width: 250px;
        margin-left: -125px;
        left: 50%;
    }
    .dropdown-menu .divider 
    {
        background:none;    
    }
    .dropdown-menu>li>a
    {
        color:#f5f5f5;
    }
    .dropup .dropdown-menu 
    {
        margin-bottom:10px;
    }
    .dropup .dropdown-menu:before 
    {
        content: "";
        border-top: 10px solid #34495e;
        border-right: 10px solid transparent;
        border-left: 10px solid transparent;
        position: absolute;
        bottom: -10px;
        left: 50%;
        margin-left: -10px;
        z-index: 10;
    }
</style>

<div class="container" style="padding-bottom: 3%;padding-top: 3%">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            <div class="well profile">
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-8">
                        <h2>{{$client->business}}</h2>
                        <p><strong>Email: </strong> {{$client->email}} </p>
                        <p><strong>Direccion Facturacion: </strong> {{$client->address_invoice}}</p>
<!--                        <p><strong>Skills: </strong>
                            <span class="tags">html5</span> 
                            <span class="tags">css3</span>
                            <span class="tags">jquery</span>
                            <span class="tags">bootstrap3</span>
                        </p>-->
                    </div>             
                    <div class="col-xs-12 col-sm-4 text-center">
                        <figure>
                            <img src="http://www.localcrimenews.com/wp-content/uploads/2013/07/default-user-icon-profile.png" alt="" class="img-circle img-responsive">
                            <figcaption class="ratings">
                                <p>Ratings
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star"></span>
                                    </a>
                                    <a href="#">
                                        <span class="fa fa-star-o"></span>
                                    </a> 
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                </div>            
                <div class="col-xs-12 divider text-center">
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong> {{$orders->quantity}} </strong></h2>                    
                        <p><small>Ordenes</small></p>
                        <button class="btn btn-success btn-block"><span class="fa fa-plus-circle"></span> Ver </button>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong>${{number_format($orders->total,0,",",".")}}</strong></h2>                    
                        <p><small>Total Ordenes</small></p>
                        <button class="btn btn-info btn-block"><span class="fa fa-user"></span> Ver</button>
                    </div>
                    <div class="col-xs-12 col-sm-4 emphasis">
                        <h2><strong>43</strong></h2>                    
                        <p><small>Snippets</small></p>
                        <div class="btn-group dropup btn-block">
                            <button type="button" class="btn btn-primary"><span class="fa fa-gear"></span> Options </button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu text-left" role="menu">
                                <li><a href="#"><span class="fa fa-envelope pull-right"></span> Send an email </a></li>
                                <li><a href="#"><span class="fa fa-list pull-right"></span> Add or remove from a list  </a></li>
                                <li class="divider"></li>
                                <li><a href="#"><span class="fa fa-warning pull-right"></span>Report this user for spam</a></li>
                                <li class="divider"></li>
                                <li><a href="#" class="btn disabled" role="button"> Unfollow </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>                 
        </div>
    </div>
</div>

@include("footer")

{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection