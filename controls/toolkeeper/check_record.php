<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);

$tool->tool_id = $_POST['tool_id'];
$tool->tool_code = $_POST['tool_code'];

$check = $tool->check_record();
if(!$check){
    echo json_encode(0);
}else{
    $array = "";
    while($row = $check->fetch(PDO::FETCH_ASSOC))
    {
        $date_barrowed = date("m/d/Y", strtotime($row['date_borrow']));
        $array = array($row['id'], $date_barrowed, $row['borrow_code'], $row['borrow_name']);
    }
    echo json_encode($array);
}

?>