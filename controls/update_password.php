<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$command = $_POST['command'];

	if($command > 0)
	{
		$user->id = $_POST['id'];
		$user->password = md5($_POST['password']);

		$upd = $user->upd_pass();

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
		$user->id = $_POST['id'];
		$upd = $user->upd_pass_later();

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