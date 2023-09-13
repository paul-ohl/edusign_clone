<?php
session(['user_id', '1']);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page de profil</title>

    </head>
    <body>
        <body>
            <h1>Tu es {{ $current_user->name }}</h1>
            <h3>Bravo</h3>
            <a href="/user/logout">Se déconnecter</a>
        </body>
    </body>
</html>
