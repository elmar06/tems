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

$tool->project = $_POST['project'];
$tool->tool_id = $_POST['tool_id'];
$tool->tool_code = $_POST['tool_code'];
$tool->tool_desc = $_POST['description'];
$tool->borrow_code = $_POST['borrow_code'];
$tool->borrow_name = $_POST['name'];
$tool->date_borrow = date("Y-m-d H:i:s", strtotime('-1 hour'));
$tool->add_by = $_POST['add_by'];
$asset->status = 3;
$asset->id = $_POST['tool_id'];

//update the asset tb
$update = $asset->upd_tool_stat();

//save in records tb
$save = $tool->borrow_tool();
if($save && $update) 
{
    echo 1;
}
else
{
    echo 0;
}
?>