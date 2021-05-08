<?php
	session_start();
	include '../config/clsConnection.php';
	include '../objects/clsUser.php';

	$database = new clsConnection();
	$db = $database->connect();

	$user = new Users($db);

	$user->username = $_SESSION['username'];
	$user->status = 0;
	$get = $user->get_access();

	if($row = $get->fetch(PDO::FETCH_ASSOC))
	{
		$access_type = $row['access_type'];
		if($access_type == '1')
		{
			header('Location: ../pages/superadmin/home.php');
		}
		else if($access_type == '2')
		{
			header('Location: ../pages/admin/home.php');
		}
		else if($access_type == '3')
		{
			header('Location: ../pages/pmo/home.php');
		}
		else if($access_type == '4')
		{
			header('Location: ../pages/kenzo/home.php');
		}
		else
		{
			header('Location: ../pages/tool-keeper/home.php');
		}
		$id = $row['id'];
	}
	else
	{
		header('Location: ../index.php');
	}
	$_SESSION['id'] = $id;
?>
