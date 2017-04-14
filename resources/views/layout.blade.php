<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BattleShip</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <style>
            .container {
                margin-top: 5%;
            }
            .row {
                margin-top: 10px;
            }
            form {
                margin-bottom: 50px;
            }
            
            .boardsquare > button {
                width:100%;
                height:50px;
            }
        </style>
    </head>
    <body>
        @yield('body')
    </body>
</html>
