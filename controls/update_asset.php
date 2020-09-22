<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

$asset->id = $_POST['id'];
$asset->description = $_POST['description'];
$asset->specs = $_POST['specification'];
$asset->project = $_POST['project'];
$asset->category = $_POST['category'];
$asset->code = $_POST['code'];
$asset->trade = $_POST['trade'];
$asset->brand = $_POST['brand'];
$asset->barcode = $_POST['barcode'];
$asset->quantity = $_POST['quantity'];
$asset->price = $_POST['price'];
$asset->date_warranty = date("Y-m-d H:i:s", strtotime($_POST['date_warranty']));
$asset->serial = $_POST['serial'];
$asset->model = $_POST['model'];
$asset->tool_condition = $_POST['condition'];
$asset->assign = $_POST['assign_person'];
$asset->date_transfer = date("Y-m-d H:i:s", strtotime($_POST['date_transfer']));
$asset->notes = $_POST['notes'];

$update = $asset->update_asset();

	if($update)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
?>