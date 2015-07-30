
<?

require_once 'functions.php';


$token_table_create = "CREATE TABLE tokens (
  user varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  device_id varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  authtoken varchar(32) COLLATE utf32_unicode_ci DEFAULT NULL,
  expires timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci";

//$mysqli->query($token_table_create) or die("FAILED: problems with token table creation. Query:$token_table_create");

if ($mysqli->query($token_table_create) === TRUE) echo "<br>tokeb table created";



$user_table_create = "CREATE TABLE `user` (
  `user` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf32_unicode_ci NOT NULL,
  `hash` varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  `salt` varchar(32) COLLATE utf32_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf32_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;";

$mysqli->query($user_table_create) or die("FAILED: problems with token table creation. Query:$user_table_create");


$token_table_primary_keys = "ALTER TABLE `tokens`
 ADD PRIMARY KEY (`user`,`device_id`);";

$mysqli->query($token_table_primary_keys) or die("FAILED: problems with token table creation. Query:$token_table_primary_keys");


$user_table_primary_keys = "ALTER TABLE `user`
 ADD PRIMARY KEY (`user`);";

$mysqli->query($user_table_primary_keys) or die("FAILED: problems with token table creation. Query:$user_table_primary_keys");


echo "All Done. Have fun with itsme";


?>