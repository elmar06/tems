<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

	//uploading the attached image
	$file = $_FILES['files']['name'];
	$path = '/uploads/'.$file;

	$asset->image = $path;
	$check = $asset->check_image_exist();

	while($row = $check->fetch(PDO::FETCH_ASSOC))
	{
		if($row > 0)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}
?>