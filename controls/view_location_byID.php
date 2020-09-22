<?php
include '../config/clsConnection.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$location = new Location($db);

$location->id = $_POST['id'];
$view = $location->view_loc_byID();

	while($row = $view->fetch(PDO::FETCH_ASSOC))
	{
		echo '
			<div class="form-group">
	          <div class="row">
	            <div class="col-lg-3">
	              <label for="exampleInputEmail1">Project Name</label>
	            </div>
	            <div class="col-lg-9">
	            	<input type="text" class="form-control" id="upd_id_loc" value="'.$row['id'].'" hidden>
	              	<input type="text" class="form-control" id="upd_loc" value="'.$row['location'].'">
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-lg-3">
	              <label for="exampleInputEmail1">Project Code</label>
	            </div>
	            <div class="col-lg-9">
	              	<input type="text" class="form-control" id="upd_code" value="'.$row['code'].'">
	            </div>
	          </div>
	      	</div>';
	}
?>