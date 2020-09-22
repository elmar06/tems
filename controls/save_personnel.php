<?php
include '../config/clsConnection.php';
include '../objects/clsPersonnel.php';

$database = new clsConnection();
$db = $database->connect();

$personnel = new Personnel($db);

	//get the new id from DATABASE
	$person_id = '';
	$id = $personnel->get_person_id();
	while($row = $id->fetch(PDO::FETCH_ASSOC))
	{
		$person_id = $row['person_id'];
	}

	//SAVE THE DATA TO DATABASE
	$personnel->emp_no = $_POST['emp_no'];
	$personnel->firstname = $_POST['firstname'];
	$personnel->lastname = $_POST['lastname'];
	$personnel->contact_num = $_POST['contact_num'];
	$personnel->status = 1;

	$save = $personnel->save_person();

	if($save)
	{
		echo $person_id;
	}
	else
	{
		echo 0;
	}	
?>