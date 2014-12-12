<?php

class otpauth {
	static $MAXRECOVERYCODES = 10;
	static $RECOVERYCODE_LENGH = 5;

    public function checkRecoveryCode($secret,$code) {
        return false;
    }

    public function generateRecoveryCodes(){
		for ($i = 0; $i<= self::$MAXRECOVERYCODES; $i++){
			$recoverycodes[] = $this->generateRandomString() . " - " . $this->generateRandomString();
		}
		return $recoverycodes;
    }

    public function generateRandomString(){
		//$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters = '0123456789abcdef';
	    $randomString = '';
	    for ($i = 0; $i < self::$RECOVERYCODE_LENGH; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
    }

}

