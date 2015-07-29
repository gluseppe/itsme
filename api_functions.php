<?
	
	function response($response_code, $context, $description, $user, $data) {



		$response = array(
			"RESPONSE CODE" => $response_code,
			"CONTEXT" => $context,
			"DESCRIPTION" => $description,
			"USER" => $user,
			"DATA" => $data);

		return json_encode($response);

	}


?>