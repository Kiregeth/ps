<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PASA | LOGIN</title>

    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/login-style.css')}}">
</head>
<body>
<div class="container">

    <div class="row" id="pwd-container">
        <div class="col-md-4 col-xs-2"></div>

        <div class="col-md-4 col-xs-8">
            <section class="login-form">
                <form method="post" action="{{route('login')}}" role="login">
                    {{ csrf_field() }}

                    <img src="{{asset('images/pasa-logo.png')}}" class="img-responsive" alt="Pasa International Pvt. Ltd" />
                    <div class="form-group{{ $errors->has('uname') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input id="uname" type="text" name="uname" value="{{ old('uname') }}" placeholder="User Name" required autofocus class="form-control input-lg" />
                            @if ($errors->has('uname'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('uname') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="col-xs-12">
                            <input id="password" type="password" class="form-control input-lg" placeholder="Password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>



                    <button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>

                    {{--<div>--}}
                        {{--<a href="#">Create account</a> or <a href="#">reset password</a>--}}
                    {{--</div>--}}

                </form>

                <div class="form-links">
                    <a  href="https://pasainternational.com.np" target="_blank">www.pasainternational.com.np</a>
                </div>
            </section>
        </div>
    </div>
</div>

</body>
</html>