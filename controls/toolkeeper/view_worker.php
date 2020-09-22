<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$view = $worker->view_worker();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
  echo '
  <tr>
    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'" style="max-width: 30px;"></td>
    <td>'.$row['worker_id'].'</td>
    <td>'.$row['fullname'].'</td>
    <td>'.$row['trade_name'].'</td>
    <td>'.$row['proj_name'].'</td>
    <td style="width:20%"><center><a class="edit-user" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-user" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
  </tr>';
}
?>