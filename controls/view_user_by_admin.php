<?php
include '../config/clsConnection.php';
include '../objects/clsUser.php';
include '../objects/clsLocation.php';

$database = new clsConnection();
$db = $database->connect();

$user = new Users($db);
$loc = new Location($db);

$user->id = $_POST['id'];
$view = $user->view_user_byID();

	while($row = $view->fetch(PDO::FETCH_ASSOC))
	{
		echo '
			<div class="form-group">
	          <div class="row">
	            <div class="col-lg-6">
	              <label for="exampleInputEmail1">Firstname</label>
	              <input type="text" class="form-control" id="upd_fname" placeholder="Enter Firstname" value="'.$row['firstname'].'">
	               <input type="text" class="form-control" id="upd_id" placeholder="Enter Firstname" value="'.$row['id'].'" hidden>
	            </div>
	            <div class="col-lg-6">
	              <label for="exampleInputEmail1">Lastname</label>
	              <input type="text" class="form-control" id="upd_lname" placeholder="Enter Lastname" value="'.$row['lastname'].'">
	            </div>
	          </div><br>
	          <div class="row">
	            <div class="col-lg-6">
	              <label for="exampleInputEmail1">Username</label>
	              <input type="text" class="form-control" id="upd_username" placeholder="Enter Firstname" value="'.$row['username'].'" disabled>
	            </div>
	            <div class="col-sm-6">
	              <label>Role:</label><br>
	              <select id="access_type" type="text" class="form-control" style="width: 100%">';
	              if($row['access_type'] == 1)
	              {
                    echo '<option value="0" disabled>Please select a User Role</option>
                          <option value="1" selected>System Administrator</option>
                          <option value="2">Administrator</option>    
                          <option value="3">PMO Officer</option>
                          <option value="4">Kenzo Staff</option>
                          <option value="5">Tool Keeper</option>';
	              }
                  else if($row['access_type'] == 2)
	              {
					echo '<option value="0" disabled>Please select a User Role</option>
                          <option value="1">System Administrator</option>
                          <option value="2" selected>Administrator</option>    
                          <option value="3">PMO Officer</option>
	              		  <option value="4">Kenzo Staff</option>
	              		  <option value="5">Tool Keeper</option>';
	              }
                  else if($row['access_type'] == 3)
	              {
					echo '<option value="0" disabled>Please select a User Role</option>
                          <option value="1">System Administrator</option>
                          <option value="2">Administrator</option>    
                          <option value="3" selected>PMO Officer</option>
	              		  <option value="4">Kenzo Staff</option>
	              		  <option value="5">Tool Keeper</option>';
	              }
                  else if($row['access_type'] == 4)
	              {
					echo '<option value="0" disabled>Please select a User Role</option>
                          <option value="1">System Administrator</option>
                          <option value="2">Administrator</option>    
                          <option value="3">PMO Officer</option>
	              		  <option value="4" selected>Kenzo Staff</option>
	              		  <option value="5">Tool Keeper</option>';
	              }
	              else if($row['access_type'] == 5)
	              {
					echo '<option value="0" disabled>Please select a User Role</option>
                          <option value="1">System Administrator</option>
                          <option value="2">Administrator</option>    
                          <option value="3">PMO Officer</option>
                          <option value="4">Kenzo Staff</option>
                          <option value="5" selected>Tool Keeper</option>';
	              }
	              else
	              {
	              	echo '<option value="0" selected disabled>Please select a User Role</option>
                          <option value="1">System Administrator</option>
                          <option value="2">Administrator</option>    
                          <option value="3">PMO Staff</option>
	              		  <option value="4">Kenzo Staff</option>
	              		  <option value="5">Tool Keeper</option>';
	              }
	              echo' </select>
	            </div>
			  </div>
			  <div class="row">
	            <div class="col-sm-6" id="upd_proj" style="display: none">
	              <label>Project:</label><br>
	              <select type="text" class="form-control js-example-basic-single" id="upd_project" style="width: 100%">';
                  	$view = $loc->view_loc();
                  	while($loc_row=$view->fetch(PDO::FETCH_ASSOC))
                  	{
                  		if($row['proj_id'] == $loc_row['id'])
                  		{
                  			echo '<option value='.$loc_row['id'].' selected>'.$loc_row['location'].'</option>';
                  		}
                  		else
                  		{
                  			echo '<option value='.$loc_row['id'].'>'.$loc_row['location'].'</option>';
                  		}
                  	}
	              echo'</select>
	            </div>
			  </div><br>
	          <div class="row">
	          	<div class="col-lg-6">
	              <label for="exampleInputEmail1">Password</label>
	              <input type="password" class="form-control" id="upd_password" placeholder="Enter Password">
	            </div>
	            <div class="col-lg-6">
	              <label for="exampleInputEmail1">Confirm Password</label>
	              <input type="password" class="form-control" id="upd_password2" placeholder="Confirm Password">
	            </div>
	          </div>
	          <div class="row">
	          	<div class="col-lg-12">
	          		<span style="color:red; font-size:13px">NOTE: Leave the password blank if you dont want to change it.</span>
	          	</div>
	          </div>
	        </div>';	
	}
?>
<!-- hide and show the project input -->
<script>
$(document).ready(function(){
	var access = $('#access_type').val();
	if(access == 3)
	{
		$('#upd_proj').show();
	}
	else
	{
		$('#upd_proj').hide();
	}
})
</script>
<!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();
})
</script>

<!-- UPDATE USER Auto Generate username -->
<script>
$('#upd_lname').blur(function(e){
  e.preventDefault();

  var str = $('#upd_fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#upd_lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var upd_username = f.concat('.').concat(l);
  $('#upd_username').val(upd_username);
})

$('#upd_fname').blur(function(e){
  e.preventDefault();

  var str = $('#upd_fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#upd_lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var upd_username = f.concat('.').concat(l);
  $('#upd_username').val(upd_username);
})	
</script>