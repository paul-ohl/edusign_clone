let text = "http://{{ env('APP_URL') }}:8000/sign/{{ $session->id }}"

function generateQRCode() {
    let qrcodeContainer = document.getElementById("qr-code");
    qrcodeContainer.innerHTML = "";
    new QRCode(qrcodeContainer, text);
}
generateQRCode()

