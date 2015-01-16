<?php

class otpauth {
	static $MAXRECOVERYCODES = 10;
	static $RECOVERYCODE_LENGH = 5;

    public function checkRecoveryCode($secret,$code) {
	
		require("lib/config/config_db.php");
		$db = new MysqliDb ($host, $username,$password, $dbname);
		
		$db->where("SECRETKEY", $secret);
		$dbuser = $db->getOne("otp_users");
		
		if($dbuser['ID']){
		
			$db->where("USER_ID", $dbuser['ID']);
			$db->where("RECOVERYCODE", $code);
			$db->where("CODE_USED", "0");
			
			$dbrecoverycode = $db->getOne("otp_recoverycodes");

			if($dbrecoverycode['ID']){
				$data = Array ('CODE_USED' => '1');
				$db->where ('RECOVERYCODE', $code);
				$db->update("otp_recoverycodes", $data );
				
				return true;
			}

		} else {

			return false;

		}
    }

    public function generateRecoveryCodes(){
		for ($i = 0; $i<= self::$MAXRECOVERYCODES; $i++){
			$recoverycodes[] = $this->generateRandomString();
		}
		return $recoverycodes;
    }

    public function generateRandomString(){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    //$characters = '0123456789abcdef';
	    $randomString = '';
	    for ($i = 0; $i < self::$RECOVERYCODE_LENGH; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
    }

}

