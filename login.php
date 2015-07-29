<?
require_once 'functions.php';
$response = array(
	"RESPONSE CODE" => "",
	"CONTEXT" => "",
	"DESCRIPTION" => "",
	"USER" => "",
	"TOKEN" => "");

	
	
	if (isset($_POST['user']) && isset($_POST['password']) && isset($_POST['device_id']) && !empty($_POST['user']) && !empty($_POST['password']) && !empty($_POST['device_id']))
	{
	
		
		$user = sanitize($_POST['user']);
		$device_id = sanitize($_POST['device_id']);

		//recupera salt
		$salt = db_getField('user', 'salt', 'user', $user, true);



		//echo "<br>retrieved salt:$salt";

		//$inserted_password = "dblue4innovate";
		$inserted_password = sanitize($_POST['password']);
		//add salt to the inserted password
		$i_psw_salted = $inserted_password.$salt;
		//echo "<br>inserted_and_salted:$i_psw_salted";
		//hash the result. it will be compared with the entry in the db
		$inserted_salted_and_hashed = md5($inserted_password.$salt);
		//echo "<br>inserted salted and hashed: $inserted_salted_and_hashed";
	
		//retrieve entry from db	
		$salted_and_hashed_from_db = db_getField('user', 'hash', 'user', $user, true);
		//echo "<br>salted and hashed from db: $salted_and_hashed_from_db";	
		if ($inserted_salted_and_hashed == $salted_and_hashed_from_db)
		{
			//log_me("generating token\n");
			$token = bin2hex(openssl_random_pseudo_bytes(16));
			//store token in db for user
			if (writeToken($token, $user, $device_id)) {
			//share token

				$response['RESPONSE CODE'] = 1;
				$response['CONTEXT'] = "LOGIN";
				$response['USER'] = $user;
				$response['TOKEN'] = $token;
				$response['DESCRIPTION'] = "USER LOGGED";
	
				echo json_encode($response);

			}
			else {
				$response['RESPONSE CODE'] = -1;
				$response['CONTEXT'] = "LOGIN";
				$response['USER'] = $user;
				$response['TOKEN'] = "";
				$response['DESCRIPTION'] = "FAILED - PROBLEMS WHEN WRITING AUTHENTICATION INFORMATION";
	
				echo json_encode($response);

			}
			//echo "ok|$user|".$token;

			//log_me("ok|$user|".$token);

		}
		else
		{
			//wrong user name and/or password
			$response['RESPONSE CODE'] = 2;
			$response['CONTEXT'] = "LOGIN";
			$response['USER'] = $user;
			$response['TOKEN'] = -1;
			$response['DESCRIPTION'] = "WRONG USER NAME AND OR PASSWORD";

			echo json_encode($response);

		}
	}
	else
	{
		//wrong user name and/or password
			$response['RESPONSE CODE'] = -1;
			$response['CONTEXT'] = "LOGIN";
			$response['USER'] = $user;
			$response['TOKEN'] = -1;
			$response['DESCRIPTION'] = "INPUT DATA MISSING, REQUEST FAILED";

			echo json_encode($response);
	}
	
	

	

	


?>