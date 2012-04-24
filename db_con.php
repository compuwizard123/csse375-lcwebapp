<?php
	function getDBCon()
	{
		$host = "localhost:3306";
		$username = "root";
		$password = "LearningCenter";
		$db_name = "lcwebapp";
		return new mysqli($host, $username, $password, $db_name);
	}
?>