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
        </style>
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


        <div class="container-fluid">
            <!--<div style=" background-image: url({{ asset('assets/images/fondo1_1260X555.png') }});width:100%">-->
            <div class="row">
                <div style="width:100%;height:800px;background-image:url({{ asset('assets/images/fondo_init.png') }}); background-repeat: no-repeat;background-size: 100% 100%; ">
                    <div class="row">
                        <div class="col-lg-5" style="padding-top:200px;padding-left: 40px;">
                            <div style="width:380px;height:230px;background-image:url({{ asset('assets/images/marketplace.png') }}); background-repeat: no-repeat;background-size: 100% 100%;"></div>
                        </div>
                        <div class="col-lg-2 col-lg-offset-4" >
                            <div class="row" style="padding-bottom: 20px;padding-top: 20px;">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <div style="width:70%;height:100px;background-image:url({{ asset('assets/images/sf_blanco.png') }}); background-repeat: no-repeat;background-size: 100% 100%;"></div>
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
                                                        <input type="email" class="form-control" id="email" placeholder="Compañía">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="email" class="white-label">Nombre</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Nombre">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="email" class="white-label">Email</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="email" class="white-label">Telefono</label>
                                                        <input type="email" class="form-control" id="email" placeholder="Telefono">
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
                                                    <button type="submit" class="btn btn-success">Registrarse</button>
                                                </div>
                                            </div>
                                        </form>


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

        <div class="container-fluid">
            <br>
            <div class="row">
                <div class="col-lg-3 col-lg-offset-5"><h3>Industria de alimentos <u>Saludables</u></h3></div>
            </div>
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
                            <p class="text-center">
                                "88% de las personas estan dispuestas a pagar más por alimentos saludables." Forbes 2017
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <p class="text-center">
                                "Para el 2017, las ventas globales de alimentos saludables llegarán a un trillón de dolares." . Forbes 2017
                            </p>
                        </div>
                        <div class="col-lg-4">
                            <p class="text-center">
                                "7 de cada 10 colombianos desean bajar de peso y ser más saludables." Nielsen 2017
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
                    </div>
                    <br>
                </div>

            </div>
            <br>

        </div>
        <div class="container-fluid" style="background-color:#fffcf8">
            <br>
            <div class="row">
                <div class="col-lg-3 col-lg-offset-5"><h1>Nuestros <u>Productos</u></h1></div>
            </div>

            <div class="row">
                <div class="col-lg-5 col-lg-offset-4"><h4 style="color:#cc">Entregamos todas tus marcas saludables favoritas directamente a tu negocio.</h4></div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class='col-md-12'>
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

                        <!--                        <a data-slide="prev" href="#media" class="left carousel-control">‹</a>
                                                <a data-slide="next" href="#media" class="right carousel-control">›</a>-->
                    </div>
                </div>
            </div>

        </div>
        <br>
        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3"><h3>Productos</h3></div>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/381/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 200</h4>
                            <h4><a href="/productDetail/">Bebidas</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/379/270/food" alt="...">
                        <div class="caption">

                            <h4 class="pull-right">$ 250</h4>
                            <h4><a href="/productDetail/">Snack</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/379/271/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 140</h4>
                            <h4><a href="/productDetail/">Aceites</a></h4>
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
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/380/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 140</h4>
                            <h4><a href="/productDetail/">Rosquillas</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/381/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 160</h4>
                            <h4><a href="/productDetail/">Bebidas</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/380/271/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 180</h4>
                            <h4><a href="/productDetail/">Snack</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/379/271/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 100</h4>
                            <h4><a href="/productDetail/">Aceites</a></h4>
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
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/381/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 140</h4>
                            <h4><a href="/productDetail/">Rosquillas</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/382/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 160</h4>
                            <h4><a href="/productDetail/">Bebidas</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/378/270/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 180</h4>
                            <h4><a href="/productDetail/">Snack</a></h4>
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
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src="http://lorempixel.com/380/272/food" alt="...">
                        <div class="caption">
                            <h4 class="pull-right">$ 100</h4>
                            <h4><a href="/productDetail/">Aceites</a></h4>
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
        </div>
    </body>
</html>
