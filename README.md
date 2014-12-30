php-otpauth
===========

A simple Two Factor Authenticaton generator and validator based on Google Authenticator

The authentication is provided by a HTTP POST and can be used with pam_url (https://fedorahosted.org/pam_url/)
to provide a two factor PAM authentication without the need to install any specific client.

Used libs:
Google Authenticator by chregu: https://github.com/chregu/GoogleAuthenticator.php
PHP Mysql Class by joshcam: https://github.com/joshcam/PHP-MySQLi-Database-Class
Jquery-QrCode: http://larsjung.de/jquery-qrcode/