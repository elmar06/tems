<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);

	//get the new id from db
	$cat_id = '';
	$id = $type->get_type_id();
	while($row = $id->fetch(PDO::FETCH_ASSOC))
	{
		$cat_id = $row['type_id'];
	}

	$type->id = $cat_id;
	$type->type = $_POST['type'];
	$type->description = $_POST['description'];
	$type->series_no = 0;
	$type->status = 1;

	$save = $type->save_type();

	if($save)
	{
		echo $cat_id;//echo the for the response
	}
	else
	{
		echo 0;
	}
?>