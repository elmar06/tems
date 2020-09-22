<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsType.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$type = new Type($db);

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
$asset->status = 1;
//update the series_no of category/type
$type->id = $_POST['category'];
$upd = $type->upd_series_no();

	//save asset
	$save = $asset->save_asset();
	if($save)
	{
		if($upd)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}		
	}
	else
	{
		echo 0;
	}
?>