<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsPersonnel.php';
include '../objects/clsLocation.php';
include '../objects/clsDepartment.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$person = new Personnel($db);
$location = new Location($db);
$dept = new Department($db);

$asset->id = $_POST['id'];
$view = $asset->get_asset_byID();

	while($row = $view->fetch(PDO::FETCH_ASSOC))
	{
		echo '
			<div class="form-group">
	        <div class="row">
              <div class="col-lg-4">
                <label for="exampleInputEmail1">TRANSFER DETAILS</label>
              </div>
         	</div>
          	<div class="row">
              	<div class="col-lg-4">
	                <label for="exampleInputEmail1">New Assignee Person or Client</label><br>
	                <select type="text" class="form-control" style="width: 100%">';

	                    $view_person = $person->view_person();
	                    while($person_row = $view_person->fetch(PDO::FETCH_ASSOC))
	                    {
	                      echo '<option value='.$person_row['person_id'].'>'.$person_row['fullname'].'</option>';
	                    }

	                echo '</select>
              	</div>
              	<div class="col-lg-4">
	                <label>Date Transfer </label><br>
	                <div class="input-group">
	                  <div class="input-group-prepend">
	                    <span class="input-group-text fa fa-calendar"></span>
	                  </div>
	                  <input type="date" class="form-control">
                	</div>
            	</div>
              	<div class="col-lg-4"> 
	                <label for="exampleInputEmail1">Reason</label>
	                <select type="text" class="form-control" id="t_assigned">
	                  <option>Transfer to Inventory</option>
	                  <option>Transfer from Inventory</option>
	                  <option>Resignee</option>
	                  <option>Transfer to Another Department</option>
	                  <option>Change of Assignee w/in Department</option>
	                  <option>Change of Location</option>
	                  <option>Temporary</option>
	                </select>
              	</div>
          	</div><br>
          	<div class="row">
              	<div class="col-lg-4"> 
	                <label for="exampleInputEmail1">New Location</label><br>
	                <select type="text" class="form-control" style="width: 100%">';

	                      $view_loc = $location->view_loc();
	                      while($loc_row=$view_loc->fetch(PDO::FETCH_ASSOC))
	                      {
	                        echo '<option value='.$loc_row['id'].'>'.$loc_row['location'].'</option>';
	                      }

	                echo '</select>
             	</div>
              	<div class="col-lg-4">
                	<label for="exampleInputEmail1">Quantity</label>
                	<input type="text" class="form-control" id="t_quantity" placeholder="Enter Quantity">
              	</div>
          	</div><hr>
          	<div class="row">
              	<div class="col-lg-12">
                	<label for="exampleInputEmail1">LIST OF ITEM TO TRANSFER</label>
                	<table id="asset_table" class="table table-bordered table-responsive" style="width:100%">
                  	<thead>
                      	<tr>
	                        <th>Barcode</th>
	                        <th width="500px">Description</th>
	                        <th>Asset Type</th>
	                        <th>Location</th>
	                        <th>Current Asignee</th>
	                        <th>Current Department</th> 
                      	</tr>
                  	</thead>
                  	<tbody>';
                  		$fullname = $row['lastname'].', '.$row['firstname']; 
	          			echo '
	            		<tr>
		                    <td>'.$row['barcode'].'</td>
		                    <td>'.$row['description'].'</td>
		                    <td>'.$row['asset_type'].'</td>
		                    <td>'.$row['asset_loc'].'</td>
		                    <td>'.$fullname.'</td>
		                    <td>'.$row['department'].'</td>
	                  	</tr>';
	                echo '</tbody>
                	</table>
              	</div>
          	</div><hr>
          	<div class="row">
	          <div class="col-lg-4">
	            <label for="exampleInputEmail1">PRINT</label>
	          </div>
	        </div>
	        <div class="row">
	          <div class="col-lg-12">
	            <button type="button" class="btn btn-success" disabled>Fixed Asset Transfer</button>
	            <button type="button" class="btn btn-info" disabled>Pull-out Receipt</button>
	          </div>
	        </div>
          	</div>';
	}

?>