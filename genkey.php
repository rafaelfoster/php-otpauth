<HTML>
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="lib/js/jquery.js"></script>
	<script src="lib/js/jquery-ui.min.js"></script>
	<script src="lib/js/jquery.qrcode-0.11.0.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#qrcode").qrcode({
			    "render": "div",
				"width": 100,
				"height": 100,
				"color": "#3a3",
				"text": "http://larsjung.de/qrcode"
			});
		});
	</script>
</HTML>

<?php
	include_once("lib/Auth/GoogleAuthenticator.php");

	$secret = 'XVQ2UIGO75XRUKJO';
	$time = floor(time() / 30);
	$code = "846474";
	$g = new GoogleAuthenticator();

	print "Current Code is: ";
	print $g->getCode($secret) . "<br>";
	print "Check if $code is valid: <br>";

	if ($g->checkCode($secret,$code)) {
		print "YES <br>";
	} else {
		print "NO <br>";
	}

	$secret = $g->generateSecret();

	print "Get a new Secret: $secret " . "<br>";
	print "The QR Code for this secret (to scan with the Google Authenticator App: <br><br>";
	print $g->getURL('chregu','example.org',$secret) . "<br>";
	print "<div id='qrcode'> </div>";
	print "<br>";