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
                font-weight: 300;
                border-bottom-left-radius: 1em 1em 1em 1em !important;
                width: 100% !important;
                border: 0 !important;  
                background: rgba(241,111,92,1) !important;
                background: -moz-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(231,56,39,1)), color-stop(0%, rgba(52,205,159,1)), color-stop(49%, rgba(142,222,174,1)), color-stop(100%, rgba(142,222,174,1))) !important;
                background: -webkit-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -o-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                background: -ms-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%) !important;
                font-size:20px !important;
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
                    <a class="navbar-brand" href="#">
                        <img alt="Brand" src="{{ asset('assets/images/SF50X.png') }}">
                    </a>

                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 5%">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/" style="color:#00c98a;font-size:20px;font-weight: 100" >Inicio</a></li>
                        <li><a href="/listProducts" style="color:#00c98a;font-size:20px;font-weight: 100">Productos</a></li>
                        <li><a href="/blog" style="color:#00c98a;font-size:20px;font-weight: 100"><span class="underline">Blog</span></a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-shopping-cart color-superfuds" aria-hidden="true"></span></a></li>
                        <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

         @yield('content')
    </body>

</html>
