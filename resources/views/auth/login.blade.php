<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Logistics Plus</title>

    <link rel="stylesheet" type="text/css" href="{{url('css/admin.min.css')}}">


</head>

<body class="login__body">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Welcome to Logistics plus elevator system</h2>
                </div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ url('/login') }}" style="text-align: center;">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email" name="email" type="email">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-info btn-block button-login">
                                Login
                            </button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Metis Menu Plugin JavaScript -->

<!-- Custom Theme JavaScript -->


</body>

</html>