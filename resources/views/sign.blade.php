<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Signature de présence</title>

    </head>
    <body>
        <form method="POST" action="/sign/{{$id}}">
            @csrf
            <h1>Signature de présence</h1>
            <input type="hidden" name="session_id" value="{{$id}}">
            <input type="submit" name="envoyer">
        </form>
    </body>
</html>