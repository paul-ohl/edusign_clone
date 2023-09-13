<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Panneau d'administration</title>

    </head>
    <body>
        <form method="POST" action="/admin">
            @csrf
            <h1>Panneau d'administration</h1>
            <p>Don't be evil hahaha.</p>
            <div>
                <label for="name">Nom de l'utilisateur</label>
                <input type="text" id="name" name="name" required />
                <div>
                    <label for="status">Type d'utilisateur</label>
                    <select id="status" name="status">
                        <option value="admin">Administrateur</option>
                        <option value="teacher">Professeur</option>
                        <option value="student">Étudiant</option>
                    </select>
                </div>
            </div>
            <div>
            <input type="submit" value="ajouter">
            </div>
</form> 
<div>
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
</div>

    </body>
</html>