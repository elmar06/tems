<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);

$tool->code = $_POST['code'];

$get = $tool->get_tool_detail();
if(!$get)
{   
    echo json_encode(0);
}else{
    $array = "";
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $array = array($row['description'], $row['brand'], $row['serial'], $row['barcode'], $row['model'], $row['status'], $row['id']);
    }
    echo json_encode($array);
}

?>