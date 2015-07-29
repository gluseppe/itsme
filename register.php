<?
require_once 'functions.php';

/*
RETURN CODES
1: REGISTRATION SUCCESS
2: USERNAME NOT AVAILABLE
3: EMAIL ALREADY REGISTERED
-1: USER OR PASSWORD OR EMAIL EMPTY OR NOT SET


*/


$return_codes = array(
	1 => "REGISTRATION SUCCESS",
	2 => "USERNAME NOT AVAILABLE",
	3 => "EMAIL ALREADY REGISTERED",
	-1 => "USERNAME OR PASSWORD OR EMAIL EMPTY OR NOT SET"
	);



if (isset($_POST['user']) && isset($_POST['password']) && isset($_POST['email']) && !empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['email']))
{
	
	$user = sanitize($_POST['user']);
	$email = sanitize($_POST['email']);
	$password = sanitize($_POST['password']);
	$role = "user";


	//$password = "dblue4innovate";
	$salt = bin2hex(openssl_random_pseudo_bytes(16));
	//echo "<br>salt: $salt";
	$psw_salt = $password.$salt;
	//echo "<br>psw_salt: $psw_salt";
	$salted_and_hashed = md5($psw_salt);
	//echo "<br>salted and hashed: $salted_and_hashed";




	$ret = register($user, $email, $role, $salted_and_hashed, $salt);
	
	$response['RESPONSE CODE'] = $ret;
	$response['CONTEXT'] = "REGISTRATION";
	$response['USER'] = $user;
	//$response['TOKEN'] = $token;
	$response['DESCRIPTION'] = $return_codes[$ret];

	echo json_encode($response);

	//echo json_encode($ret);
	//echo "$ret";



}
else
{
	$ret = -1;
	$response['RESPONSE CODE'] = $ret;
	$response['CONTEXT'] = "REGISTRATION";
	$response['USER'] = $user;
	//$response['TOKEN'] = $token;
	$response['DESCRIPTION'] = $return_codes[$ret];
	echo json_encode($response);

	//echo json_encode(-1);
}








?>