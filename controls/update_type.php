<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);

$type->id = $_POST['id'];
$type->type = $_POST['type'];
$type->description = $_POST['description'];

$upd = $type->upd_type();

if($upd)
{
	echo 1;
}
else
{
	echo 0;
}
?>