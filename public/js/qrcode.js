function displayQRCode(url) {
    let qrcodeContainer = document.getElementById("qr-code")
    qrcodeContainer.innerHTML = ""
    new QRCode(qrcodeContainer, url)
}

function generateCode(key) {
    const timestamp = Math.ceil(Date.now() / 1000)
    const offset = timestamp % qrCodeRefreshInterval
    const hash = CryptoJS.SHA1(`${key}${timestamp}`)
    const hash_64 = hash.toString(CryptoJS.enc.Base64)
    const url = `${baseURL}?hash=${hash_64}&offset=${offset}`
    // const url = `${baseURL}?hash=${key}${timestamp}&offset=${offset}`
    displayQRCode(url);
}
