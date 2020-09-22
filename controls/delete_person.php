<?php
include '../config/clsConnection.php';
include '../objects/clsPersonnel.php';

$database = new clsConnection();
$db = $database->connect();

$person = new Personnel($db);

$person->id = $_POST['id'];
$person->status = 0;

	$del = $person->del_person();

	if($del)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>