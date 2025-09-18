<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsTransfer.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$transfer = new TransferRecord($db);

//get the last transfer id in transfer table
$get_id = $transfer->get_last_transfer_id();
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
$project = '';
while($row1 = $get_details->fetch(PDO::FETCH_ASSOC))
{
	$oldAssignee = $row1['assign'];
	$price = $row1['price'];
	$cur_proj = $row1['project'];
}

//update the asset with the new assignee
$asset->id = $_POST['id'];
$asset->assign = $_POST['assign'];
$asset->date_transfer = date("Y-m-d H:i:s", strtotime($_POST['date_transfer']));
$asset->project = $_POST['location'];
$asset->quantity = $_POST['quantity'];
$asset->trade = $_POST['department'];

//save the details of transfer
$transfer->transfer_id = $transfer_id;
$transfer->to_id = $_POST['assign'];
$transfer->from_id = $oldAssignee;
$transfer->asset_id = $_POST['id'];
$transfer->quantity = $_POST['quantity'];
$transfer->price = $price;
$transfer->reason = $_POST['reason'];
$transfer->cur_proj = $cur_proj;
$transfer->new_proj = $_POST['location'];
$transfer->transfer_date = date("Y-m-d H:i:s", strtotime($_POST['date_transfer']));

$transfer_detail = $transfer->save_transfer_record();
$transfer = $asset->transfer_asset();

	if($transfer)
	{
		if($transfer_detail)
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