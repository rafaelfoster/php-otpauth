<?php

	if (!empty($_REQUEST['mode'])) {
		require("checkcode.php");
	}
	
	if ( require_once("lib/config/config_db.php") ){
		require_once("lib/db/MysqliDb.php");
		$db = new MysqliDb ($host, $username,$password, $dbname);

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			header("location: install.php");
			exit();
		}

		require_once("lib/Auth/otpauth.php");
		require_once("lib/Auth/GoogleAuthenticator.php");

	} else {

		header("location: install.php");

	}

	$g = new GoogleAuthenticator();
	$otpauth = new otpauth();

	$otpauth->generateRecoveryCodes();  
	
	$user = $_REQUEST['user'];
	$code = $_REQUEST['code'];
	$method = $_REQUEST['mode'];

	$db->where('USER = ' . $user);
	$user = $db->get('otp_users');
