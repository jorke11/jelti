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
            body{
                font-family: "helvetica";
            }

            /*            .navbar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
                            margin-left:150px;
                            color: #13b671;          
                            font-size: 20px;
                            font-weight: bold;
            
                        }*/
            .navbar-brand>img {
                display: inline;
            }
            .navbar-brand {
                padding: 10px 10px;
            }
            /*            .navbar-default {
                            background-color: white;
                            box-shadow: 0 4px 4px -4px #9B9B9B;
                        }*/

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
            /*            .grey-bk{
                            background: #fffcf8;
                        }*/

            #img-main{

                background: #13b671 url('assets/images/foto-paginaweb.png')  no-repeat;
                background-image: 100%;
                background-size: cover;
                color:white;
                /*height:60%;*/
                height:800px;
            }

            @media screen and (min-width:1340px) {
                #img-main{
                    background: #13b671 url('assets/images/foto-paginaweb.png')  no-repeat;
                    background-image: 100%;
                    background-size: cover;
                    color:white;
                    /*height:60%;*/
                    height:850px;
                    /*                    display: flex;*/
                }
            }

            .buttons-page{
                border-bottom-left-radius: 1em 1em 1em 1em;
                border: 0;  
                background: rgba(241,111,92,1);
                background: -moz-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(231,56,39,1)), color-stop(0%, rgba(52,205,159,1)), color-stop(49%, rgba(142,222,174,1)), color-stop(100%, rgba(142,222,174,1)));
                background: -webkit-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                background: -o-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                background: -ms-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);

                font-weight: 100;
                font-size:16px;
            }


            @media (max-width: 1300px) {
                .buttons-page {
                    border-bottom-left-radius: 1em 1em 1em 1em;
                    border: 0;  
                    background: rgba(0,0,0,1);
                    background: -moz-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                    background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(231,56,39,1)), color-stop(0%, rgba(52,205,159,1)), color-stop(49%, rgba(142,222,174,1)), color-stop(100%, rgba(142,222,174,1)));
                    background: -webkit-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                    background: -o-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                    background: -ms-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                    font-weight: 100;
                    font-size:12px;
                    padding-left: 18%;
                }
            }

            /*            #img-marketplace{
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
                        }*/

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
        <style>
            body{
                font-family: "helvetica" !important;
            }

            .login-button{
                margin: 0 !important;
                padding-bottom: 6px !important;
                padding-top: 6px !important;
                color:white !important;
                border-bottom-left-radius: 1em 1em 1em 1em !important;
                width: 100% !important;
                border: 0 !important;  
                background: rgba(241,111,92,1) !important;
                background: -moz-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(231,56,39,1)), color-stop(0%, rgba(52,205,159,1)), color-stop(49%, rgba(142,222,174,1)), color-stop(100%, rgba(142,222,174,1))) !important;
                background: -webkit-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -o-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -ms-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                font-size:17px !important;
                font-weight: 100 !important;
                -webkit-transition: all 0.3s ease-in-out !important;
                -moz-transition: all 0.3s ease-in-out !important;
                transition: all 0.3s ease-in-out !important;
            }
            .login-button:hover{
                background-color: #ffffff !important;
                background: #ffffff !important;
                color: #00c98a! important;
                border: 1px solid #00c98a !important;
                
            }
            .row-space{
                padding-bottom: 20px;
            }
            .row-center{
                display: flex;
                justify-content: center;
            }
            .color-font{
                color:#747175;
                font-weight: 100;
            }
            .underline{
                border-bottom: solid 2px #000000;
                display: inline;
                padding-bottom: 3px;
            }
            .underline-white{
                border-bottom: solid 2px #fff;
                display: inline;
                padding-bottom: 3px;
            }

            .underline-green{
                border-bottom: solid .1px #00c98a;
                display: inline;
                padding-bottom: 3px;
            }
            .title-color{
                color:#4c4b49;
                font-weight:100;
            }

            .carousel-control.left{
                background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.0001)));
                background-image:linear-gradient(to right,rgba(0,0,0,.0001) 0,rgba(0,0,0,.0001) 100%)
            }
            .carousel-control.right{
                background-image:-webkit-gradient(linear,left top,right top,from(rgba(0,0,0,.0001)),to(rgba(0,0,0,.0001)));
                background-image:linear-gradient(to right,rgba(0,0,0,.0001) 0,rgba(0,0,0,.0001) 100%)
            }
            .carousel-control{
                opacity:.9;
                width:6%
            }
            .carousel-control.left{
                left: -1%;
                bottom: 10%;
            }
            .carousel-control.right{
                right: 1%;
                bottom: 10%;
                width:2%;

            }
        </style>
    </head>


    <body>
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
                        <li><a href="/" style="color:#00c98a;font-size:17px;font-weight: 100" ><span class="underline-green">Inicio</span></a></li>
                        <li><a href="/listProducts" style="color:#00c98a;font-size:17px;font-weight: 100">Productos</a></li>
                        <li><a href="/blog" style="color:#00c98a;font-size:17px;font-weight: 100">Blog</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-shopping-cart color-superfuds" aria-hidden="true"></span></a></li>
                        <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <section>
            <div class="container-fluid" style="padding-left: 0; background-attachment: fixed;padding-top: 4%" id="img-main">

                <div class="row">
                    <div class="col-lg-6 col-md-6" style="padding-top: 18%;padding-left: 8%">
                        <img src="{{ asset('assets/images/marketplace.png') }}" >
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="row" style="padding-top: 5%;padding-left: 10%">
                            <div class="col-lg-6 col-lg-offset-6 col-md-7 col-md-offset-4">
                                <p class="text-center"><img src="{{ asset('assets/images/sf_blanco.png') }}"></p>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 3%;">
                            <div class="col-lg-5 col-lg-offset-6 col-md-7 col-md-offset-4">
                                <div class="panel" style=" background-color:rgba(255,255,255,.4);border-color: white;padding: 0% 5% 0% 5%;border-radius: 10px">
                                    <div class="panel-body">
                                        <div class="row row-space">
                                            <div class="col-lg-10 col-lg-offset-1">
                                                <p style="color:white;font-size:25px; text-shadow: 2px 1px 5px #575757;font-weight: 100" class="text-center">Registrate como Cliente o Negocio</p>
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-10 col-lg-offset-1">
                                                <div style="width:50%;float:left;height: 30px;background-color: #86DDB0;text-align: center;vertical-align: middle;padding-top: 2%;border-radius: 10px 0 0 10px">Cliente</div>
                                                <div style="width:50%;float:left;height: 30px;border: solid 1px #00c98a;text-align: center;vertical-align: middle;padding-top: 2%;border-radius: 0 10px 10px 0;font-weight: 600">Proveedor</div>
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-12 ">
                                                <input class="form-control" placeholder="Compañia">
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-12">
                                                <input class="form-control" placeholder="Nombre">
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-12">
                                                <input class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-12">
                                                <input class="form-control" placeholder="Telefono">
                                            </div>
                                        </div>
                                        <div class="row row-space">
                                            <div class="col-lg-12">
                                                <input type="checkbox"><span style="color:white"> Acepto términas de servicio | Leer mas</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-3">
                                                <button type="button" class="btn buttons-page text-center">Registrate</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
        </section>


        <section>
            <div class="container-fluid">

                <div class="row" style="padding-bottom:7%;padding-top: 2%">
                    <div class="col-lg-10 col-lg-offset-1"><h1 class="text-center title-color" >Industria de alimentos <span class="underline">Saludables</span></h1></div>
                </div>

                <div class="row" style="padding-bottom:5%;">
                    <div class="col-lg-10 col-lg-offset-1">
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
                            <div class="col-lg-4 col-md-4">
                                <h4 class="text-center color-font" >
                                    "88% de las personas estan dispuestas a pagar más por alimentos saludables." <br><b>Forbes 2017</b>
                                </h4>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <h4 class="text-center color-font">"Para el 2017, las ventas globales de alimentos saludables llegarán a un trillón de dolares." . <br><b>Forbes 2017</b></h4>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <h4 class="text-center color-font">
                                    "7 de cada 10 colombianos desean bajar de peso y ser más saludables." <br><b>Nielsen 2017</b>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
                </div>
            </div>
        </section>


        <section>
            <div class="container-fluid" style="background-color:#fffcf8">

                <div class="row">
                    <div class="col-lg-12"><h1 class="text-center title-color" style="font-weight: 900">Nuestros <span class="underline">Productos</span></h1></div>
                </div>

                <div class="row">
                    <div class="col-lg-12"><h4 class="text-center font-color" >Entregamos todas tus marcas saludables favoritas directamente a tu negocio.</h4></div>
                </div>
                <div class="row">
                    <div class='col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1'>
                        <div class="carousel slide media-carousel" id="media">
                            <div class="carousel-inner">
                                <div class="item  active">
                                    <div class="row">
                                        <?php
                                        $cont = 0;
                                        foreach ($category as $i => $val) {
                                            if ($val->image != '') {
                                                ?>
                                                <div class="col-md-2" style="padding:0px">
                                                    <a class="fancybox thumbnail" style="padding:0px;border:0px;" rel="gallery1" href="shopping/{{$val->id}}">
                                                        <img src="{{$val->image}}" alt="">
                                                    </a>
                                                </div>
                                                <?php
                                                if ($cont == 5) {
                                                    $cont = 0;
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="item">
                                                <div class="row">
                                                    <?php
                                                }
                                                $cont++;
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
                    <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2"><h4>Lo Nuevo</h4></div>
                    <div class="col-lg-3 col-lg-offset-4 col-md-3 col-md-offset-3"><h4>Ver Todo</h4></div>
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
                                        foreach ($category as $i => $val) {
                                            ?>
                                            <div class="col-md-2">
                                                <a class="fancybox thumbnail" style="padding:0px;border:0px;" rel="gallery1" href="img/frezedetay.png">
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

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-1"><h4 class="color-font">Sub-categorias</h4></div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                        @foreach($subcategory as $val)
                        <div class="col-lg-2 col-md-2">
                            <div class="row"><div class="col-lg-12 col-md-12"><p class="text-center color-font">{{ucwords($val->description)}}</p></div></div>
                            <div class="row"><div class="col-lg-12 col-md-12"><img src="{{$val->alternative}}" alt="" class="img-responsive center-block"></div></div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="row green-bk">
                    <div class="col-lg-12">
                        <div class="row row-space">
                            <div class="col-lg-12"><h2 class="text-center" style="color:white"><span class="underline-white" style="font-size: 40px">Negocios</span></h2></div>
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
                                                    <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">1 Factura para 300+ <br>Productos Saludables de <br>40+ Marcas.</h2>
                                                    <p class="text-center"  style="color:#ffffff;padding-bottom: 5%"><img src="{{ asset('assets/images/hoja-blanco.png') }}"></p>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <a class="left carousel-control" href="#myCarousel" data-slide="prev" stuel>
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
        </section>

        <section>
            <div class="container-fluid" style="padding-top: 1%">
                <div class="row row-space" style="padding-bottom: 2%">
                    <div class="col-lg-12"><h2 class="text-center color-font">Lo que dic<span class="underline">en nuestro</span>s clientes</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="row row-space">
                            <div class="col-lg-12 text-center col-md-12"><img src="/images/click_clack.png"></div>
                        </div>

                        <div class="row row-space">
                            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2" style="color:#56be7f">
                                <p class="text-center"><b>Sergio Saavedra<br>
                                        Director General | Hotel Click Clack</b>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                                <p class="text-center color-font">
                                    Por medio de SuperFüds hemos accedido a un amplio portafolio de productos locales, altamente saludables con presentación impecable que los clientes de Click Clack han sabido disfrutar.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="row  row-space">
                            <div class="col-lg-12 text-center"><img src="/images/farmatado.png"></div>
                        </div>

                        <div class="row row-space">
                            <div class="col-lg-8 col-lg-offset-2" style="color:#56be7f">
                                <p class="text-center"><b>Teodoro Zubillaga<br>
                                        Country Manager | Farmatodo
                                    </b>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2">
                                <p class="text-center color-font">
                                    A través de SuperFüds ahora podemos brindar las mejores opciones para una alimentación saludable, con ellos ampliamos nuestra oferta para el cuidado integral de la salud y de esta forma estamos satisfaciendo las necesidades y gustos de nuestros clientes.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="col-lg-12 text-center"><img src="/images/rappi.png"></div>
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
                            <div class="col-lg-8 col-lg-offset-2">
                                <p class="text-center color-font">
                                    Hicimos esta alianza con SuperFüds por que lideran en Colombia el mercado de alimentos saludables y confiamos en su selección de proveedores para ofrecerle a nuestros clientes los mejores productos del mercado.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row row-space">
                    <div class="col-lg-4 col-md-4">
                        <p class="text-center color-font">
                            <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <p class="text-center color-font">
                            <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
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
                            <div class="col-lg-12"><h2 class="text-center" style="color:white"><span class="underline-white" style="font-size: 40px">Proveedores</span></h2></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12"><p class="text-center" style="color:white;font-size: 20px;font-weight: 100">Entregamos todas tus marcas favoritas directamente en tu negocio.</p></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="myCarouselpro" class="carousel slide" data-ride="carousel">

                                    <ol class="carousel-indicators">
                                        <li data-target="#myCarouselpro" data-slide-to="0" class="active"></li>
                                        <li data-target="#myCarouselpro" data-slide-to="1"></li>
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
                                                    <h2 class="text-center" style="color:#ffffff;padding-top: 2%;padding-bottom: 3%">1 Factura para 300+ <br>Productos Saludables de <br>40+ Marcas.</h2>
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
                    <div class="col-lg-12"><h2 class="text-center color-font">Lo que dic<span class="underline">en nuestros pr</span>oveedores ...</h2></div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="row row-space">
                            <div class="col-lg-12 text-center"><img src="/images/terra_fertil.png"></div>
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
                    <div class="col-lg-4 col-md-4">
                        <div class="row  row-space">
                            <div class="col-lg-12 text-center"><img src="/images/chocolov.png"></div>
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
                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="col-lg-12 text-center"><img src="/images/segalco.png"></div>
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
                <div class="row row-space">
                    <div class="col-lg-4 col-md-4">
                        <p class="text-center color-font">
                            <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <p class="text-center color-font">
                            <img src="{{ asset('assets/images/SF50X.png') }}" width="6%">
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-4">
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
                    <div class="col-lg-5 col-md-5">
                        <p class="text-center col-lg-offset-5"><img src="/images/movil.png"></p>
                    </div>
                    <div class="col-lg-7 col-md-7" style="padding-top: 5%">
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
                <div class="col-lg-5 col-md-5">
                    <h2 class="col-lg-offset-2" style="color:white">
                        Boletín. <br>
                        Regístrate y recibe tips, recetas <br>
                        y mucho más!
                    </h2>
                </div>
                <div class="col-lg-7 col-md-7">
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-lg-offset-4 col-md-5 col-md-offset-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <img src="/images/facebook.png">
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <img src="/images/instagram.png">
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <img src="/images/twitter.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row grey-bk" style="background-color:#fffcf8">
                <div class="col-lg-4 col-md-4">
                    <div style="width:100%;height:270px;background-image:url({{ asset('images/nosotros_back.png') }}); background-repeat: no-repeat;background-size: 100% 100%;">
                        <div class="row">
                            <div class="col-lg-12">
                                <h3 style="color:white" class="col-lg-offset-1">Nosotros</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <h4 style="color:white;font-weight: 100;line-height:1.5" class="col-lg-offset-1">
                                    Somos el marketplace de alimentos saludables más grande del país. Entregamos a clientes sus marcas saludables favoritas y nos encargamos de los negocios para que proveedores puedan concentrarse en su producto.</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
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
                <div class="col-lg-4 col-md-4">
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
                <div class="col-lg-12 col-md-12">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <p class="fancybox">SuperFüds 2017. Todos los Derechos Reservados.</p>
                </div>
            </div>
        </div>


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
