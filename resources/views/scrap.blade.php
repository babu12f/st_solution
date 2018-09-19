<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            
            <h1>My Form</h1>
            
            <form method="POST" action="{{ url('/scrap') }}">
                {{ csrf_field() }}
                <input type="text" name="name"/>
                <input type="text" name="password"/>
                <input type="submit" value="Submit"/>
            </form>
        </div>
    </body>
</html>
