<?php
include '../config/clsConnection.php';
include '../objects/clsPersonnel.php';

$database = new clsConnection();
$db = $database->connect();

$personnel = new Personnel($db);

	//SAVE THE DATA TO DATABASE
	$personnel->emp_no = $_POST['emp_no'];
	$personnel->firstname = $_POST['firstname'];
	$personnel->lastname = $_POST['lastname'];
	$personnel->contact_num = $_POST['contact_num'];
	$personnel->project = $_POST['project'];

	$save = $personnel->save_person();

	if($save)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}	
?>