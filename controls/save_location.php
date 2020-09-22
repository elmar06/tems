<?php
include '../config/clsConnection.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$loc = new Location($db);

	//get the new id from db
	$loc_id = '';
	$id = $loc->get_loc_id();
	while($row = $id->fetch(PDO::FETCH_ASSOC))
	{
		$loc_id = $row['loc_id'];
	}

	$loc->id = $loc_id;
	$loc->location = $_POST['location'];
	$loc->code = $_POST['code'];
	$loc->status = 1;
	$save = $loc->save_location();

	if($save)
	{
		echo $loc_id;
	}
	else
	{
		echo 0;
	}

?>