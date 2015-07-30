<?

	
	//Used during the login process. Called when the given credentials 
	//are correct. It writes the issued token for that user and device id
	//in the tokens table of the database. If something fails during the query
	//it returns FALSE. If an entry for that user and device id is already in the
	//table, it gets updated with the new token and the new expiration time
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

	//Checks if user from device id with given token are on the token table
	//if present it means the user is authenticated. 
	//Call this function on the services/resources that requires an authentication
	//if it returns FALSE respond with access denied. See shortcut_list.php 
	function hasValidToken($user, $device_id, $token) {

		$token_query = "select authtoken from tokens where user='$user' and device_id='$device_id' and authtoken='$token' and expires >= now()";
		if (db_getValue($token_query) != NULL)
			return TRUE;
		else
			return FALSE;

	}


	//this function verifies if the required parameters of a request with authentication data are ok.
	//the parameters are user, token and device_id variables. They must be set and not empty.
	//if one of them is found to be empty or not set, the script dies with related error codes
	//call it before hasValidToken, on success it return all the parameters already sanitized
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



	//Updates the expiration field in the realted entry of the tokens table.
	//use it when an authenticated user shows up and you need to keep alive the authentication for him/her
	function updateExpiration($user, $device_id) {
		global $expiration_time;
		$expiration = time() + $expiration_time;
		$expiration_mysql = date('Y-m-d H:i:s', $expiration);

		$update_query = "update tokens set expires='$expiration_mysql' where user = '$user' and device_id='$device_id'";
		$result = $mysqli->query($update_query);
		if ($result == TRUE)
			return TRUE;

	}

	
	//This function creates a new user with given username, email, role, 
	//the hash of his chosen password concatenated with the salt and the salt
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


	//This is actually a log function not an auth_function
	function log_me($data) {
		file_put_contents("logs.txt", $data."\n",FILE_APPEND);
	}








	


?>