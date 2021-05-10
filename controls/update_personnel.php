<?php
include '../config/clsConnection.php';
include '../objects/clsPersonnel.php';

$database = new clsConnection();
$db = $database->connect();

$person = new Personnel($db);

$person->id = $_POST['id'];
$person->emp_no = $_POST['emp_no'];
$person->firstname = $_POST['firstname'];
$person->lastname = $_POST['lastname'];
$person->contact_num = $_POST['contact_num'];
$person->project = $_POST['project'];

	$upd = $person->upd_person();

	if($upd)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>