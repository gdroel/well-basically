<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h3>Someone commented on your well!</h3>

        <div>
            <p>
            Someone said on your well:
            <br>
            {{ $body }}
            {{ URL::to('well/' . $address_id) }}<br/>
            </p>
        </div>

    </body>
</html>