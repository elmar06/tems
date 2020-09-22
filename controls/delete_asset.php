<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

$asset->id = $_POST['id'];
$asset->status = 0;

$delete = $asset->delete_asset();

	if($delete)
	{	
		echo 1;
	}
	else
	{
		echo 0;
	}
?>