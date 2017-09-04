@extends('layouts.app')

@section('content')
<div class="container" >
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="background: rgba(255, 255, 255, 0.8);border-radius:20px">
                <div class="panel-body">
                    <br>
                    <br>
                    <br>
                    <br>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="row" style="padding-left: 50px;">
                            <div class="col-lg-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <img  src="{{ asset('assets/images/sf.png') }}" style="width: 90%">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <img  src="{{ asset('assets/images/fb_icon.png') }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <img  src="{{ asset('assets/images/ig_icon.png') }}">
                                    </div>
                                    <div class="col-lg-4">
                                        <img  src="{{ asset('assets/images/tw_icon.png') }}">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-8">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-7">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-7">
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary">
                                            Ingresar
                                        </button>

                                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
