<?
	require_once 'functions.php';


	verifyRequest($mysqli, $_POST);
	//echo "request verified";

	/*
	$user = "gluse";
	$device_id = "iphone34958";
	$token = "73a6499ae8ad44fcbfbdca3dd6d15445";

	$ret = hasValidToken($mysqli, $user, $device_id, $token);
	echo "<br>hasvalidtoken:$ret";
*/

	/*$user = sanitize('gluseppe');
	$email = sanitize('giuseppe.frau@dblue.it');
	$password = sanitize('123buona');
	$role = "user";


	//$password = "dblue4innovate";
	$salt = bin2hex(openssl_random_pseudo_bytes(16));
	echo "<br>salt: $salt";
	$psw_salt = $password.$salt;
	echo "<br>psw_salt: $psw_salt";
	$salted_and_hashed = md5($psw_salt);
	echo "<br>salted and hashed: $salted_and_hashed";



	$ret = register($mysqli, $user, $email, $role, $salted_and_hashed, $salt);



	$i_user = sanitize('gluseppe');
	$device_id = sanitize('iphone123');

	//recupera salt
	$i_salt = db_getField($mysqli, 'user', 'salt', 'user', $i_user, true);
	echo "<br>retrieved salt:$i_salt";


	//$inserted_password = "dblue4innovate";
	$inserted_password = sanitize('123buona');
	//add salt to the inserted password
	$i_psw_salted = $inserted_password.$i_salt;
	echo "<br>inserted_and_salted:$i_psw_salted";
	//hash the result. it will be compared with the entry in the db
	$inserted_salted_and_hashed = md5($inserted_password.$i_salt);
	echo "<br>inserted salted and hashed: $inserted_salted_and_hashed";
	
	//retrieve entry from db	
	$salted_and_hashed_from_db = db_getField($mysqli, 'user', 'hash', 'user', $user, true);
	echo "<br>salted and hashed from db: $salted_and_hashed_from_db";	

	*/



?>