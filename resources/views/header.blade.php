<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="utf-8">
    <title>SuperSign!</title>
</head>

<body>
    <nav>
        <div class="nav-wrapper">
            <a href="/" class="brand-logo center">SuperSign!</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/login">Connexion</a></li>
                <li><a href="/profile">Profil</a></li>
                <li><a href="/admin">Admin</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">

