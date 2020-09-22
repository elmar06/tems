<?php
include '../config/clsConnection.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$location = new Location($db);

$location->id = $_POST['id'];
$location->location = $_POST['location'];
$location->code = $_POST['code'];

$upd = $location->upd_location();

	if($upd)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>