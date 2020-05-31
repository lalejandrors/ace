<!DOCTYPE html>
<html>
    <head>
        <title>unauthorized.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }
            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
            #imgError{
                margin: 0 auto;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Sin autorización.</div>
                <img id="imgError" alt="Brand" src="{{ asset("images/error.png") }}" width="40%">
            </div>
        </div>
    </body>
</html>