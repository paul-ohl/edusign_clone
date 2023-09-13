<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Panneau d'administration</title>

    </head>
    <body>
        <body>
            <h1>Panneau d'administration</h1>
            <p>Don't be evil hahaha.</p>
            <div>
                <label for="name">Nom de l'utilisateur</label>
                <input type="text" id="name" name="name" required />
                <div>
                    <label for="nameSelector">Type d'utilisateur</label>
                    <select id="nameSelector">
                        <option value="admin">Administrateur</option>
                        <option value="teacher">Professeur</option>
                        <option value="student">Étudiant</option>
                    </select>
                </div>
            </div>
            <div>
                <a href="#">Ajouter un utilisateur</a>
            </div>
        </body>
    </body>
</html>
