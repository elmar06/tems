<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db  = $database->connect();

$worker = new Worker($db);

$worker->id = $_POST['id'];
$worker->status = 0;

$del = $worker->delete_worker();

	if($del)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>