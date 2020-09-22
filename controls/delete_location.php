<?php
include '../config/clsConnection.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$loc = new Location($db);

$loc->id = $_POST['id'];
$loc->status = 0;

$delete = $loc->del_location();

	if($delete)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>