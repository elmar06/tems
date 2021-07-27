<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

//check if the tools are for under repair or returned from repair
if($_POST['condition'] == 'Functional')//Retruned from Repair
{
    //update the tool condition
    $asset->id = $_POST['id'];
    $asset->date_returned = date('Y-m-d');
    $asset->repair_remark = $_POST['remarks'];
    $asset->tool_condition = $_POST['condition'];
    $upd = $asset->mark_tool_functional();
    if($upd){
        echo 1;
    }else{
        echo 0;
    }
}
else//status for under repair
{
    //save repair details
    $asset->tool_condition = $_POST['condition'];
    $asset->id = $_POST['id'];
    $asset->date_repair = date('Y-m-d');
    $asset->repair_remark = $_POST['remarks'];
    $save = $asset->mark_tool_under_repair();

    if($save)
    {
        echo 1;
    }
    else
    {
        echo 0;
    }
   
}
?>