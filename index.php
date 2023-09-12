<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	<title>Blank HTML Page</title>
	</head>
	<body>
		<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

		<div class="form">
			<div id="qrcode" class="qrcode"></div>

			<script type="text/javascript">
			let text = "http://10.104.131.154:8000/sign.php"
			function generateQRCode() {
				let qrcodeContainer = document.getElementById("qrcode");
				qrcodeContainer.innerHTML = "";
				new QRCode(qrcodeContainer, text);
			}
			generateQRCode()
			</script>
		</div>


	</body>
</html>

