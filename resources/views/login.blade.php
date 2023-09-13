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
            <div>
                <label for="nameSelector">Selectionnez votre utilisateur:</label>
                <select id="nameSelector">
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <a href="#">Se connecter</a>
            </div>
        </body>
    </body>
</html>
