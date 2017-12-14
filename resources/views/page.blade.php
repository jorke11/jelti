
<?php
# Iniciando la variable de control que permitirá mostrar o no el modal
$exibirModal = false;
# Verificando si existe o no la cookie
if (!isset($_COOKIE["mostrarModal"])) {
    # Caso no exista la cookie entra aquí
    # Creamos la cookie con la duración que queramos
    //$expirar = 3600; // muestra cada 1 hora
    //$expirar = 10800; // muestra cada 3 horas
    //$expirar = 21600; //muestra cada 6 horas
    $expirar = 43200; //muestra cada 12 horas
    //$expirar = 86400;  // muestra cada 24 horas
    setcookie('mostrarModal', 'SI', (time() + $expirar)); // mostrará cada 12 horas.
    # Ahora nuestra variable de control pasará a tener el valor TRUE (Verdadero)
    $exibirModal = true;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SuperFüds</title>
        <link rel="shortcut icon" href="{{ asset('assets/images/logoico.png') }}">
        {!!Html::script('/vendor/template/vendors/jquery/dist/jquery.min.js')!!}
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <meta name="keywords" content="organico,saludable">
        <meta name="description" content="¡SuperFüds es el futuro del descubrimiento de nuevos productos! Hemos creado una forma más eficiente para que los consumidores y proveedores se conecten. Nuestra plataforma en línea administra productos saludables y ecológicos de cientos de proveedores en múltiples categorías, lo que facilita a los compradores y consumidores enfocarse rápidamente en los que son adecuados para ellos y compartirlos con el mundo.">
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
                /*position: absolute;*/

                left:55%;
                /*display: inline-block;*/
                outline: none;
                background-color: rgba(255,255,255,.3);
                border-color: #ffffff;
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
                    top:50%;
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
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
(function () {
    var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/5a2ea31bd0795768aaf8e9a6/default';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
})();
    </script>
    <!--End of Tawk.to Script-->

    <body>
        <!--        <div class="container-fluid" id="container-video">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 " style="padding: 0;">
                            <header id="headervideo" style="padding-top: 3%"> 
                                <video autoplay="autoplay" loop="loop" id="video_background" preload="auto" volume="50" style="width:100%">
                             <source src="images/fondo.mpeg" type="video/mpeg" />
                                    <source src="images/fondo.mp4" type="video/mp4" />
                                </video>
                                <button type="button" class="btn btn-primary btn-lg" id="buttonMain" style="" data-toggle="modal" data-target="#myModal">
                                    Registrate como<br>
                                    <span style="font-weight: 900;font-size: 30px">Cliente o Proveedor</span>
                                </button>
                            </header>
                        </div>
                    </div>
                </div>-->

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
                                            <p style="color:white;font-size:25px; text-shadow: 2px 1px 5px #575757;font-weight: 100" class="text-center">Registrate como</p>
                                        </div>
                                    </div>
                                    <div class="row row-space">
                                        <div class="col-lg-10 col-lg-offset-1">
                                            <div  class="box-client" onclick="objPage.stakeholder(1, this)">Negocio</div>
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


<!--    <section>
        <div class="container-fluid" >
            <div class="row" style="background-color: #68b9a3;padding-bottom: 1%;">
                <div class="col-lg-12">
                    <h4 style="color:white">Invita y Gana</h4>
                </div>
            </div>
        </div>
    </section>-->

    <nav class="navbar navbar-default navbar-fixed-top" style="margin-bottom:0px;padding-top: 4px;min-height: 60px;">
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

    <section style="padding-top: 3%">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="images/banner_navidad.jpg" alt="Bebés" class="img-responsive" width="100%">
                    <div class="carousel-caption" style="padding-left: 50%">
                        <button type="button" class="btn btn-primary btn-lg" id="buttonMain" style="" data-toggle="modal" data-target="#myModal">
                            Registrate como<br>
                            <span style="font-weight: 900;font-size: 30px">Cliente o Proveedor</span>
                        </button>
                    </div>
                </div>
                <div class="item">
                    <img src="images/banner_bebe.jpg" alt="Navidad" width="100%">
                    <div class="carousel-caption" style="padding-left: 40%">
                        <a href="/shopping/18" style="color:white;background-color: #139c9e;border: 1px solid white;
                           border-radius: 30px;padding:10px 40px 10px 40px;font-size: 40px;font-weight: 800">BEBES</a>
                    </div>

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
</section>


<section id="divProduct" style="padding-top:4%">
    <div class="container-fluid" style="background-color:#fffcf8">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center title-color" >Nuestros <span class="underline">Productos</span></h1>
            </div>
        </div>

        <div class="row row-space">
            <div class="col-lg-12"><p class="text-center font-color" style="font-size: 18px" >Entregamos todas tus marcas saludables favoritas directamente a tu Negocio.</p></div>
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

        <div class="row row-space">
            <div class="col-lg-8 col-lg-offset-2 ">
                <div class="carousel slide media-carousel" id="subcategories">
                    <div class="carousel-inner">
                        <div class="item  active">
                            <div class="row" style="padding-top: 2%;padding-bottom: 2%;">
                                <?php
                                $cont = 0;
                                foreach ($subcategory as $i => $val) {
                                    ?>
                                    <div class="col-md-2 col-sm-2 col-xs-2" >

                                        <a class="fancybox thumbnail img-subcategory" style="padding:0px;border:0px;background-color: rgba(0,0,0,0)" rel="gallery1" 
                                           href="shopping/_{{$val->id}}">
                                            <img src="{{$val->img}}" alt="">
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
        <br>
        </section>


        <section style="background-color: #FAF6EE;padding-top: 1%;padding-bottom: 2%">   
            <div class="row">
                <div class="col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-5 "><h3 class="color-font">Lo Nuevo</h3></div>
                <div class="col-lg-3 col-lg-offset-4 col-md-3 col-md-offset-3 col-sm-3 col-sm-offset-3 col-xs-5 col-xs-offset-2"><h4 class="text-muted color-font" style="padding-top: 3%">Ver Todo</h4></div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2"><hr style="border-top: 1px solid #ccc"></div>
            </div>
            <div class="row" >
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2">
                    <div class="carousel slide media-carousel" id="newproducts">
                        <div class="carousel-inner">
                            <div class="item  active">
                                <div class="row">
                                    <?php
                                    $cont = 0;
                                    foreach ($newproducts as $i => $value) {
                                        ?>
                                        <div class="col-md-3 col-sm-2 col-xs-2">
                                            <div class="thumbnail" style="border: 0;padding: 0">
                                                <div class="row" >
                                                    <div class="col-lg-12">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                @if($value->characteristic!=null)
                                                                @foreach($value->characteristic as $val)
                                                                <div class="col-lg-2">
                                                                    <div class="row">
                                                                        <div class="row hover01">
                                                                            <div class="col-lg-12">
                                                                                <img width="60%" id="sub_{{$val->id}}" src="/{{$val->thumbnail}}" alt="" class="img-responsive center-block" style="cursor:pointer">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <img src="{{url("/")."/".$value->thumbnail}}">
                                                <div class="caption" style="padding: 0">
                                                    <h5 class="text-center" style="min-height: 40px"><a href="/productDetail/{{$value->id}}" style="color:black;font-weight: 400;letter-spacing:2px"><?php echo $value->short_description; ?></a></h5>
                                                    @if(!Auth::guest())
                                                    <p>
                                                    <h4 class="text-center" style="color:black;font-weight: 400;">$ {{number_format($value->price_sf,2,",",".")}}</h4>
                                                    </p>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            @if(!Auth::guest())
                                                            <a href="/productDetail/{{$value->id}}" class="btn btn-success form-control" style="background-color: #30c594;">COMPRAR</a>
                                                            @else
                                                            <a href="/login" class="btn btn-success form-control" style="background-color: #30c594;">COMPRAR</a>
                                                            @endif

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
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

        </section>



        <section style="padding-top: 3%;">
            <div class="container-fluid">
                <div class="row" style="padding-bottom: 4%">
                    <div class="col-lg-12"><h1 class="color-font text-center">¿Que es SuperFuds?</h1></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 ">
                        <div class="row" style="padding-top: 5%;background-color: #BAF2E8">
                            <div class="col-lg-4">
                                <div class="row row-space">
                                    <div class="col-lg-12">
                                        <img src="images/SF.png" style="width: 20%" class="img-responsive center-block">
                                    </div>
                                </div>
                                <div class="row" style="padding-bottom: 20%;">
                                    <div class="col-lg-12">
                                        <p class="text-justify" style="letter-spacing:2px">
                                            Por medio de SuperFüds hemos accedido a un amplio portafolio de productos locales, altamente saludables con presentación impecable que los clientes de Click Clack han sabido disfrutar.    
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row row-space">
                                    <div class="col-lg-12">
                                        <img src="images/SF.png" style="width: 20%" class="img-responsive center-block">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"  style="padding-bottom: 20%;">
                                        <p class="text-justify" style="letter-spacing:2px">
                                            A través de SuperFüds ahora podemos brindar las mejores opciones para una alimentación saludable, con ellos ampliamos nuestra oferta para el cuidado integral de la salud y de esta forma estamos satisfaciendo las necesidades y gustos de nuestros clientes.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="row row-space">
                                    <div class="col-lg-12">
                                        <img src="images/SF.png" style="width: 20%" class="img-responsive center-block">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"  style="padding-bottom: 20%;">
                                        <p class="text-justify" style="letter-spacing:2px">
                                            Hicimos esta alianza con SuperFüds por que lideran en Colombia el mercado de alimentos saludables y confiamos en su selección de proveedores para ofrecerle a nuestros clientes los mejores productos del mercado.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-8 col-lg-offset-2" style="background-color: #FAF6ee;"><h3 class="color-font text-center">Lo que Aman nuestros <b>Clientes</b> y <b>Proveedores</b></h3></div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 ">
                        <div class="row">
                            <div class="col-lg-6" style="background-color: #1ec296">
                                <div id="carousel-clients2" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">
                                        <div class="item active">
                                            <img src="logos_blancos/clickclack.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Sergio Saavedra</h2>  
                                                <p>Director General</p>  
                                                <p>
                                                    Por medio de SuperFüds hemos accedido a un amplio portafolio de productos locales, altamente saludables con presentación impecable que los clientes de Click Clack han sabido disfrutar.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="logos_blancos/farmatodo.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Farmatodo</h2>  
                                                <p>
                                                    A través de SuperFüds ahora podemos brindar las mejores opciones para una alimentación saludable, con ellos ampliamos nuestra oferta para el cuidado integral de la salud y de esta forma estamos satisfaciendo las necesidades y gustos de nuestros clientes.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="logos_blancos/rappi.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Rappi</h2>  
                                                <p>
                                                    Hicimos esta alianza con SuperFüds por que lideran en Colombia el mercado de alimentos saludables y confiamos en su selección de proveedores para ofrecerle a nuestros clientes los mejores productos del mercado.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-clients2" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-clients2" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6" style="background-color: #49e2c6">
                                <div id="carousel-supplier" class="carousel slide" data-ride="carousel">
                                    <!-- Indicators -->
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                    </ol>

                                    <!-- Wrapper for slides -->
                                    <div class="carousel-inner" role="listbox">

                                        <div class="item active">
                                            <img src="logos_blancos/terrafertil.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Terrafertil</h2>  
                                                <p>
                                                    "Trabajar con SuperFüds es una oportunidad de ingresar a mercados diferentes que van a la vanguardia de nuestra marca, tienen la energía y la actitud para sacar proyectos nuevos".
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="logos_blancos/chocolov.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Chocolov</h2>  
                                                <p>
                                                    "A través de SuperFüds hemos expandido nuestro negocio, llegando a muchos más clientes en diferentes ciudades de Colombia y logrando masificar nuestros productos. Son un aliado que además de ser los únicos especializados en su categoría, tienen una amplia visión sobre el B2B y B2C ya que están en la constante búsqueda e implementación de herramientas para generar nuevos negocios".
                                                </p>
                                            </div>
                                        </div>
                                        <div class="item">
                                            <img src="logos_blancos/segalco.png" alt="..." class="img-responsive center-block" style="padding-top: 10%;padding-bottom: 50%" width="40%">
                                            <div class="carousel-caption">
                                                <h2>Segalco</h2>  
                                                <p>
                                                    "Trabajar con SuperFüds ha sido una experiencia interesante, hemos podido aperturar unos mercados de nicho que nos interesaba y hemos llegado a puntos donde no habíamos podido llegar. Su drive haciendo distribución punto a punto con varios productos hace que el negocio sea rentable para todos los jugadores".
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Controls -->
                                    <a class="left carousel-control" href="#carousel-supplier" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-supplier" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section style="padding-bottom: 2%;padding-top: 2%">
            <div class="row" style="background-color: #FAF6ee;">
                <div class="col-lg-12">
                    <div id="carousel-clients" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">

                            <div class="item active">
                                <div class="row" style="padding-top: 3%;padding-bottom: 3%">
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div class="col-lg-3">
                                            <img src="logos/olimpica-1.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/farmatodo-2.png" alt="..." class="img-responsive center-block" width="40%" >
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/rappi-3.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/click_clack-4.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row" style="padding-top: 3%;padding-bottom: 3%">
                                    <div class="col-lg-10 col-lg-offset-1">
                                        <div class="col-lg-3">
                                            <img src="logos/locatel-5.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/altoque-6.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/cruz_verde-7.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                        <div class="col-lg-3">
                                            <img src="logos/gastronomy-8.png" alt="..." class="img-responsive center-block" width="40%">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-clients" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-clients" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>


        <section >
            <div class="container-fluid grey-bk" style="background-color:#fffcf8;">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <p class="text-center col-lg-offset-5"><img src="/images/movil.png"></p>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7" style="padding-top: 5%">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="text-center" style="color:#4a4a4a">Descarga SuperFüds</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-center" style="color:#4a4a4a">Para  que puedas  llevar  la vida saludable a todas partes</h4>
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
                <div class="col-lg-2 col-md-4 col-sm-4 col-lg-offset-1 col-xs-4" style="padding-top: 2%;">
                    <img src="/images/aliados.png" class="img-responsive">
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
                </div
                <div class="col-lg-2 col-md-4 col-sm-4 col-lg-offset-1 col-xs-4" >
                    <img src="/images/superfuds_gris.png" class="img-responsive" style="padding-top: 5%;padding-left: 7%">
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
        <?php if ($exibirModal === true) : // Si nuestra variable de control "$exibirModal" es igual a TRUE activa nuestro modal y será visible a nuestro usuario. ?>
            <script>
                $(document).ready(function ()
                {
                    // id de nuestro modal
                    $("#myModal").modal("show");

                });
            </script>
        <?php endif; ?>
        