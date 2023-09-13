<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Liste de tout les utilisateurs</title>

    </head>
    <body>
        <h1>Liste</h1>

        <div>
            <p>Liste de tout le monde</p>
            <table border="1">
                <tr>
                    <th>Nom</th>
                    <th>Status</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->status }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>
