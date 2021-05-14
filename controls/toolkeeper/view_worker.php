<?php
session_start();
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$worker->project = $_SESSION['project-id'];
$view = $worker->view_worker();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
  echo '
  <tr>
    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['work-id'].'" style="max-width: 30px;"></td>
    <td>'.$row['worker_id'].'</td>
    <td>'.$row['fullname'].'</td>
    <td>'.$row['position'].'</td>
    <td><center>'.$row['trade_name'].'</center></td>
    <td><center>'.$row['proj_name'].'</center></td>
    <td style="width:20%"><center><a class="edit-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
  </tr>';
}
?>