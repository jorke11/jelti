<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{{ asset('assets/images/logoico.png') }}}">
        <title>Superfuds</title>
        {!!Html::script('/vendor/template/vendors/jquery/dist/jquery.min.js')!!}

        {!!Html::script('/vendor/DataTables-1.10.13/media/js/jquery.dataTables.min.js')!!}
        {!!Html::style('/vendor/DataTables-1.10.13/media/css/jquery.dataTables.css')!!}
        
        
        
        {!!Html::style('/vendor/DataTables-1.10.13/extensions/Buttons/css/buttons.bootstrap.css')!!}
        {!!Html::style('/vendor/DataTables-1.10.13/extensions/Buttons/css/buttons.dataTables.min.css')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/Buttons/js/buttons.html5.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/Buttons/js/buttons.colVis.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/Buttons/js/buttons.flash.js')!!}
        {!!Html::script('/vendor/DataTables-1.10.13/extensions/Buttons/js/buttons.print.js')!!}
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>


        <!--<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>-->
        <!--<link href='//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css' rel="stylesheet" />-->

        {!!Html::script('/vendor/toastr/toastr.min.js')!!}
        {!!Html::style('/vendor/toastr/toastr.min.css')!!}
        <!--{!!Html::style('/vendor/DataTables-1.10.13/media/css/dataTables.bootstrap.css')!!}--> 
        <!--{!!Html::style('/vendor/DataTables-1.10.13/media/css/jquery.dataTables.css')!!}--> 

        {!!Html::style('/css/edited.css')!!}
        <!-- Bootstrap -->
        <!--<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">-->
        {!!Html::style('/vendor/template/vendors/bootstrap/dist/css/bootstrap.min.css')!!}
        {!!Html::style('/vendor/template/vendors/font-awesome/css/font-awesome.min.css')!!}
        {!!Html::style('/vendor/template/vendors/nprogress/nprogress.css')!!}
        {!!Html::style('/vendor/template/vendors/google-code-prettify/bin/prettify.min.css')!!}
        {!!Html::style('/vendor/template/build/css/custom.min.css')!!}
        <!-- Font Awesome -->

        <!--<link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">-->
        <!-- NProgress -->
        <!--<link href="../vendors/nprogress/nprogress.css" rel="stylesheet">-->
        <!-- bootstrap-wysiwyg -->
        <!--<link href="../vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">-->

        <!-- Custom styling plus plugins -->
        <!--<link href="../build/css/custom.min.css" rel="stylesheet">-->
    </head>

    <body class="nav-md">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                            <a href="/home" class="site_title">{!!Html::image('/assets/images/logo.png','foto',array("width"=>"25"))!!} <span>Superfuds</span></a>
                        </div>

                        <div class="clearfix"></div>

                        <!-- menu profile quick info -->
                        <div class="profile clearfix">
                            <div class="profile_pic">
                                <!--{!!Html::image('/assets/images/logo.png','foto',array('class' => 'img-circle profile_img'))!!}-->
                                {!!Html::image('/assets/images/default.jpeg','Profile Image',array('class' => 'img-circle profile_img'))!!}
                                <!--{!!Html::image('/vendor/template/images/img.jpg','foto',array('class' => 'img-circle profile_img'))!!}-->
                                <!--<img src="images/img.jpg" alt="..." class="img-circle profile_img">-->
                            </div>
                            <div class="profile_info">
                                <span>Welcome,</span>
                                <h2>{{auth()->user()->name}}</h2>
                            </div>
                        </div>
                        <!-- /menu profile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <h3>General</h3>
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/sale">Sales</a></li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-file"></i> Operation <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/service">Request Service</a></li>
                                            <li><a href="/order">Order Sale</a></li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-unlock-alt" aria-hidden="true"></i> Security <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/user">Users</a></li>
                                            <li><a href="/profile">Profile</a></li>
                                            <li><a href="/register">Permission</a></li>
                                            <li><a href="{{url("/register")}}">Register</a></li>

                                        </ul>
                                    </li>
                                    <li><a><i  class="fa fa-cog" aria-hidden="true"></i> Administration <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/category">Category</a></li>                                    
                                            <li><a href="/product">Products</a></li>
                                            <li><a href="/supplier">Supplier</a></li>
                                            <li><a href="/warehouse">Warehouse</a></li>
                                            <li><a href="/mark">Mark</a></li>
                                            <li><a href="/city">City</a></li>
                                        </ul>
                                    </li>
                                    <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i> Inventory <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="/entry">Entry</a></li>
                                            <li><a href="/departure">Departure</a></li>                                    
                                            <li><a href="/kardex">Kardex</a></li>                                    
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->

                        <!-- /menu footer buttons -->
                        <div class="sidebar-footer hidden-small">
                            <a data-toggle="tooltip" data-placement="top" title="Settings">
                                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Lock">
                                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                            </a>
                        </div>
                        <!-- /menu footer buttons -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <!--<img src="images/img.jpg" alt="">-->
                                        <!--{!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}-->
                                        {!!Html::image('/assets/images/default.jpeg','Profile Image')!!}
                                        {{auth()->user()->name}}
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="javascript:;"> Profile</a></li>
                                        <li>
                                            <a href="javascript:;">
                                                <span class="badge bg-red pull-right">50%</span>
                                                <span>Settings</span>
                                            </a>
                                        </li>
                                        <li><a href="javascript:;">Help</a></li>
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

                                <li role="presentation" class="dropdown">
                                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-envelope-o"></i>
                                        <span class="badge bg-green">6</span>
                                    </a>
                                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                        <li>
                                            <a>
                                                <span class="image">
                                                    <!--<img src="images/img.jpg" alt="Profile Image" />-->
                                                    {!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}
                                                </span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <span class="image">
                                                    {!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}
                                                    <!--<img src="images/img.jpg" alt="Profile Image" />-->
                                                </span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <span class="image">
<!--                                                    <img src="images/img.jpg" alt="Profile Image" />-->
                                                    {!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}
                                                </span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a>
                                                <span class="image">
                                                    <!--<img src="images/img.jpg" alt="Profile Image" />-->
                                                    {!!Html::image('/vendor/template/images/img.jpg','Profile Image')!!}
                                                </span>
                                                <span>
                                                    <span>John Smith</span>
                                                    <span class="time">3 mins ago</span>
                                                </span>
                                                <span class="message">
                                                    Film festivals used to be do-or-die moments for movie makers. They were where...
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="text-center">
                                                <a>
                                                    <strong>See All Alerts</strong>
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">

                        <div class="page-title">
                            <div class="title_left">
                                <h3>@yield('title') <small>@yield('subtitle')</small></h3>
                            </div>

                            <div class="title_right">
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Go!</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>@yield('title')<small>{{auth()->user()->name}}</small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="#">Settings 1</a>
                                                    </li>
                                                    <li><a href="#">Settings 2</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">                          
                                        @yield('content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="pull-right">
                        Created by <a href="https://www.superfuds.com">Superfuds</a>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
        </div>

        <!-- compose -->
        <div class="compose col-md-6 col-xs-12">
            <div class="compose-header">
                New Message
                <button type="button" class="close compose-close">
                    <span>×</span>
                </button>
            </div>

            <div class="compose-body">
                <div id="alerts"></div>

                <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a data-edit="fontSize 5">
                                    <p style="font-size:17px">Huge</p>
                                </a>
                            </li>
                            <li>
                                <a data-edit="fontSize 3">
                                    <p style="font-size:14px">Normal</p>
                                </a>
                            </li>
                            <li>
                                <a data-edit="fontSize 1">
                                    <p style="font-size:11px">Small</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                        <div class="dropdown-menu input-append">
                            <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                            <button class="btn" type="button">Add</button>
                        </div>
                        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                    </div>

                    <div class="btn-group">
                        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                    </div>

                    <div class="btn-group">
                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                    </div>
                </div>

                <div id="editor" class="editor-wrapper"></div>
            </div>

            <div class="compose-footer">
                <button id="send" class="btn btn-sm btn-success" type="button">Send</button>
            </div>
        </div>
        <!-- /compose -->

        <!-- jQuery -->

        {!!Html::script('/vendor/template/vendors/bootstrap/dist/js/bootstrap.min.js')!!}
        {!!Html::script('/vendor/template/vendors/fastclick/lib/fastclick.js')!!}
        {!!Html::script('/vendor/template/vendors/nprogress/nprogress.js')!!}
        {!!Html::script('/vendor/template/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js')!!}
        {!!Html::script('/vendor/template/vendors/jquery.hotkeys/jquery.hotkeys.js')!!}
        {!!Html::script('/vendor/template/vendors/google-code-prettify/src/prettify.js')!!}
        <!--<script src="../vendors/jquery/dist/jquery.min.js"></script>-->
        <!-- Bootstrap -->
        <!--<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>-->
        <!-- FastClick -->
        <!--<script src="../vendors/fastclick/lib/fastclick.js"></script>-->
        <!-- NProgress -->
        <!--<script src="../vendors/nprogress/nprogress.js"></script>-->
        <!-- bootstrap-wysiwyg -->
        <!--<script src="../vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>-->
        <!--<script src="../vendors/jquery.hotkeys/jquery.hotkeys.js"></script>-->
        <!--<script src="../vendors/google-code-prettify/src/prettify.js"></script>-->



        <!-- Custom Theme Scripts -->
        <!--<script src="../build/js/custom.min.js"></script>-->
        {!!Html::script('vendor/template/build/js/custom.min.js')!!}
    </body>
</html>