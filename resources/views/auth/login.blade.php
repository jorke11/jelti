@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="row" style="padding-top: 200px;">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default" style="background: rgba(255, 255, 255, 0.9);border-radius:20px">
                <div class="panel-body" >
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="row" style="padding-left: 70px;padding-top: 80px;padding-bottom: 30px;">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="/"><img  src="{{ asset('assets/images/sf.png') }}" style="width: 90%"></a>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-center" style="color:#59D3AD ">ó conectate con nososotros</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a href="#"><img  src="{{ asset('assets/images/fb_icon.png') }}"></a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href="#"><img  src="{{ asset('assets/images/ig_icon.png') }}"></a>
                                    </div>
                                    <div class="col-lg-4">
                                        <a href=""><img  src="{{ asset('assets/images/tw_icon.png') }}"></a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4 col-lg-offset-2">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class=" control-label" style='color:rgba(0,0,0,0.8);font-family:"helvetica";font-weight: 400'>E-Mail Address</label>

                                    <!--<div class="col-md-7">-->
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus 
                                           style="border: 1px solid #ccc">

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    <!--</div>-->
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label" style='color:rgba(0,0,0,0.8);font-family:"helvetica";font-weight: 400'>Password</label>

                                    <!--<div class="col-md-7">-->
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                    <!--</div>-->
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6" style="padding-left: 0">
                                        <button type="submit" class="btn btn-success" style="
                                                border-bottom-left-radius: 1em 1em 1em 1em;width: 100%;
                                                border: 0;  
                                                background: rgba(241,111,92,1);
                                                background: -moz-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                                                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(241,111,92,1)), color-stop(0%, rgba(246,41,12,1)), color-stop(0%, rgba(231,56,39,1)), color-stop(0%, rgba(52,205,159,1)), color-stop(49%, rgba(142,222,174,1)), color-stop(100%, rgba(142,222,174,1)));
                                                background: -webkit-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                                                background: -o-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                                                background: -ms-linear-gradient(top, rgba(241,111,92,1) 0%, rgba(246,41,12,1) 0%, rgba(231,56,39,1) 0%, rgba(52,205,159,1) 0%, rgba(142,222,174,1) 49%, rgba(142,222,174,1) 100%);
                                                ">
                                            Iniciar Sesion
                                        </button>
                                    </div>
                                    <div class="col-md-6" style="padding-right: 0">
                                        <button type="submit" class="btn" 
                                                style="background-color: transparent; border: 2px solid #fff;color:rgba(0,0,0,0.8);width: 100%;">
                                            Registrarse
                                        </button>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12" style="padding-left: 0">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" style="opacity: 0.5;filter:  alpha(opacity=20);border:1px solid #59D3AD" name="remember" {{ old('remember') ? 'checked' : ''}}> <span style="color:#59D3AD;">Remember Me</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12" style="padding-left: 0">
                                        <a class="btn btn-link" href="{{ url('/password/reset') }}" style="padding-left: 0;color:#59D3AD">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>



                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
