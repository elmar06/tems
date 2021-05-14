<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$worker->worker_id = $_POST['id'];
$worker->fullname = $_POST['fullname'];
$worker->position = $_POST['position'];
$worker->trade = $_POST['trade'];
$worker->project = $_POST['project'];
$worker->status = 1;

$save = $worker->save_worker();

if($save)
{
	echo 1;
}
else
{
	echo 0;
}
?>