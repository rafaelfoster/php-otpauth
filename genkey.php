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

	if (!empty($_REQUEST['email'] )){

		//----------------------
		if ( require_once("lib/config/config_db.php") ){
			require_once("lib/db/MysqliDb.php");
			$db = new MysqliDb ($host, $username,$password, $dbname);

			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				//header("location: install.php");
				exit();
			}

			require_once("lib/Auth/otpauth.php");
			require_once("lib/Auth/GoogleAuthenticator.php");

		} else {
			print "DB Configuration file not found!";
			//header("location: install.php");

		}
		//----------------------
	
	
		$user = $_REQUEST['username'];
		$email = $_REQUEST['email'];
		list($username, $domain) = explode("@", $_REQUEST['email']);
	
		$db->where ("USER", $user);
		$db->orWhere ("EMAIL", $email);
		$dbuser = $db->getOne("otp_users");
		if($dbuser['ID']){
		
			print "User '".$user."' already exists or this email already being used.";
			exit;
	
		} else {
		
			include_once("lib/Auth/GoogleAuthenticator.php");
			include_once("lib/Auth/otpauth.php");

			$o = new otpauth();
			$g = new GoogleAuthenticator();
			$secret = $g->generateSecret();

			print "Get a new Secret: $secret " . "<br>";
			print "The QR Code for this secret (to scan with the Google Authenticator App: <br><br>";
			print "<a id='qrcode-txt'>" . $g->getURL($user,$domain,$secret) . "</a><br>";
			print "<div id='qrcode' style='display: block;'> </div>";
			print "<br>";
			
			$userdata = Array ("USER" => $user,
							   "EMAIL" => $username."@".$domain,
						       "SECRETKEY" => $secret
			);
			
			print_r($userdata)."<br><br>";
			print_r($_REQUEST);
			
			$user_id = $db->insert('otp_users', $userdata);
			
			if($user_id)
				print 'user was created. Id='.$user_id;
			else
				print "User not created! <br> Error: ". $db->getLastError();
				
			print "<div id='recoverycodes-txt'>";
			foreach( $o->generateRecoveryCodes() as $code ){
				print "<a> $code </a>";
				$arrRecoveryCodes = Array ("USER_ID" => $user_id, "RECOVERYCODE" => $code );
				$db->insert('otp_recoverycodes', $arrRecoveryCodes);
			}
			print "</div>";

			exit;

		}
		
	}
?>

<form name='frm-createuser' method='POST' action='#'>
  <table>
  <tr>
    <td>
	<label> Usuário </label>
    </td>
    <td>
	<input type='text' name='username'>
    </td>
  </tr>
  <tr>
    <td>
	<label> E-mail </label>
    </td>
    <td>
	<input type='text' name='email'>
    </td>  
  </tr>
  <tr>
    <td>
	<input type='submit' value='OK'> 
    </td>
  </tr>
  </table>
</form>