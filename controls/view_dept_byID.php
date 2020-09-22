<?php
include '../config/clsConnection.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);

$dept->id = $_POST['id'];
$view = $dept->view_dept_byID();
	
	while($row = $view->fetch(PDO::FETCH_ASSOC))
	{
		echo '
			<div class="form-group">
	          <div class="row">
	            <div class="col-lg-3">
	              <label for="exampleInputEmail1">Location</label>
	            </div>
	            <div class="col-lg-9">
	              <input type="text" class="form-control" id="upd_dept" value="'.$row['department'].'">
	              <input type="text" class="form-control" id="upd_id_dept" value="'.$row['id'].'" hidden>
	            </div>
	          </div>
	      	</div>';
	}

?>