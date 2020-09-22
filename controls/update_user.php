<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$password = $_POST['password'];

	if($password != "")
	{
		//update the details w/ password
		$user->id = $_POST['id'];
		$user->firstname = $_POST['firstname'];
		$user->lastname = $_POST['lastname'];
		$user->username = $_POST['username'];
		$user->password = md5($_POST['password']);
		$user->access_type = $_POST['access_type'];
		$user->access_cat = $_POST['access_cat'];
		$user->proj_id = $_POST['project'];

		$upd = $user->upd_user();
		if($upd)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
	else
	{
		//update the details w/out password
		$user->id = $_POST['id'];
		$user->firstname = $_POST['firstname'];
		$user->lastname = $_POST['lastname'];
		$user->username = $_POST['username'];
		$user->access_type = $_POST['access_type'];

		$upd = $user->upd_user_detail();
		if($upd)
		{
			echo 2;
		}
		else
		{
			echo 0;
		}
	}
?>