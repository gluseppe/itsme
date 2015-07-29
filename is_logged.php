<?
require_once 'functions.php';
//global $mysqli;

	
	if (isset($_POST['token']) && isset($_POST['user']) && isset($_POST['device_id'])) {
	
		$token = sanitize($_GET['token']);
		$user = sanitize($_GET['user']);

		//log_me("$role - $token - $user");
		//echo "about to check login";
		if (isLoggedIn($mysqli, $user, $token, $device_id))
		{
			echo "ok";
		}
		else
			echo "no";
	}

?>