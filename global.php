<?php

	session_start();

	require_once 'config/settings.php';

	// Establish a MySQLi connection

	$db = new mysqli(DBHOST, DBUSER, DBPASS, DB);

	if ($db->connect_error) {
		header('HTTP/1.0 404 Not Found');
		exit;
	}


?>