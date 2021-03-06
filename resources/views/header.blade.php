<style>
    #search{
        background-color: rgba(255,255,255,0);border-top: none;
        border-right: none;border-left: none;border-bottom: 2px solid #fff;color: #fff;
        width: 80%
    }
    #search::placeholder{
        color:white
    }

</style>
<section>
    <div class="container-fluid" style="padding-bottom: 2%;">
        <div class="row" style="background-color: #68b9a3;position: fixed;right: 0;left: 0;z-index: 1030;padding-left: 2%;">
            <div class="col-lg-8">
                <!--<h4 style="color:white">Invita y Gana</h4>-->
            </div>
            <div class="col-lg-3" style="padding-bottom: 1%">
                <form autocomplete="on" id="formSearch" action="{{url("/")}}">
                    <div class="input-group">
                        <span class="input-group-addon" style="background-color: rgba(255,255,255,.0);border: 0">
                            <i class="glyphicon glyphicon-search" style="color:white" onclick="objPage.search()"></i></span>
                        <input id="search" type="text" class="form-control" name="search" placeholder="Qué producto buscas?" size="30">
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>


<nav class="navbar navbar-default navbar-fixed-top" id="menuNav" style="margin-bottom:0px;padding-top: 4px;min-height: 60px;top:41px">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style='padding-left: 2%'>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url("/")}}">
                <img alt="Brand" src="{{ asset('assets/images/SF50X.png') }}">
            </a>

        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 5%">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/" class="anim-underline" style="color:#00c98a;font-size:17px;font-weight: 100" >Inicio</a></li>
                <li><a href="/ecommerce/0" class="anim-underline" style="color:#00c98a;font-size:17px;font-weight: 100" id="menuProduct" ><span class="">Productos</span></a></li>
                <li><a href="{{url("blog")}}" class="anim-underline"  style="color:#00c98a;font-size:17px;font-weight: 100">Blog</a></li>
                
                @if(Auth::user()==null)
                <li ><a href="#" class="anim-underline" onclick="objPage.openModal('myModal')" style="color:#00c98a;font-size:17px;font-weight: 100">Registrarme</a></li>
                @endif
                @if(Auth::user()!=null)

                @if(Auth::user()->role_id!=2)
                <li><a href="/home" style="color:#00c98a;font-size:17px;font-weight: 100">Jelty</a></li>
                @endif
                @if(Auth::user()->role_id == 2)
                <li> <a href="/payment">
                        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true" style="font-size: 25px;color:#30c594"></span>
                        <span class="badge">
                            <span id="quantityOrders"></span>
                        </span></a></li>
                <li>
                @endif


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-align-justify" aria-hidden="true"  style="font-size: 20px;color:#30c594">
                        </span><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/myProfile">Perfil</a></li>
                        <li><a href="/myOrders">Mis Ordenes</a></li>

                        <li role="separator" class="divider"></li>
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


                @endif
                @if(Auth::user()==null)
                <li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>
                @endif
            </ul>    

            <!--<li style="padding-top: 12px"><a href="/login" class="btn btn-success login-button" style="">Iniciar Sesión</a></li>-->

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
