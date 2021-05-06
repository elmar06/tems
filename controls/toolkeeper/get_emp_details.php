<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);

$tool->worker_id = $_POST['emp_code'];
$tool->project = $_POST['project'];

$get = $tool->get_worker_detail();
if(!$get)
{   
    echo json_encode(0);
}else{
    $array = "";
    while($row = $get->fetch(PDO::FETCH_ASSOC))
    {
        $array = array($row['fullname'], $row['trade']);
    }
    echo json_encode($array);
}

?>