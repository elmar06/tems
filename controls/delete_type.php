<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);

	$type->id = $_POST['id'];
	$type->status = 0;

	$delete = $type->delete_type();

	if($delete)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

?>