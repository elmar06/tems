<?php
include '../config/clsConnection.php';
include '../objects/clsPersonnel.php';
include '../objects/clsDepartment.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$dept = new Department($db);
$loc = new Location($db);
$personnel = new Personnel($db);

	$personnel->id = $_POST['id'];
	$view = $personnel->view_person_byID();

	while($row = $view->fetch(PDO::FETCH_ASSOC))
	{
		echo'
			<div class="form-group">
		        <div class="row">
		            <div class="col-lg-6">
		              <label for="exampleInputEmail1">Employee No.</label>
		              <input type="text" class="form-control" id="upd_emp_no" placeholder="Enter Employee Number" value="'.$row['emp_no'].'">
		              <input type="text" class="form-control" id="upd_id_no" placeholder="Enter Employee Number" value="'.$row['id'].'" hidden>
		            </div>
		            <div class="col-lg-6">
		              <label for="exampleInputEmail1">Contact Number</label>
		              <input type="text" class="form-control" id="upd_contact_num" placeholder="Enter Contact Number" value="'.$row['contact_num'].'">
		            </div>
		        </div><br>
		        <div class="row">
		            <div class="col-lg-6">
		              <label for="exampleInputEmail1">Firstname</label>
		              <input type="text" class="form-control" id="upd_fname" value="'.$row['firstname'].'">
		            </div>
		            <div class="col-lg-6">
		              <label for="exampleInputEmail1">Lastname</label>
		              <input type="text" class="form-control" id="upd_lname" value="'.$row['lastname'].'">
		            </div>
		        </div><br>
		        <div class="row">
		        	<div class="col-lg-12">
			        	<!-- ALERTS -->
				        <div id="update-warning" class="alert alert-danger" role="alert" style="display: none"></div>
				        <div id="update-success" class="alert alert-success" role="alert" style="display: none"></div>
				    </div>
		        </div>
		    </div>';
	}
?>