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

<script type="text/javascript">
    let text = "http://{{ env('APP_URL') }}:8000/sign/{{ $session->id }}"
    function generateQRCode() {
        let qrcodeContainer = document.getElementById("qr-code");
        qrcodeContainer.innerHTML = "";
        new QRCode(qrcodeContainer, text);
    }
    generateQRCode()
    
    function refreshPageData(){
        fetch('/sessions/sign/{{$session->id}}').then(response => response.json()).then(data =>{
            console.log('data : ')
            console.log(data)
            const tableContainer = document.getElementById("table-container");
            
            for(i=0; i<data.length;i++){
                const tableHTML = `
            <table border="1">
                <tr>
                    <th>Colonne 1</th>
                    <th>Colonne 2</th>
                </tr>
                <tr>
                    <td>Nom</td>
                    <td>Statut de présence</td>
                </tr>
                <tr>
                    <td>${data[i].name}</td>
                    <td>${data[i].signed}</td>
                </tr>
                <tr>
                    <td>${data[i+1].name}</td>
                    <td>${data[i+1].signed}</td>
                </tr>
            </table>
            `;
            
            tableContainer.innerHTML = tableHTML
            }
            
        })
    }
    
    
    
    setInterval(refreshPageData, 3000)
</script>
@include('footer')
