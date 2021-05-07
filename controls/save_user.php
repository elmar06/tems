<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);

$user->firstname = $_POST['firstname'];
$user->lastname = $_POST['lastname'];
$user->username = $_POST['username'];
$user->password = md5($_POST['password']);
$user->access_type = $_POST['access_type'];
$user->access_cat = $_POST['access_cat'];
$user->proj_id = $_POST['project'];
$user->log_count = 0;
$user->status = 1;

$save = $user->save_user();
	
	if($save)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

?>