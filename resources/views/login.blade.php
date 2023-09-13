<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Connexion</title>

    </head>
    <body>
        <body>
            <h1>Connexion</h1>
            <form method="POST" action="/user/login">
                @csrf
                <label for="user">Selectionnez votre utilisateur:</label>
                <select name="user" id="user">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="submit" value="Se connecter">
            </form>
        </body>
    </body>
</html>
