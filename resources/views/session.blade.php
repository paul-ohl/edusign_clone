@include('header')
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<h1>Session {{ $session->id }}</h1>
<h2>Professeur: {{ $owner->name }}</h2>

@if($session->archived)
<p>Session archived</p>
@endif

@if($user->status == 'professeur' && !$session->archived)
<div class="center">
    <div id="qr-code"></div>
</div>
<a href='/sessions/archive/{{ $session->id }}'>Archiver la session</a>
@endif
<div>
    <h2>Liste des élèves</h2>
    <div id="table-container"> </div>
</div>

@if($user->status == 'professeur' && !$session->archived)
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::asset('js/qrcode.js') }}"></script>
<script type="text/javascript">
let baseURL = "http://{{ env('APP_URL') }}:8000/sign/{{ $session->id }}"
let qrCodeRefreshInterval = 10 // in seconds

fetch(`/sessions/get-key/{{$session->id}}?refresh-interval=${qrCodeRefreshInterval}`)
    .then(response => response.json())
    .then(key => {
        generateCode(key)
        setInterval(generateCode, qrCodeRefreshInterval * 1000, key)
    })

</script>
@endif
<script type="text/javascript">
function refreshPageData() {
    fetch('/sessions/sign/{{$session->id}}').then(response => response.json()).then(data => {
        const tableContainer = document.getElementById("table-container");

        let tableHTML = `
        <table border="1">
            <tr>
                <th>Nom</th>
                <th>Statut de présence</th>
            </tr>
        `;

        for(i=0; i<data.length; i++) {
            tableHTML+= `<tr>
                <td>${data[i].name}</td>
                <td>${data[i].signed ? "✅" : "❌"}</td>
            </tr>`
        }
        tableHTML+= `</table>`
        tableContainer.innerHTML = tableHTML
    })
}

setInterval(refreshPageData, 5000)
refreshPageData()
</script>
@include('footer')

