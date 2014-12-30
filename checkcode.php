<?php
	if ( file_exists("lib/config/config_db.php") ){

		require_once("lib/config/config_db.php");
		require_once("lib/db/MysqliDb.php");
		$db = new MysqliDb ($host, $username,$password, $dbname);

		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}

		require_once("lib/Auth/otpauth.php");
		require_once("lib/Auth/GoogleAuthenticator.php");

	} else {
		print "ERR \n Config file not found!";
		exit
	}

	$gooAuth = new GoogleAuthenticator();
	$otpauth = new otpauth();

	$user = $_REQUEST['user'];
	$code = $_REQUEST['code'];
	$method = $_REQUEST['mode'];

	$db->where('USER = ' . $user);
	$user = $db->get('otp_users');
	
	if ( $gooAuth->checkCode($secret,$code) ) {
		print "OK";
	} else {
		if ( $otpauth->checkRecoveryCode($code) )
			print "OK";
		else
			print "ERR \n Token not valid";
	}