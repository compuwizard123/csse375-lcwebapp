<?php
	include('db_con.php');
	$con = getDBCon();
	mysql_select_db('lcwebapp', $con);
	$new_username = mysql_real_escape_string($_POST['username']);
	$new_password = md5(mysql_real_escape_string($_POST['password']));
	$new_type = mysql_real_escape_string($_POST['type']);
	$query = "INSERT INTO users (username, password, type) VALUES ('" . $new_username . "','" . $new_password . "','" . $new_type . "')";
	mysql_query($query, $con);
	mysql_close($con);
	header('Location: add_user.html');
?>