
<?

require_once 'functions.php';


$token_table_create = "CREATE TABLE tokens (
  user varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  device_id varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  authtoken varchar(32) COLLATE utf32_unicode_ci DEFAULT NULL,
  expires timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci";


//$res = $mysqli->query($token_table_create) or die('no no');


//$mysqli->query($token_table_create) or 



if ($mysqli->query($token_table_create) === TRUE) echo "<br>tokeb table created";
else die("FAILED: problems with token table creation. Query:$token_table_create");



$user_table_create = "CREATE TABLE `user` (
  `user` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf32_unicode_ci NOT NULL,
  `hash` varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf32_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;";

if ($mysqli->query($user_table_create) === TRUE) echo "<br>user table created";
else die("FAILED: problems with user table creation. Query:$user_table_create");



$token_table_primary_keys = "ALTER TABLE `tokens`
 ADD PRIMARY KEY (`user`,`device_id`);";

if ($mysqli->query($token_table_primary_keys) === TRUE) echo "<br>token table primary keys";
else die("FAILED: problems with token table primary keys. Query:$token_table_primary_keys");


$user_table_primary_keys = "ALTER TABLE `user`
 ADD PRIMARY KEY (`user`);";

if ($mysqli->query($user_table_primary_keys) === TRUE) echo "<br>user table primary keys";
else die("FAILED: problems with user table primary keys. Query:$user_table_primary_keys");




echo "<h2>All Done. Have fun with itsme</h2>";


?>