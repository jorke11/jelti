<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Superfuds</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/logoico.png') }}">
        {!!Html::script('/vendor/template/vendors/jquery/dist/jquery.min.js')!!}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <script>var PATH = '{{url("/")}}'</script>

        <!-- Styles -->
        {!!Html::style('/vendor/template/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
        <style>
            .navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
                margin-left:150px;
                color: #13b671;          
                font-size: 20px;
                font-weight: bold;

            }
            .navbar-brand>img {
                display: inline;
            }
            .navbar-brand {
                padding: 10px 10px;
            }
            .navbar-default {
                background-color: white;
                box-shadow: 0 4px 4px -4px #9B9B9B;
            }
            .h3, h3 {
                color: #13b671;          
            }
            .navbar-form .form-control.search {
                width: 500px;
            }
            .color-superfuds{
                color: #13b671;
            }
            .white-label{
                color:white;
                font-size: 20px;
                text-shadow: 1px 1px 3px #000;
                font-weight:200;
                font-family: "Helvetica", Georgia, Serif;
                letter-spacing: 1px

            }
            .white-check{
                color:white;
                font-size: 12px;
                text-shadow: 1px 1px 3px #000;
                font-weight:200;
                font-family: "Helvetica", Georgia, Serif;
                letter-spacing: 1px

            }

            .green-bk{
                background: rgba(255,255,255,1);
                background: -moz-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
                background: -webkit-gradient(left top, right top, color-stop(0%, rgba(255,255,255,1)), color-stop(0%, rgba(85,185,117,1)), color-stop(100%, rgba(92,230,214,1)));
                background: -webkit-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
                background: -o-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
                background: -ms-linear-gradient(left, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
                background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(85,185,117,1) 0%, rgba(92,230,214,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#5ce6d6', GradientType=1 );
            }
            .grey-bk{
                background: #fffcf8;
            }
            #loading-super{
                display:scroll;
                position:fixed;
                z-index: 10000;
                left: 50%;
                top: 40%
            }
        </style>

        {!!Html::style('/css/client.css')!!}
        {!!Html::style('/css/page.css')!!}

        {!!Html::script('/vendor/toastr/toastr.min.js')!!}
        {!!Html::style('/vendor/toastr/toastr.min.css')!!}

        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    </head>
    <body>
        <div id="loading-super" class="hidden" >
            <img src="{!!asset('images/Gif_final.gif')!!}" width='60%' >
            @if(Auth::user()!=null)
            <input id="role_id" type="hidden" value="{{Auth::user()->role_id}}">
            @endif
        </div>


<!--        <nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom:0px;padding-top: 4px;min-height: 60px;">
            <div class="container-fluid">
                 Brand and toggle get grouped for better mobile display 
                <div class="navbar-header" style='padding-left: 2%'>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <img alt="Brand" src="{{ asset('assets/images/SF50X.png') }}">
                    </a>

                </div>
                 Collect the nav links, forms, and other content for toggling 
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 5%">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">     
                                <span class="glyphicon glyphicon-align-justify" aria-hidden="true" style="font-size: 25px;color:#30c594"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Categorias</a></li>
                                <li><a href="#">SubCategorias</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <div id="wrap">
                                <form action="" autocomplete="on">
                                    <input id="search" name="search" type="text" placeholder="Buscar?"><input id="search_submit" value="Rechercher" type="submit">
                                </form>
                            </div>
                        </li>
                        @if(Auth::user()!=null)


                        <li> <a href="/payment">
                                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" style="font-size: 25px;color:#30c594"></span>
                                <span class="badge">
                                    <span id="quantityOrders"></span>
                                </span></a></li>

                        @endif

                        @if(Auth::user()==null)
                        <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                        @endif

                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="color:#30c594">
                                <img src="images/img.jpg" alt="">
                                {!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}
                                @if(!Auth::guest())
                                {{auth()->user()->name}}
                                @endif
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div> /.navbar-collapse 
            </div> /.container-fluid 
        </nav>-->
        
        @include("header")


        <div class="container-fluid">
            @yield('content')
        </div>
    </body>

</html>