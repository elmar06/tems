<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';
include '../../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);
$asset = new Asset($db);

//get the Manila time by timezone
date_default_timezone_set('Asia/Manila');

//update tool records or transactions
$tool->id = $_POST['record_id'];
$tool->returned_by = $_POST['name'];
$tool->date_return = date("Y-m-d H:i:s", strtotime('-1 hour'));
$records = $tool->return_tool();
//update tool status in Asset table
$asset->status = 1;
$asset->id = $_POST['tool_id'];
$upd = $asset->upd_tool_stat();

if($records)
{
    echo 1;
}
else
{
    echo 0;
}
?>