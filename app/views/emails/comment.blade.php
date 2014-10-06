<!DOCTYPE html>
<html lang="en-US">
    <head>
        <link href='http://fonts.googleapis.com/css?family=Nobile:400,700' rel='stylesheet' type='text/css'>
        <meta charset="utf-8">
    </head>
    <body style="background-color:#428bca; padding:50px;">
        <h1 style="@import url(http://fonts.googleapis.com/css?family=Lobster);color:white;font-family:'Lobster',sans-serif;">Wellsio</h1>
        <hr>
        <h3 style="color:white;font-family:sans-serif;">{{$user_name}} commented on your well!</h3>
        <p style="color:white">Here's what they said:</p>
        <div style="color:white; padding:10px; border:1px solid white;">
            {{ $body }}
           
        </div>
        <p style="color:white">Check it out here: {{ URL::to('well/' . $address_id) }}</p>
        <br>
        <p style="color:white"><a style="color:white" href="{{ URL::to('/') }}">Wellsio</a></p>
    </body>
</html>