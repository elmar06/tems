<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsRepairHistory.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$repair = new RepairHistory($db);

//check if the tools are for under repair or returned from repair
if($_POST['condition'] == 'Functional')//Retruned from Repair
{
    //get the date repair of tools
    $date_repair = '';
    $asset->id = $_POST['id'];
    $get = $asset->get_asset_under_repair();
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $date_repair = $row['date_repair'];
    }
    //update the tool condition
    $asset->id = $_POST['id'];
    $asset->date_return = date('Y-m-d');
    $asset->repair_remark = $_POST['remarks'];
    $asset->tool_condition = $_POST['condition'];
    $upd = $asset->mark_tool_functional();
    //save repair details in table repair
    $repair->asset_id = $_POST['id'];
    $repair->date_repair = $date_repair;
    $repair->date_returned = date('Y-m-d');
    $repair->remarks = $_POST['remarks'];
    $save = $repair->save_repair_history();

    if($upd){
        if($save){
            echo 1;
        }else{
            echo 0;
        }
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