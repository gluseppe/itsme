	<?

	function log_me($data) {
		file_put_contents("surveylog.txt", $data."\n",FILE_APPEND);
	}


	
	function writeToken($token, $user, $device_id) {
		global $expiration_time;
		global $mysqli;
		
		$now = time();
		$expiration = $now + $expiration_time;
		$expiration_mysql = date('Y-m-d H:i:s', $expiration);
		//echo "<br>now:$now   -   expiration: $expiration - exp_mysql:$expiration_mysql";

		$update_query = "insert into tokens (user, device_id, authtoken, expires)
		values('$user','$device_id','$token','$expiration_mysql')
		on duplicate key update expires='$expiration_mysql', authtoken='$token'";
		//echo "$update_query";
		$result = $mysqli->query($update_query);
		if ($result == TRUE)
			return TRUE;
		else return FALSE;

	}


	function hasValidToken($user, $device_id, $token) {

		$token_query = "select authtoken from tokens where user='$user' and device_id='$device_id' and authtoken='$token' and expires >= now()";
		if (db_getValue($token_query) != NULL)
			return TRUE;
		else
			return FALSE;

	}

	function verifyRequest($post_array) {

		$return_codes = array(
			1 => "SUCCESS",
			2 => "USERNAME NOT AVAILABLE",
			3 => "EMAIL ALREADY REGISTERED",
			-1 => "USERNAME OR PASSWORD OR EMAIL EMPTY OR NOT SET"
		);

		
		if (isset($post_array['user']) && isset($post_array['token']) && isset($post_array['device_id']) && 
		!empty($post_array['user']) && !empty($post_array['token']) && !empty($post_array['device_id'])) {

			foreach ($post_array as $key => $value) {
				$post_array[$key] = sanitize($value);				
			}

			return $post_array;

			
			
		} 
		else
		{
			$response = array(
			"RESPONSE CODE" => 2,
			"CONTEXT" => "AUTHENTICATION",
			"DESCRIPTION" => $return_codes[-1],
			"USER" => "",
			"DATA" => FALSE);
			die(json_encode($response));
		}
		

	}



	//UPDATE
	function updateExpiration($user, $device_id) {
		global $expiration_time;
		$expiration = time() + $expiration_time;
		$expiration_mysql = date('Y-m-d H:i:s', $expiration);

		$update_query = "update tokens set expires='$expiration_mysql' where user = '$user' and device_id='$device_id'";
		$result = $mysqli->query($update_query);
		if ($result == TRUE)
			return TRUE;

	}

	

	function register($user, $email, $role, $salted_and_hashed, $salt) {

		global $mysqli;
		$now = time();


		if (db_rowExists('user', 'user', $user, TRUE))
			return 2;

		

		if (db_rowExists('user', 'email', $email, TRUE))
			return 3;

		


		$register_query = "insert into user (user, email, role, hash, salt) values ('$user', '$email', '$role', '$salted_and_hashed', '$salt')";
		$result = $mysqli->query($register_query);

		if ($result == TRUE)
			return 1;
		else {
			echo "query not good";
			return FALSE;
		}


	}






	


?>