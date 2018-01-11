<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Superfus(Jelti)</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php
echo json_encode([
    'csrfToken' => csrf_token(),
]);
?>
        </script>
        <style>
            .navbar-brand {
                padding: 4px 15px;
            }
            body{
                margin: 0 auto;
                padding: 0;
                /*background: url('assets/images/foto_final_1507x850.png') center center no-repeat;*/
                background: url('assets/images/fondo_log_in.png') center center no-repeat;
                background-size:100%;
            }

            @media screen and (min-width:1340px) {
                margin: 0 auto;
                padding: 0;
                background: url('assets/images/fondo_log_in.png') center center no-repeat;
                background-size:100%;
            }

        </style>
    </head>

    <body >
        <div id="app">

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="/js/app.js"></script>
    </body>
</html>
