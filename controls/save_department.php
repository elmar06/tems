<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);
	//GET THE NEW ID
	$dept_id = "";
	$id = $dept->get_dept_id();
	while($row = $id->fetch(PDO::FETCH_ASSOC))
	{
		$dept_id = $row['dept_id'];
	}

	//SAVE THE DATA TO DATABASE
	$dept->id = $dept_id;
	$dept->department = $_POST['department'];
	$dept->status = 1;
	$save = $dept->save_dept();

	if($save)
	{
		echo $dept_id;
	}
	else
	{
		echo 0;
	}
?>