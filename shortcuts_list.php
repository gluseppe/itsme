<?
	require_once 'functions.php';

	//request is ok when user token and device id are present and valid in the db
	//if request is valid, sanitized params are returned
	//if request is not valid, the negative response is automatically produced
	//and the rest of the script is not executed
	$params = verifyRequest($_POST);
	if (hasValidToken($params['user'], $params['device_id'], $params['token']))
	{
		$data = array("shortcut1"=>"this is the first shortcut",
			"shortcut2"=>"second shortcut");
		$resp = response(1,"SHORTCUTS_LIST","LIST OF SHORTCUTS",$params['user'],$data);
		echo $resp;
	}
	else 
	{
		$resp = response(2,"SHORTCUTS_LIST","WRONG USERNAME OR PASSWORD",$params['user'],FALSE);
		echo $resp;
	}

?>