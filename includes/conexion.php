<?php

function conectar () {
	
	$db_con = mysqli_connect (DB_SERVER,DB_USER,DB_PASS);
	if (!$db_con) return false; 
	if (!mysqli_select_db ($db_con, DB_NAME)) return false;
	return $db_con; 

}

?>