@include('header')
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<h1>Session {{ $session->id }}</h1>
<h2>Professeur: {{ $owner->name }}</h2>

@if($user->status == 'professeur')
<div class="center">
    <div id="qr-code"></div>
</div>
@endif
<div>
    <h2>Liste des élèves</h2>
    <div id="table-container"> </div>
</div>

<script type="text/javascript" src="{{ URL::asset('js/qrcode.js') }}"></script>
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

