<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsRecord.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$record = new TransferRecord($db);

//get the last transfer id in transfer table
$get_id = $record->get_last_transfer_id();
while($row = $get_id->fetch(PDO::FETCH_ASSOC))
{
	$transfer_id = $row['transfer_id'];
	if($transfer_id == null)
	{
		$transfer_id = 1;
	}
}

//get all data from asset to be transfer
$asset->id = $_POST['id'];
$get_details = $asset->get_asset_byID();
while($row1 = $get_details->fetch(PDO::FETCH_ASSOC))
{
	$oldAssignee = $row1['assign'];
	$price = $row1['price'];
}

//update the asset with the new assignee
$asset->id = $_POST['id'];
$asset->assign = $_POST['assign'];
$asset->date_transfer = date("Y-m-d H:i:s", strtotime($_POST['date_transfer']));
$asset->project = $_POST['location'];
$asset->quantity = $_POST['quantity'];

//save the details of transfer
$record->transfer_id = $transfer_id;
$record->to_id = $_POST['assign'];
$record->from_id = $oldAssignee;
$record->asset_id = $_POST['id'];
$record->quantity = $_POST['quantity'];
$record->price = $price;
$record->reason = $_POST['reason'];
$record->transfer_date = date("Y-m-d H:i:s", strtotime($_POST['date_transfer']));

$record_detail = $record->save_transfer_record();
$transfer = $asset->transfer_asset();

	if($transfer)
	{
		if($record_detail)
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