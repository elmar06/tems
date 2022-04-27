<?php
include '../../config/clsConnection.php';
include '../../objects/clsToolKeeper.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$tool = new ToolKeeper($db);
$worker = new Worker($db);

$tool->tool_id = $_POST['tool_id'];
$tool->tool_code = $_POST['tool_code'];

$check = $tool->check_record();

if(!$check){
    echo json_encode(0);
}else{
    $array = "";
    while($row = $check->fetch(PDO::FETCH_ASSOC))
    {
        //get the worker trade
        $trade = '';
        $worker->worker_id = $row['borrow_code'];
        $get = $worker->view_worker_by_id();
        while($row1 = $get->fetch(PDO:: FETCH_ASSOC))
        {
            $trade = $row1['trade_name'];
            //encode data into array
            $date_barrowed = date("m/d/Y, g:i a", strtotime($row['date_borrow']));
            $array = array($row['id'], $date_barrowed, $row['borrow_code'], $row['borrow_name'], $trade);
        }
    }
    echo json_encode($array);
}

?>