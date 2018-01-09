<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Superfuds</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/logoico.png') }}">
        <script>var PATH = '{{url("/")}}'</script>
        {!!Html::script('/vendor/template/vendors/jquery/dist/jquery.min.js')!!}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        {!!Html::style('/vendor/template/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
        {!!Html::script('/vendor/toastr/toastr.min.js')!!}
        {!!Html::style('/vendor/toastr/toastr.min.css')!!}

        <script>
            $(document).ready(function ($) {
                var ventana_ancho = $(window).width();
                var ventana_alto = $(window).height();
            });
        </script>
        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        {!!Html::style('/css/page.css')!!}
        {!!Html::script('/vendor/plugins.js')!!}

        {!!Html::script('/vendor/trumbowyg/js/trumbowyg.min.js')!!}
        {!!Html::style('/vendor/trumbowyg/css/trumbowyg.min.css')!!}

        {!!Html::script('/vendor/DataTables-1.10.13/media/js/jquery.dataTables.min.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/ColReorder/js/dataTables.colReorder.min.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/Buttons/js/dataTables.buttons.min.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/jszip.min.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/pdfmake.min.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/vfs_fonts.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/buttons.html5.min.js')!!}

        {!!Html::style('/vendor/select2/css/select2.min.css')!!}
        {!!Html::script('/vendor/select2/js/select2.js')!!}

    </head>


    <body>
        <section>
            <div class="container-fluid" style="padding-bottom: 2%;">
                <div class="row" style="background-color: #68b9a3;position: fixed;right: 0;left: 0;z-index: 1030;padding-left: 2%;">
                    <div class="col-lg-8">
                        <!--<h4 style="color:white">Invita y Gana</h4>-->
                    </div>
                    <div class="col-lg-3">

                        <form autocomplete="on" id="formSearch">
                            <div class="input-group">
                                <span class="input-group-addon" style="background-color: rgba(255,255,255,.0);border: 0">
                                    <i class="glyphicon glyphicon-search" style="color:white" onclick="objPage.search()"></i></span>
                                <input id="search" type="text" class="form-control" name="search" placeholder="Qué producto buscas?" style="background-color: rgba(255,255,255,.4)">
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </section>
        <nav class="navbar navbar-default" style="margin-bottom:0px;padding-top: 4px;min-height: 60px">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
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
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 5%">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if(Auth::user()!=null)
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administración <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="/admin/blog/create">Nueva Entrada</a></li>
                                <li><a href="/admin/blog">Publicaciones</a></li>
                                <li><a href="/admin/blog/category">Categorias</a></li>
                            </ul>
                        </li>
                        @endif
                        <li><a href="/blog" style="color:#00c98a;font-size:17px;font-weight: 100" >Inicio</a></li>

                        @if(Auth::user()==null)
                        <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                        @endif

                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <!--<img src="images/img.jpg" alt="">-->
                                <!--{!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}-->
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
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>


        @yield('content')
    </body>

    {!!Html::script('/js/Blog/blog.js')!!}

</html>
