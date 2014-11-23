<?php

	if ( file_exists("lib/config/config_db.php") ){
		require_once("lib/config/config_db.php");
		require_once("lib/db/MysqliDb.php");
		$db = new MysqliDb ($host, $username,$password, $dbname);
	} else {
		header("location: install.php");
	}

	if ( is_null($host) || is_null($username) || is_null($password) || is_null($dbname) ) {
		print "ERR \n Database not configured!";
		exit();
	}

	require_once("lib/Auth/otpauth.php");
	require_once("lib/Auth/GoogleAuthenticator.php");

	$g = new GoogleAuthenticator();
	$otpauth = new otpauth();

	$code = $_REQUEST['code'];
	$method = $_REQUEST['method'];

	if ($g->checkCode($secret,$code)) {
		print "OK";
	} else {
  	   if ( $otpauth->checkRecoveryCodes() )
	      print "OK";
	   else
	      print "ERR \n Token not valid";
	}

