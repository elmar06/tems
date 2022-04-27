<?php
include '../../config/clsConnection.php';
include '../../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

$asset->id = $_POST['id'];
$asset->tool_condition = $_POST['condition'];
$asset->notes = $_POST['notes'];

$upd = $asset->add_remarks();
if($upd){
    echo 1;
}else{
    echo 0;
}
?>