<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';
include '../../objects/clsLocation.php';
include '../../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);
$loc = new Location($db);
$dept = new Department($db);

$worker->id = $_POST['id'];
$get = $worker->get_worker_data();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
	echo '
		<div class="row">
          <div class="col-sm-12">
            <label for="exampleInputEmail1"><span class="fa fa-barcode"></span> Worker Barcode/ID No.</label>
            <input type="text" class="form-control date-warranty" id="upd_worker-id" placeholder="Worker Barcode No. here" value="'.$row['worker_id'].'"/>
            <input type="text" class="form-control date-warranty" id="upd_id" value="'.$row['work-id'].'" style="display: none"/>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-id-card"></span> Fullname</label>
            <input type="text" class="form-control date-warranty" id="upd_fullname" placeholder="Fullname here" value="'.$row['fullname'].'"/>
          </div>
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-address-card-o"></span> Position</label>
            <input type="text" class="form-control date-warranty" id="upd_position" placeholder="Address here" value="'.$row['position'].'"/>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-wrench"></span> Trade</label>
            <select id="upd_trade" type="text" class="form-control" style="width: 100%">';
                  $view_dept = $dept->view_dept();
                  while($row1 = $view_dept->fetch(PDO::FETCH_ASSOC))
                  {
                  	if($row['trade_id'] == $row1['id'])
                  	{
                  		echo '<option value='.$row1['id'].' selected>'.$row1['department'].'</option>';
                  	}
                    else
                    {
                    	echo '<option value='.$row1['id'].'>'.$row1['department'].'</option>';
                    }
                  }

            echo '</select>
          </div>
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-building"></span> Project</label>
            <select id="upd_project" type="text" class="form-control" style="width: 100%" disabled>';
                  $view_loc = $loc->view_loc();
                  while($row2 = $view_loc->fetch(PDO::FETCH_ASSOC))
                  {
                  	if($row['proj_id'] == $row2['id'])
                  	{
                  		echo '<option value='.$row2['id'].' selected>'.$row2['location'].'</option>';
                  	}
                  	else
                  	{
                  		echo '<option value='.$row2['id'].'>'.$row2['location'].'</option>';
                  	}
                  }

            echo '</select>
          </div>
        </div><br>
        <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>';
}
?>