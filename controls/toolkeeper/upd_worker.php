<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$worker->id = $_POST['id'];
$worker->worker_id = $_POST['worker_id'];
$worker->fullname = $_POST['fullname'];
$worker->position = $_POST['position'];
$worker->trade = $_POST['trade'];
$worker->project = $_POST['project'];

$upd = $worker->update_worker();

if($upd)
{
	echo 1;
}
else
{
	echo 0;
}

?>