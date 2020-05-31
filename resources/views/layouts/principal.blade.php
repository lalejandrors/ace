<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo')</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.ico') }}">

    {!!Html::style('css/app.css')!!}
    {!!Html::style('css/custom.css')!!}

    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="collapse navbar-collapse" id="app-navbar-collapse"></div>
            </div>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <div class="panel panel-default">
                        <div class="panel-body" style="padding: 30px;">
                            @include('flash::message')
                            @yield('contenido')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!!Html::script('js/app.js')!!}
    
    @yield('js')
</body>
</html>