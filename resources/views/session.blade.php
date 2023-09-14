<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Panneau d'enseignement</title>

    </head>
    <body>
        <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

        <h1>Panneau d'enseignement: Session {{ $session->id }}</h1>
        <h2>Professeur: {{ $owner->name }}</h2>

        @if($user->status == 'professeur')
        <div id="qr-code"></div>

        @endif
        <div>
            <p>Liste des élèves</p>
            <table border="1">
                <tr>
                    <th>Nom</th>
                    <th>Status de présence</th>
                </tr>
                @foreach ($users as $user)
                <tr>
                    @if($user->status == 'etudiant')
                    <td>{{ $user->name }}</td>
                    <td>{{ $users_that_signed->contains($user->id) ? "✅" : "❌" }}</td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>

        <script type="text/javascript">
        let text = "{{ env('APP_URL') }}:8000/sign/{{ $session->id }}"
        function generateQRCode() {
            let qrcodeContainer = document.getElementById("qr-code");
            qrcodeContainer.innerHTML = "";
            new QRCode(qrcodeContainer, text);
        }
        generateQRCode()
        </script>
    </body>
</html>
