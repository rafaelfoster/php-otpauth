<HTML>
	<link href="css/jquery-ui.min.css" rel="stylesheet">
	<script src="lib/js/jquery.js"></script>
	<script src="lib/js/jquery-ui.min.js"></script>
	<script src="lib/js/jquery.qrcode-0.11.0.min.js"></script>
	<script type="text/javascript">
		$(function(){
			var strSecret = document.getElementById("qrcode-txt")
			strSecret = strSecret.innerHTML 
			$("#qrcode").qrcode({
			    "size":   200,
				"color": "#3a3",
				"text": strSecret
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
	print "<a id='qrcode-txt'>" . $g->getURL('chregu','example.org',$secret) . "</a><br>";
	print "<div id='qrcode'> </div>";
	print "<br>";