<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->id = $_POST['id'];
$dept->status = 0;

$del = $dept->del_dept();

	if($del)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}

?>