<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';
include '../../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);
$asset = new Asset($db);

$tool->tool_id = $_POST['tool_id'];
$tool->tool_code = $_POST['tool_code'];
$tool->tool_desc = $_POST['description'];
$tool->borrow_code = $_POST['borrow_code'];
$tool->borrow_name = $_POST['name'];
$tool->date_borrow = date("Y-m-d", strtotime($_POST['date_borrow']));
$asset->status = 2;
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