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
        {!!Html::script('/vendor/plugins.js')!!}
    </head>
    <body>
        @if(Auth::user()!=null)
        @if(Auth::user()->role_id!=2)
        <div class="container-fluid" >
            <div class="row" style="position: fixed;right: 0;left: 0;z-index: 2030;top: 10">
                <div class="col-lg-12">
                    <div class="alert alert-danger"><strong>Con tu perfil actual no se permite comprar!</strong></div>
                </div>
            </div>
        </div>
        @endif
        @endif

        <div id="loading-super" class="hidden" >
            <img src="{!!asset('images/Gif_final.gif')!!}" width='60%' >
            @if(Auth::user()!=null)
            <input id="role_id" type="hidden" value="{{Auth::user()->role_id}}">
            @endif
        </div>

        @include("header")


        <div class="container-fluid">
            @yield('content')
        </div>
    </body>

</html>