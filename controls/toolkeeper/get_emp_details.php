<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);

if($_POST['emp_code'] == '' || $_POST['emp_code'] == null){
    //get the worker details by name
    $tool->fullname = $_POST['emp_name'];
    $tool->project = $_POST['project'];

    $get = $tool->get_worker_detail_by_name();
    if(!$get)
    {   
        echo json_encode(0);
    }else{
        $array = "";
        while($row = $get->fetch(PDO::FETCH_ASSOC))
        {
            $array = array($row['fullname'], $row['trade'], $row['worker_id']);
        }
        echo json_encode($array);
    }
}else{
    //get worker detail by id number
    $tool->worker_id = $_POST['emp_code'];
    $tool->project = $_POST['project'];

    $get = $tool->get_worker_detail_by_id();
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
}
?>