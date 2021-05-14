<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';
include '../../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);
$asset = new Asset($db);

//update tool records or transactions
$tool->id = $_POST['record_id'];
$tool->returned_by = $_POST['name'];
$tool->date_return = date("Y-m-d", strtotime($_POST['date_return']));
$records = $tool->return_tool();
//update tool status in Asset table
$asset->status = 2;
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