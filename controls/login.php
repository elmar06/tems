<?php
session_start();
	include "../config/clsConnectionMain.php";
	include "../objects/clsUser.php";

	$databaseMain = new clsConnectionMain();
	$dbMain = $databaseMain->connectMain();

	$user = new Users($dbMain);

	$user->username = $_POST['username'];
	$user->password = md5($_POST['password']);
	$user->admin_pass = md5($_POST['password']);
	$user->status = 0;

	$login = $user->login();

	if($row = $login->fetch(PDO::FETCH_ASSOC))
	{
		$_SESSION['id'] = $row['id'];
		$_SESSION['fullname'] = $row['firstname'].' '.$row['lastname'];
		$_SESSION['firstname'] = $row['firstname'];
		$_SESSION['lastname'] = $row['lastname'];
		$_SESSION['username'] = $row['username'];
		$_SESSION['logcount'] = $row['logcount'];
		$_SESSION['dept-id'] = $row['dept'];
		$_SESSION['email'] = $row['email'];
		echo 1;
	}
	else
	{
		echo 0;
	}
?>