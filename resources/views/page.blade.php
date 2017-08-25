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

            #img-main{
                background: #13b671 url('assets/images/fondo_init.png') center center no-repeat;
                background-size: cover;
                color:white;
                /*height:100%;*/
                height:600px;
                /*text-align: center;*/
                display: flex;
                /*align-items: center;*/
            }

            @media screen and (min-width:1340px) {
                #img-main{
                    background: #13b671 url('assets/images/fondo_init.png') center center no-repeat;
                    background-size: cover;
                    color:white;
                    /*height:600px;*/
                    height:850px;
                    display: flex;
                }
            }

            #img-marketplace{
                background: url('assets/images/marketplace.png') center center no-repeat;
                background-size: auto;
                color:white;
                height:200px;
                display: flex;
                margin-top: 180px;
            }
            #img-superfuds{
                background: url('assets/images/sf_blanco.png') center center no-repeat;
                background-size: 155px;

                color:white;
                height:100px;
                display: flex;
            }

        </style>
        <script>
            $(document).ready(function ($) {
                var ventana_ancho = $(window).width();
                var ventana_alto = $(window).height();
                console.log(ventana_ancho);
                console.log(ventana_alto);
            });
        </script>
        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        <script>
        </script>
    </head>


    <body>
        <nav class="navbar navbar-default" style="margin-bottom:0px">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" src="{{ asset('assets/images/SF50X.png') }}" class="title"> SuperFuds
                    </a>

                </div>
                <form class="navbar-form navbar-left">
                    <div class="form-group">
                        <input type="text" class="form-control search" placeholder="">
                    </div>
                    <button type="submit" class="btn btn-success input-sm">Buscar</button>
                </form>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-shopping-cart color-superfuds" aria-hidden="true"></span></a></li>
                        <li><a href="/login">Iniciar Sesión</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <style>


        </style>
        <section>
            <div class="container-fluid">
                <!--<div style=" background-image: url({{ asset('assets/images/fondo1_1260X555.png') }});width:100%">-->
                <div class="row">
                    <div id="img-main">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-5">
                                    <!--<div style="width:380px;height:230px;background-image:url({{ asset('assets/images/marketplace.png') }}); background-repeat: no-repeat;background-size: 100% 100%;"></div>-->
                                    <div id="img-marketplace"></div>
                                </div>
                                <div class="col-lg-3 col-lg-offset-3">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <!--<div style="width:70%;height:100px;background-image:url({{ asset('assets/images/sf_blanco.png') }}); background-repeat: no-repeat;background-size: 100% 100%;"></div>-->
                                            <div id="img-superfuds"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="panel" style="background: rgba(255, 255, 255, 0.6);border: 1px solid #fff">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="text-center white-label">Registrate como <br>
                                                            Negocio o Cliente</p>
                                                    </div>
                                                </div>
                                                <form>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="email" class="white-label">Compañía</label>
                                                                <input type="email" class="form-control input-sm" id="email" placeholder="Compañía">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="email" class="white-label">Nombre</label>
                                                                <input type="email" class="form-control input-sm" id="email" placeholder="Nombre">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="email" class="white-label">Email</label>
                                                                <input type="email" class="form-control input-sm" id="email" placeholder="Email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="email" class="white-label">Telefono</label>
                                                                <input type="email" class="form-control input-sm" id="email" placeholder="Telefono">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="checkbox">
                                                                <label class="white-check"><input type="checkbox" > Acepto terminos de servicio | Leer más</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-lg-offset-4">
                                                            <button type="submit" class="btn btn-success btn-sm">Registrarse</button>
                                                        </div>
                                                    </div>
                                                </form>


                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<img id="estirada" style="top: 0; left: 0; width: 100%; height: 90%" src="{{ asset('assets/images/fondo1_1260X555.png') }}" />-->
                      <!--<img src="{{ asset('assets/images/fondo1_1280X683.png') }}">-->
                </div>
            </div>
        </section>
        <br>
        <br>
        <br>
        <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-lg-12"><h1 class="text-center" style="color:#13b671">Industria de alimentos <u>Saludables</u></h1></div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
            <br>
            <div class="row">
                <div class="col-lg-9 col-lg-offset-1">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="{{ asset('assets/images/group8.png') }}" class="img-responsive center-block"/>
                        </div>
                        <div class="col-lg-4">
                            <img src="{{ asset('assets/images/group9.png') }}" class="img-responsive center-block"/>
                        </div>
                        <div class="col-lg-4">
                            <img src="{{ asset('assets/images/group11.png') }}" class="img-responsive center-block"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h4 class="text-center">
                                "88% de las personas estan dispuestas a pagar más por alimentos saludables." Forbes 2017
                            </h4>
                        </div>
                        <div class="col-lg-4">
                            <h4 class="text-center">"Para el 2017, las ventas globales de alimentos saludables llegarán a un trillón de dolares." . Forbes 2017</h4>
                        </div>
                        <div class="col-lg-4">
                            <h4 class="text-center">
                                "7 de cada 10 colombianos desean bajar de peso y ser más saludables." Nielsen 2017
                            </h4>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
                    </div>
                    <br>
                </div>

            </div>
            <br>
            <br>

        </div>
        <div class="container-fluid" style="background-color:#fffcf8">
            <br>
            <div class="row">
                <div class="col-lg-12"><h1 class="text-center">Nuestros <u>Productos</u></h1></div>
            </div>

            <div class="row">
                <div class="col-lg-12"><h4 class="text-center" style="color:#cc">Entregamos todas tus marcas saludables favoritas directamente a tu negocio.</h4></div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class='col-md-10 col-lg-offset-1'>
                    <div class="carousel slide media-carousel" id="media">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <?php
                                    $cont = 0;
                                    foreach ($category as $i => $val) {
                                        ?>
                                        <div class="col-md-2">
                                            <a class="fancybox thumbnail" rel="gallery1" href="img/frezedetay.png">
                                                <img src="{{$val->image}}" alt="">
                                            </a>
                                        </div>
                                        <?php
                                        $cont++;
                                        if ($cont == 4) {
                                            $cont = 0;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <a class="left carousel-control" href="#media" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#media" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-3 col-lg-offset-2"><h4>Lo Nuevo</h4></div>
                <div class="col-lg-3 col-lg-offset-4"><h4>Ver Todo</h4></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="carousel slide media-carousel" id="newproducts">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <?php
                                    $cont = 0;
                                    foreach ($category as $i => $val) {
                                        ?>
                                        <div class="col-md-2">
                                            <a class="fancybox thumbnail" rel="gallery1" href="img/frezedetay.png">
                                                <img src="{{$val->image}}" alt="">
                                            </a>
                                        </div>
                                        <?php
                                        $cont++;
                                        if ($cont == 4) {
                                            $cont = 0;
                                            ?>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="row">
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>


                        <a class="left carousel-control" href="#newproducts" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#newproducts" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
                        <a data-slide="next" href="#media" class="right carousel-control">›</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-lg-offset-2"><h4>Sub-categorias</h4></div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    @foreach($subcategory as $val)
                    <div class="col-lg-2">
                        <div class="row"><div class="col-lg-12"><p class="text-center">{{ucwords($val->description)}}</p></div></div>
                        <div class="row"><div class="col-lg-12"><img src="{{$val->img}}" alt="" class="img-responsive center-block" ></div></div>
                    </div>
                    @endforeach
                </div>
            </div>
            <br>
            <br>
            <br>

            <div class="row green-bk">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12"><h2 class="text-center" style="color:white"><u>Negocios</u></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><p class="text-center" style="color:white">Concéntrate en tu producto, nosotros nos encargamos del negocio.</p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                </ol>


                                <div class="carousel-inner">
                                    <div class="item active">

                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <br>
                                                <br>
                                                <br>
                                                <h3>
                                                    <h2 class="text-center" style="color:#ffffff">
                                                        1 Factura para 300+ Productos Saludables de 40+ Marcas.</h2>
                                                </h3>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                        </div> 
                                    </div>
                                </div>


                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>

                                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>                        
        <br>
        <br>
        <br>


        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12"><h4 class="text-center"><u>Lo que Dicen nuestros clientes</u></h4></div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/click_clack.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Sergio Saavedra<br>
                                Director General | Hotel Click Clack</b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Por medio de SuperFüds hemos accedido a un amplio portafolio de productos locales, altamente saludables con presentación impecable que los clientes de Click Clack han sabido disfrutar.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/farmatado.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Teodoro Zubillaga<br>
                                Country Manager | Farmatodo
                            </b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            A través de SuperFüds ahora podemos brindar las mejores opciones para una alimentación saludable, con ellos ampliamos nuestra oferta para el cuidado integral de la salud y de esta forma estamos satisfaciendo las necesidades y gustos de nuestros clientes.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/rappi.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Simon Borrero<br>
                                CEO | Rappi</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Hicimos esta alianza con SuperFüds por que lideran en Colombia el mercado de alimentos saludables y confiamos en su selección de proveedores para ofrecerle a nuestros clientes los mejores productos del mercado.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <div class="container-fluid">
            <div class="row green-bk">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12"><h2 class="text-center" style="color:white"><u>Proveedores</u></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><p class="text-center" style="color:white">Entregamos todas tus marcas favoritas directamente a tu negocio.</p></div>
                    </div>
                    <div class="row">
                        <div id="myCarousel2" class="carousel slide" data-ride="carousel">

                            <ol class="carousel-indicators">
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                            </ol>


                            <div class="carousel-inner">
                                <div class="item active">

                                    <div class="header-text hidden-xs">
                                        <div class="col-md-12 col-center">
                                            <br>
                                            <br>
                                            <br>

                                            <h3>
                                                <h2 class="text-center" style="color:#ffffff">
                                                    ¡Tus ventas se dispararán! Distribuimos a más de 400 puntos en 16 ciudades.
                                            </h3>


                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        </div>
                                    </div><!-- /header-text -->
                                </div>
                            </div>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>

                            <!-- Left and right controls -->
                            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <br>
        <br>


        <div class="container-fluid ">
            <div class="row">
                <div class="col-lg-12"><h4 class="text-center"><u>Lo que Dicen nuestros clientes</u></h4></div>
            </div>
            <br>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/terra_fertil.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Raul Bermeo<br>
                                Director General | Terrafertil</b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Trabajar con SuperFüds es una oportunidad de ingresar a mercados diferentes que van a la vanguardia de nuestra marca, tienen la energía y la actitud para sacar proyectos nuevos.
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="{{ asset('assets/images/SF50X.png') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/chocolov.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Adriana Hoyos<br>
                                Gerente General | Chocolov</b>s
                            </b>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            A través de SuperFüds hemos expandido nuestro negocio, llegando a muchos más clientes en diferentes ciudades de Colombia y logrando masificar nuestros productos. Son un aliado que además de ser los únicos especializados en su categoría, tienen una amplia visión sobre el B2B y B2C ya que están en la constante búsqueda e implementación de herramientas para generar nuevos negocios.
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="{{ asset('assets/images/SF50X.png') }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/rappi.png"></div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center" style="color:#56be7f">
                            <b>Javier Pinilla<br>
                                Director Comercial | Segalco</b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            Trabajar con SuperFüds ha sido una experiencia interesante, hemos podido aperturar unos mercados de nicho que nos interesaba y hemos llegado a puntos donde no habíamos podido llegar. Su drive haciendo distribución punto a punto con varios productos hace que el negocio sea rentable para todos los jugadores.
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="{{ asset('assets/images/SF50X.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div class="container-fluid grey-bk">
            <div class="row">
                <div class="col-lg-4">
                    <img src="/images/movil.png">
                </div>
                <div class="col-lg-8">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-center">DELICIOSAMENTE SALUDABLE</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="text-center">Descarga Superfuds para  que puedas  llevar  la vida saludable a todas partes</h4>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="/images/appstore.png" >
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="/images/googleplay.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="container-fluid green-bk">
            <div class="row">
                <div class="col-lg-5">
                    <h3 style="color:white">
                        Boletín. <br>
                        ºRegístrate y recibe tips, recetas 
                        y mucho más!
                    </h3>
                </div>
                <div class="col-lg-7">
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <input class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-default">Suscribete</button>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-4">
                    <div class="row">
                        <div class="col-lg-3 ">
                            <img src="/images/facebook.png">
                        </div>
                        <div class="col-lg-3">
                            <img src="/images/instagram.png">
                        </div>
                        <div class="col-lg-3">
                            <img src="/images/twitter.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div style="width:100%;height:270px;background-image:url({{ asset('images/nosotros_back.png') }}); background-repeat: no-repeat;background-size: 100% 100%; ">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 style="color:white">Nosotros</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 style="color:white">
                                    Somos el marketplace de alimentos saludables más grande del país. Entregamos a clientes sus marcas saludables favoritas y nos encargamos de los negocios para que proveedores puedan concentrarse en su producto.</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Aliados</h3>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="/images/endeavor.png">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="/images/innpulsa.png">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <img src="/images/emprende.png">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div style="width:100%;height:270px;background-image:url({{ asset('images/nosotros_back.png') }}); background-repeat: no-repeat;background-size: 100% 100%; ">
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="row">
                            <div class="col-lg-12  text-center">
                                <h1 style="color:white">Noticias Recientes</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="fancybox">SuperFüds 2017. Todos los Derechos Reservados.</p>
                </div>
            </div>
        </div>

        <!--        <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3"><h3>Proveedores</h3></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <img src="http://lorempixel.com/380/270/food" alt="...">
                                <div class="caption">
        
                                    <h4 class="pull-right">$ 100</h4>
                                    <h4><a href="/productDetail/">Alimenmto</a></h4>
                                    <p>
                                        Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500
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
                </div>-->


    </body>
    <script>
        $(document).ready(function ($) {
            var ventana_ancho = $(window).width();
            var ventana_alto = $(window).height();
            console.log(ventana_ancho);
            console.log(ventana_alto);
        });
    </script>

</html>
