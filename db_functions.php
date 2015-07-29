<?


	function sanitize($str) {

		return filter_var($str, FILTER_SANITIZE_STRING);
	}


	function db_connect($mysql_host, $mysql_user, $mysql_psw, $mysql_db) {
	
		$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_psw, $mysql_db);
	
		if (mysqli_connect_errno()) return false;
		else 
	        return $mysqli;	       
	}


	//return a result you didn t know the length of
	//please sanitize parameteres BEFORE the call
	function db_query($query) {
		global $mysqli;

	}

	//use it to get a single value from a table
	//please sanitize parameteres BEFORE the call
	function db_getValue($query) {
		global $mysqli;

		$result = $mysqli->query($query);
		//echo $query;
		if($result->num_rows > 0) {
			$ret = 0;
			while ($row = $result->fetch_row()) {
				return $row[0];
			}
		}
		else {
			return NULL;
		}

	}


	
	//check existence of at least one row in $table having  $field = $match
	//$match will be sanitized inside the function. returns true if at least 1 row exists
	//false otherwhise
	function db_rowExists($table, $field, $match, $isStr) {
		global $mysqli;
		$match = sanitize($match);
		$query = "";
		if ($isStr)
			$query = "SELECT * from $table where $field = '$match'";
		else
			$query = "SELECT * from $table where $field = $match";



		$result = $mysqli->query($query);
		if ($result == false)
			return false;
		else
			return ($result->num_rows);
	}

	function db_getField($table, $field, $condition_field, $match, $conditionOnStr) {
		global $mysqli;
		$match = sanitize($match);
		$query = "";
		if ($conditionOnStr)
			$query = "SELECT $field from $table where $condition_field = '$match'";
		else
			$query = "SELECT * $field $table where $condition_field = $match";

		//echo "<br>$query<br>";


		$result = $mysqli->query($query);
		if ($result == false)
			return false;
		else
		{
			$ret = false;
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$ret = $row[$field];
			}
			return $ret;
		}
	}

	function db_saveRow($table, $field_list, $value_list, $string_list) {
		global $mysqli;
		if ((count($field_list) != count (value_list)) || (count($field_list) != count(string_list))) {
			return NULL;
		}
		else
		{
			$fields = implode(",", $field_list);
			$values = implodeValues($value_list,$string_list);
			$query = "insert into $table ($fields) values($values)";
			echo "<br>insert query: $query";
		}

	}

	function implodeValues($value_list,$string_list) {
		global $mysqli;
		if (count($value_list) != count($string_list)) return NULL;
		$values = "";
		for ($i=0; $i < count($value_list); $i++) { 
			if ($string_list[i]==true) {
				$values = $values.",'".$value_list[i]."'";
			}
			else
			{
				$values = $values.",".$value_list[i];

			}
		}

		return $values;
	}

	$mysqli = db_connect($mysql_host, $mysql_user, $mysql_psw, $mysql_db);
?>