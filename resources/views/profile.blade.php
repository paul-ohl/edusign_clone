<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Page de profil</title>

    </head>
    <body>
        <body>
            <h1>Tu es {{ $user->name }}</h1>
            <h3>Bravo</h3>
            @if($user->status == 'professeur')
            <form method="POST" action="{{route('sessions.store')}}">
                @csrf
                <div>
                    <input type="submit" value="Créer une nouvelle session!">
                </div>
            </form>

            <div>
                @if(sizeof($sessions) > 0)
                <p>Liste des sessions</p>
                <table border="1">
                    <tr>
                        <th>ID de salle</th>
                    </tr>
                    @foreach ($sessions as $session)
                    <tr>
                        <td><a href="/sessions/{{ $session->id }}">{{ $session->id }}</a></td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
            @endif

            <a href="/user/logout">Se déconnecter</a>
        </body>
    </body>
</html>
