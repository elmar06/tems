<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';
include '../objects/clsLocation.php';
include '../objects/clsLogs.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);
$location = new Location($db);
$log = new Logs($db);

//initialize data
$loc_id = $_POST['proj'];
$type_id = $_POST['cat'];

//update the series number
$log->loc_id = $loc_id;
$log->type_id = $type_id;
$upd = $log->update_logs();

	if($upd)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>