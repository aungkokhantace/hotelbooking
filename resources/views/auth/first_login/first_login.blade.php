<!DOCTYPE html>
<html>
<head>
    <title>Log In</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet">
    <script src="/assets/plugins/jquery/jquery-1.9.1.min.js"></script>

</head>
<body>
<div class="container">
    <div class="row middle">
        <div class="col-md-5 col-md-offset-3 login-left">
            <p id="logo" style="color: #f37023";><strong>AcePlus</strong> Management System</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 login-left">
            <div class="border">
                <div class="login" style="background-color: #f37023";>
                     First Log In
                </div>
                <!-- Starting Form -->
                {!! Form::open(array('url' => 'backend_mps/first_login' , 'id'=>'first_login'))!!}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if ($errors->has())
                            <p class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        @endif
                    <div class="user">
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-user user_color" style="color: #f37023";></span>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="user_name" id="username" value="{{ Request::old('user_name') }}" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <br>
                    <!-- Inserting Password -->
                    <div class="user">
                        <div class="col-md-2">
                            <span class="glyphicon glyphicon-lock user_color" style="color: #f37023";></span>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="password" id="pw" class="form-control" placeholder="Password">
                        </div>
                    </div>

                    <div class="col-md-11 col-md-offset-1 gap">
                        <!-- -->
                    </div>

                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-default fill_color login_btn" name="login" style="background-color:#f37023";>LOG IN</button>
                    </div>
                    <div class="col-md-7">
                            <a class="btn btn-link" href="{{ url('/password/reset') }}" style="color: #f37023";>Forgot Your Password?</a>

                    </div>
                </div>

                {!! Form::close() !!}
                <!-- Ending Form -->
            </div>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-5 col-md-offset-3 login-center">
            <img src="/images/aceplus_logo.png" class="pull-left height-full m-r-5">
        </div>
    </div>
</div>
<script src="/assets/js/validation/jquery.validate.js"></script>
<script src="/assets/js/validation/additional-methods.js"></script>
<script>
 //Start Validation for Entry and Edit Form
            $('#first_login').validate({
                rules: {
                    user_name         : 'required',
                    password          : 'required'
                },
                messages: {
                    user_name     : 'Username is required',
                    password      : 'Password is required'
                },
                submitHandler: function(form) {
                    $('input[type="submit"]').attr('disabled','disabled');
                    form.submit();
                }
            });
            //End Validation for Entry and Edit Form
</script>
</body>
</html>
