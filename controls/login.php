<?php
session_start();

	include "../config/clsConnection.php";
	include "../objects/clsUser.php";

	$database = new clsConnection();
	$db = $database->connect();

	$user = new Users($db);

	$user->username = $_POST['uname'];
	$user->password = md5($_POST['pword']);
	$user->status = 0;

	$login = $user->login();

	if($row = $login->fetch(PDO::FETCH_ASSOC))
	{
		$_SESSION['fullname'] = $row['fullname'];
		$_SESSION['firstname'] = $row['firstname'];
		$_SESSION['lastname'] = $row['lastname'];
		$_SESSION['log_count'] = $row['log_count'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['access_type'] = $row['access_type'];

		echo 1;
	}
	else
	{
		echo 0;
	}
?>