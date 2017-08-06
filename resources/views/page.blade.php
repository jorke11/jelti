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
        </style>
        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}

        <!-- Add the slick-theme.css if you want default styling -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick-theme.css"/>



        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        <script>
        </script>
    </head>


    <body>
        <nav class="navbar navbar-default">
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
                        <img alt="Brand" src="{{ asset('assets/images/logo20x31.png') }}" class="title"> SuperFuds
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


        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="http://lorempixel.com/1500/370/food" alt="Image">
                    <div class="carousel-caption">
                        Alimentacion Saludable
                    </div>
                </div>
                <div class="item">
                    <img src="http://lorempixel.com/1500/371/food" alt="...">
                    <div class="carousel-caption">
                        Belleza
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3"><h3>Categorias</h3></div>
            </div>
            <div class="row">
                <div class='col-md-12'>
                    <div class="carousel slide media-carousel" id="media">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/frezedetay.png">
                                            <img src="http://lorempixel.com/270/151/food" alt="">
                                        </a>

                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/150/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/152/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/150/food" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/151/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/150/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/153/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" rel="gallery1" href="img/katalog.png">
                                            <img src="http://lorempixel.com/271/149/food" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" href="#">
                                            <img src="http://lorempixel.com/270/150/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" href="#">
                                            <img src="http://lorempixel.com/273/150/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" href="#">
                                            <img src="http://lorempixel.com/273/150/food" alt="">
                                        </a>
                                    </div>
                                    <div class="col-md-3">
                                        <a class="fancybox thumbnail" href="#">
                                            <img src="http://lorempixel.com/273/150/food" alt="">
                                        </a>
                                    </div>
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
