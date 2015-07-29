<?
include_once 'constants.php';
include_once 'functions.php';




	$password = "dblue4innovate";
	$salt = bin2hex(openssl_random_pseudo_bytes(16));
	echo "<br>salt: $salt";
	$psw_salt = $password.$salt;
	echo "<br>psw_salt: $psw_salt";
	$salted_and_hashed = md5($psw_salt);
	echo "<br>salted and hashed: $salted_and_hashed";



?>


