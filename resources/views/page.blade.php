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
        <meta name="keywords" content="organico,saludable">
        <meta name="description" content="Somos una empresa colombiana de alimentos saludables que cuidamos el planeta.">
        <!-- Styles -->
        {!!Html::style('/vendor/template/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
        {!!Html::script('/vendor/toastr/toastr.min.js')!!}
        {!!Html::style('/vendor/toastr/toastr.min.css')!!}


        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        {!!Html::style('/css/page.css')!!}
        {!!Html::script('/vendor/plugins.js')!!}
        <style>

            #buttonMain{
                position: absolute;
                top:70%;
                left:55%;
                display: inline-block;
                outline: none;
                background-color: rgba(255,255,255,.3);
                border-color: #ffffff
            }

            /*@media screen all*/ 
            #headervideo{
                width: 100%;
                min-width: 180px;
                margin: 0 auto;
            }

            .title{
                font-weight: 900
            }

            .texto{
                font-weight: 900
            }

            @media (max-width: 700px) {
                #container-video{
                    padding-top: 15%;

                }
                #buttonMain{
                    top:63%;
                    left: 50%;
                    font-size: 12px;
                }

                .title{
                    font-size: 18px;
                }
                .texto{
                    font-size: 12px;
                }
                .color-font{
                    font-size: 10px;
                    font-weight: normal
                }


            }



        </style>
    </head>


    <body>
        <div class="container-fluid" id="container-video">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 " style="padding: 0;">
                    <header id="headervideo" style="padding-top: 3%"> 
                        <video autoplay="autoplay" loop="loop" id="video_background" preload="auto" volume="50" style="width:100%">
                     <!--<source src="images/fondo.mpeg" type="video/mpeg" />-->
                            <source src="images/fondo.mp4" type="video/mp4" />
                        </video>
                        <button type="button" class="btn btn-primary btn-lg" id="buttonMain" style="" data-toggle="modal" data-target="#myModal">
                            Registrate como<br>
                            <!--<span style="font-weight: 900;font-size: 30px">Cliente o Proveedor</span>-->
                        </button>
                    </header>
                </div>
            </div>
        </div>

        <!-- Button trigger modal -->

        <style>
            .modal-content {
                background-color: rgba(255,255,255,.6)
            }
        </style>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="background-color: rgba(74,74,74,.7) !important;padding-top: 7%;">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="background-color: rgba(255,255,255,.3) !important;border: 3px solid #ffffff;border-radius: 20px;">

                    <div class="modal-body">
                        <div class="container-fluid">
                            {!! Form::open(['id'=>'frm']) !!}
                            <div class="row">
                                <div class="col-lg-10 col-lg-offset-1">
                                    <div class="row row-space">
                                        <div class="col-lg-10 col-lg-offset-1">
                                            <p style="color:white;font-size:25px; text-shadow: 2px 1px 5px #575757;font-weight: 100" class="text-center">Registrate como <br><span style="font-weight: 900">Cliente o Negocio</span></p>
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-10 col-lg-offset-1">
                                            <div  class="box-client" onclick="objPage.stakeholder(1, this)">Cliente</div>
                                            <div class="box-supplier" onclick="objPage.stakeholder(2, this)">Proveedor</div>
                                            <input type="hidden" id="type_stakeholder" name="type_stakeholder" class="in-page">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12 ">
                                            <input class="form-control in-page" placeholder="Compañia" type="text" id="business" name="business">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12">
                                            <input class="form-control in-page" placeholder="Nombre" type="text" name="name" id="name">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12">
                                            <input class="form-control in-page" placeholder="Apellido" type="text" name="last_name" id="last_name">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12">
                                            <input class="form-control in-page" placeholder="Email" type="email" name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12">
                                            <input class="form-control in-page" placeholder="Telefono" type="text" name="phone" id="phone">
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-12">
                                            <input type="checkbox" name="agree" id="agree" class="in-page"><span style="color:white"> Acepto términos de servicio | Leer mas</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-3 col-sm-6 col-sm-offset-3">
                                            <button type="button" class="btn buttons-page text-center" id="register" style="color:white">Registrate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {!!Form::close()!!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom:0px;padding-top: 4px;min-height: 60px">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style='padding-left: 2%'>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img alt="Brand" src="{{ asset('assets/images/SF50X.png') }}">
                </a>

            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 5%">
                <ul class="nav navbar-nav">
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/" style="color:#00c98a;font-size:17px;font-weight: 100" ><span class="underline-green" id="menuInicio">Inicio</span></a></li>
                    <li><a href="#divProduct" style="color:#00c98a;font-size:17px;font-weight: 100" id="menuProduct" ><span class="">Productos</span></a></li>
                    <li><a href="/blog" style="color:#00c98a;font-size:17px;font-weight: 100">Blog</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-shopping-cart color-superfuds" aria-hidden="true"></span></a></li>
                    <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <section>
        <div class="container-fluid">

            <div class="row" style="padding-bottom:5%;padding-top: 2%">
                <div class="col-lg-10 col-lg-offset-1 col-sm-12 col-xs-12"><h1 class="text-center title-color title" >Industria de alimentos <span class="underline">saludables</span></h1></div>
            </div>

            <div class="row" style="padding-bottom:3%;">
                <div class="col-lg-10 col-lg-offset-1 col-xs-10 col-xs-offset-1">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="min-height: 100px">
                                    <img src="{{ asset('assets/images/group8.png') }}" class="img-responsive center-block"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h4 class="text-center color-font texto" >
                                        "88% de las personas estan dispuestas a pagar más por alimentos saludables." <br><b>Forbes 2017</b>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8" style="min-height: 100px">
                                    <img src="{{ asset('assets/images/group9.png') }}" class="img-responsive center-block"/>
                                </div>  
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h4 class="text-center color-font texto">"Para el 2017, las ventas globales de alimentos saludables llegarán a un trillón de dolares." . <br><b>Forbes 2017</b></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-8 col-xs-8" style="min-height: 100px">
                                    <img src="{{ asset('assets/images/group11.png') }}" class="img-responsive center-block"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <h4 class="text-center color-font texto">"7 de cada 10 colombianos desean bajar de peso y ser más saludables." <br><b>Nielsen 2017</b></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>
        </div>
    </section>


    <section id="divProduct" style="padding-top:4%">
        <div class="container-fluid" style="background-color:#fffcf8">

            <div class="row">
                <div class="col-lg-12"><h1 class="text-center title-color title" >Nuestros <span class="underline">productos</span></h1></div>
            </div>

            <div class="row row-space">
                <div class="col-lg-12"><h4 class="text-center font-color title" >Entregamos todas tus marcas saludables favoritas directamente a tu negocio.</h4></div>
            </div>
            <div class="row">
                <div class='col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1'>
                    <div class="carousel slide media-carousel" id="media">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <?php
                                    $cont = 0;
                                    foreach ($category as $i => $val) {
                                        if ($val->image != '') {
                                            ?>
                                            <div class="col-md-2 col-sm-2 col-xs-2" style="padding:0px">
                                                <a class="fancybox thumbnail" style="padding:0px;border:0px;" rel="gallery1" href="shopping/{{$val->id}}">
                                                    <img src="{{$val->image}}" alt="">
                                                </a>
                                            </div>
                                            <?php
                                            $cont++;
                                            if ($cont == 6) {
                                                $cont = 0;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <div class="row">
                                                <?php
                                            }
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
                <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-5 "><h3 class="color-font title">Lo Nuevo</h3></div>
                <div class="col-lg-3 col-lg-offset-4 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-5 col-xs-offset-2"><h3 class="text-muted color-font title">Ver Todo</h3></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                    <div class="carousel slide media-carousel" id="newproducts">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <?php
                                    $cont = 0;
                                    foreach ($newproducts as $i => $val) {
                                        ?>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <a class="fancybox thumbnail" style="padding:0px;border:0px;background-color: rgba(0,0,0,0)" rel="gallery1" href="productDetail/{{$val->id}}">
                                                <img src="{{$val->image}}" alt="">
                                            </a>
                                        </div>
                                        <?php
                                        $cont++;
                                        if ($cont == 6) {
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

                    </div>
                </div>
            </div>
        </div>
    </section>


    <section style="padding-top: 3%;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-1"><h3 class="color-font">Sub-Categorias</h3></div>
            </div>

            <div class="row">
                <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>

            <div class="row row-space">
                <div class="col-lg-8 col-lg-offset-2 ">
                    <div class="carousel slide media-carousel" id="subcategories">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row" style="padding-top: 2%;padding-bottom: 2%;padding-left: 3%">
                                    <?php
                                    $cont = 0;
                                    foreach ($subcategory as $i => $val) {
                                        ?>
                                        <div class="col-md-1 col-sm-2 col-xs-2" style="width: 14%;">
                                            <h4 class="text-center texto" style="color:#7b7b7b;height: 35px">{{$val->description}}</h4>
                                            <a class="fancybox thumbnail img-subcategory" style="padding:0px;border:0px;background-color: rgba(0,0,0,0)" rel="gallery1" 
                                               href="shopping/_{{$val->id}}">
                                                <img src="{{$val->img}}" alt="">
                                            </a>
                                        </div>
                                        <?php
                                        $cont++;
                                        if ($cont == 7) {
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
                        <a class="left carousel-control" href="#subcategories" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#subcategories" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>


            <div class="row green-bk">
                <div class="col-lg-12">
                    <div class="row row-space">
                        <div class="col-lg-12"><h2 class="text-center" style="color:white"><span class="underline-white title">Negocios</span></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><p class="text-center" style="color:white;font-size: 20px;font-weight: 100">Concéntrate en tu producto, nosotros nos encargamos del negocio.</p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="12"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">1 Factura para 300+ <br>Productos Saludables de <br>40+ Marcas.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="item">
                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">Encontrar todos los productos<br>que te gustan <br>en un solo lugar.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="item">
                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">Nos aseguramos de tener <br>los mejores precios para que <br>puedas ahorrar tiempo y dinero.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
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
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>  
    </section>

    <section>
        <div class="container-fluid" style="padding-top: 1%">
            <div class="row row-space" style="padding-bottom: 2%">
                <div class="col-lg-12"><h2 class="text-center color-font title">Lo que dic<span class="underline">en nuestro</span>s clientes</h2></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row row-space">
                        <div class="col-lg-12 text-center col-md-12 col-sm-12 col-xs-12"><img src="/images/click_clack.png" class="img-responsive center-block"></div>
                    </div>

                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Sergio Saavedra<br>
                                    Director General | Hotel Click Clack</b>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                            <p class="text-center color-font texto">
                                Por medio de SuperFüds hemos accedido a un amplio portafolio de productos locales, altamente saludables con presentación impecable que los clientes de Click Clack han sabido disfrutar.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row  row-space">
                        <div class="col-lg-12 "><img src="/images/farmatado.png" class="img-responsive center-block"></div>
                    </div>

                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2 col-sm-8 col-sm-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Teodoro Zubillaga<br>
                                    Country Manager | Farmatodo
                                </b>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-sm-8 col-sm-offset-2">
                            <p class="text-center color-font texto">
                                A través de SuperFüds ahora podemos brindar las mejores opciones para una alimentación saludable, con ellos ampliamos nuestra oferta para el cuidado integral de la salud y de esta forma estamos satisfaciendo las necesidades y gustos de nuestros clientes.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/rappi.png" class="img-responsive center-block"></div>
                    </div>
                    <br>
                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Simon Borrero<br>
                                    CEO | Rappi</b>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2 col-sm-8 col-sm-offset-2">
                            <p class="text-center color-font">
                                Hicimos esta alianza con SuperFüds por que lideran en Colombia el mercado de alimentos saludables y confiamos en su selección de proveedores para ofrecerle a nuestros clientes los mejores productos del mercado.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row row-space">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden-xs">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden-xs">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 hidden-xs">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container-fluid">
            <div class="row green-bk">
                <div class="col-lg-12">
                    <div class="row row-space">
                        <div class="col-lg-12"><h2 class="text-center title" style="color:white"><span class="underline-white">Proveedores</span></h2></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><p class="text-center" style="color:white;font-size: 20px;font-weight: 100;font-size: 20px">Entregamos todas tus marcas favoritas directamente en tu negocio.</p></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="myCarouselpro" class="carousel slide" data-ride="carousel">

                                <ol class="carousel-indicators">
                                    <li data-target="#myCarouselpro" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarouselpro" data-slide-to="1"></li>
                                    <li data-target="#myCarouselpro" data-slide-to="2"></li>
                                </ol>

                                <div class="carousel-inner">
                                    <div class="item active">

                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">¡Tus ventas se dispararan!<br>Distribuimos a más de 400 puntos<br>en 16 ciudades.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="item">

                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">¡Unidos  hacemos la diferencia!<br> mas de 40 Provedores<br>trabajando por la alimentación saludable.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="item">

                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">¡Tus ventas se disparan!<br> Nosotros distribuimos en 16 ciudades<br> en mas de 400 locaciones.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="item">
                                        <div class="header-text hidden-xs">
                                            <div class="col-md-12 col-center">
                                                <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">Deja de precuparte<br> tenemos un equipo ideal quienes te ayudaran<br> en mas de 400 locaciones.</h2>
                                                <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                            </div>
                                        </div> 
                                    </div>
                                </div>

                                <a class="left carousel-control" href="#myCarouselpro" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" style="left:-1"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarouselpro" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container-fluid" style="padding-top: 1%">
            <div class="row row-space" style="padding-bottom: 2%">
                <div class="col-lg-12"><h2 class="text-center color-font title">Lo que dic<span class="underline">en nuestros pr</span>oveedores ...</h2></div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row row-space">
                        <div class="col-lg-12 text-center"><img src="/images/terra_fertil.png" class="img-responsive center-block"></div>
                    </div>

                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Raul Bermeo<br>
                                    Director General | Terrafertil</b>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <p class="text-center color-font">
                                “Trabajar con SuperFüds es una oportunidad de ingresar a mercados diferentes que van a la vanguardia de nuestra marca, tienen la energía y la actitud para sacar proyectos nuevos".
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row  row-space">
                        <div class="col-lg-12 text-center"><img src="/images/chocolov.png" class="center-block"></div>
                    </div>

                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Adriana Hoyos<br>
                                    Gerente General | Chocolov
                                </b>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <p class="text-center color-font">

                                "A través de SuperFüds hemos expandido nuestro negocio, llegando a muchos más clientes en diferentes ciudades de Colombia y logrando masificar nuestros productos. Son un aliado que además de ser los únicos especializados en su categoría, tienen una amplia visión sobre el B2B y B2C ya que están en la constante búsqueda e implementación de herramientas para generar nuevos negocios".
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="row">
                        <div class="col-lg-12 text-center"><img src="/images/segalco.png" class="center-block"></div>
                    </div>
                    <br>
                    <div class="row row-space">
                        <div class="col-lg-8 col-lg-offset-2" style="color:#56be7f">
                            <p class="text-center"><b>Javier Pinilla<br>
                                    Director Comercial | Segalco</b>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <p class="text-center color-font">

                                "Trabajar con SuperFüds ha sido una experiencia interesante, hemos podido aperturar unos mercados de nicho que nos interesaba y hemos llegado a puntos donde no habíamos podido llegar. Su drive haciendo distribución punto a punto con varios productos hace que el negocio sea rentable para todos los jugadores".
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row row-space hidden-xs">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <p class="text-center color-font">
                        <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid grey-bk" style="background-color:#fffcf8">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5">
                    <p class="text-center col-lg-offset-5"><img src="/images/movil.png"></p>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7" style="padding-top: 5%">
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="text-center" style="color:#4a4a4a">DELICIOSAMENTE SALUDABLE</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4 class="text-center" style="color:#4a4a4a">Descarga Superfuds para  que puedas  llevar  la vida saludable a todas partes</h4>
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
    </section>

    <div class="container-fluid green-bk">
        <div class="row row-space" style="padding-top: 1%">
            <div class="col-lg-5 col-md-5 col-sm-6">
                <h2 class="col-lg-offset-2"  style="color:white">
                    Regístrate y recibe tips, recetas <br>
                    y mucho más!
                </h2>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6">
                <br>
                <div class="row">
                    <div class="col-lg-10">
                        <input class="form-control input-lg" placeholder="Email">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-default" style="color:green">Suscribete</button>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>

    <div class="container-fluid" style="background-color: rgba(0,0,0,.8)">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 hidden-xs" >
                <div class="row" style="padding-top: 10%;padding-bottom: 3%">
                    <div class="col-lg-12">
                        <h3 style="color:white" class="col-lg-offset-1">Nosotros</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <h4 style="color:white;font-weight: 100;line-height:1.5" class="col-lg-offset-1 text-justify">
                            Somos el marketplace de alimentos saludables más grande del país. Entregamos a clientes sus marcas saludables favoritas y nos encargamos de los negocios para que proveedores puedan concentrarse en su producto.</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-6">
                <div class="row" style="padding-top: 20%;padding-bottom: 3%">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-lg-offset-3 col-xs-4">
                        <p class="text-center"><img src="/images/facebook.png" class="img-responsive"></p>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <img src="/images/instagram.png" class="img-responsive">
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-4">
                        <img src="/images/twitter.png" class="img-responsive">
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-4 col-lg-offset-1 col-xs-4" style="padding-top: 2%;padding-bottom: 3%">
                <img src="/images/aliados.png" class="img-responsive">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <hr>   
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-4" >

                <div class="row">
                    <div class="col-lg-12">
                        <span style="color:white;" class="col-lg-offset-1">Superfüds 2018. Todos los derechos reservados</span>   
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script>
    $('#menuProduct').click(function () {
        $("#menuProduct span").addClass("underline-green");
        $("#menuInicio").removeClass("underline-green");
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                && location.hostname == this.hostname) {

            var $target = $(this.hash);

            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');

            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({scrollTop: targetOffset}, 1000);
                return false;
            }
        }

    });

</script>
{!!Html::script('js/Page/page.js')!!}

</html>
