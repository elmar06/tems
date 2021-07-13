<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>AMS Tools + Equipment</title>
  <!-- DataTables -->
  <link rel="stylesheet" href="../../components/dataTables/css/dataTables.bootstrap.min.css">
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../components/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../components/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="../../components/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/Innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php 
    include '../../includes/admin_header.php'; 
  ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div>
                <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#newPersonnelModal"><i class="fa fa-print"></i>Generate Report</button>
              </div><br>
              <table id="personnel_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th><center>Tool Code</center></th>
                      <th style="max-width: 150px;"><center>Description</center></th>
                      <th><center>From</th>
                      <th><center>To</center></th>
                      <th><center>Current Project</center></th>
                      <th><center>New Project</center></th>
                      <th><center>Date</center></th>
                    </tr>
                </thead>
                <tbody id="transfer-body">
                  <?php
                    $get_record = $records->view_transfer_records();
                    while($row1 = $get_record->fetch(PDO::FETCH_ASSOC))
                    {
                      $transfer_reason = $row1['reason'];
                      $transfer_date = $row1['transfer_date'];
                      $date = date('m/d/Y', strtotime($transfer_date));
                      $code = '';
                      $desc = '';
                      $from = '';
                      $to = '';
                      $cur_proj = '';
                      $new_proj = '';
                      //get the tool details
                      $asset->id = $row1['asset_id'];
                      $get = $asset->get_asset_byID();
                      while($tool = $get->fetch(PDO::FETCH_ASSOC))
                      {
                        $code = $tool['code'];
                        $desc = $tool['description'];
                      }
                      //get the old assignee name
                      $person->id = $row1['from_id'];
                      $view = $person->get_person_name();
                      while($from_row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        $from = $from_row['firstname'].' '.$from_row['lastname'];
                      }
                      //get the new assignee name
                      $person->id = $row1['to_id'];
                      $view = $person->get_person_name();
                      while($to_row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        $to = $to_row['firstname'].' '.$to_row['lastname'];
                      }
                      //get the current location
                      $loc->id = $row1['cur_proj'];
                      $curProj = $loc->view_loc_byID();
                      while($curRow = $curProj->fetch(PDO::FETCH_ASSOC))
                      {
                        $cur_proj = $curRow['location'];
                      }
                      //get the new location
                      $loc->id = $row1['new_proj'];
                      $newProj = $loc->view_loc_byID();
                      while($newRow = $newProj->fetch(PDO::FETCH_ASSOC))
                      {
                        $new_proj = $newRow['location'];
                      }

                       echo 
                        '<tr>
                          <td>'.$code.'</td>
                          <td style="max-width: 150px;">'.$desc.'</td>
                          <td>'.$from.'</td>
                          <td>'.$to.'</td>
                          <td>'.$cur_proj.'</td>
                          <td>'.$new_proj.'</td>
                          <td>'.$date.'</td>
                        </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- end of row -->
  </div><!-- end of container-fluid -->
</div><!-- end of container-scroller -->

<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="container-fluid clearfix">
    <center><span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.innogroup.com.ph/" target="_blank">Innoland Development Corporation</a>. All rights reserved.</span>
    </span></center>
  </div>
</footer>

<!-- MODALS SECTION -->
<!-- NEW PERSONNEL/CLIENT MODAL -->
<div class="modal fade" id="newPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> Add New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-lg-6">
              <label for="exampleInputEmail1">Firstname</label>
              <input type="text" class="form-control" id="fname" placeholder="Enter Firstname">
            </div>
            <div class="col-lg-6">
              <label for="exampleInputEmail1">Lastname</label>
              <input type="text" class="form-control" id="lname" placeholder="Enter Lastname">
            </div>
          </div><br>
          <div class="row">
            <div class="col-lg-6">
              <label for="exampleInputEmail1">Username</label>
              <input type="text" class="form-control" id="username" placeholder="Enter Firstname" disabled>
            </div>
            <div class="col-lg-6">
              <label for="exampleInputEmail1">Password</label>
              <input type="password" class="form-control" id="password" placeholder="Enter Lastname" value="123456" disabled>
            </div>
          </div><br>
          <div class="row">
            <div class="col-sm-6">
              <label>Role:</label><br>
              <select id="RoleType" type="text" class="form-control" style="width: 100%">
                <option value="0" selected disabled>Please select a User Role</option>
                <option value="4">Kenzo Staff</option>
                <option value="5">Tool Keeper</option>
              </select>
            </div>
          </div>
           <div class="row" style="display: none" id="proj_div">
            <div class="col-sm-6"><br>
              <label>Project/Building:</label><br>
              <select type="text" class="form-control js-example-basic-single" id="project" style="width: 100%">
                <option value="0" selected disabled>Please select Project</option>
                <?php
                  $loc->status = 0;
                  $view = $loc->view_loc();
                  while($row=$view->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['location'].'</option>';
                  }
                ?>
              </select>
            </div>
          </div>
        </div><!-- end of form-group -->
        <!-- ALERTS -->
        <div id="save-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        <div id="save-success" class="alert alert-success" role="alert" style="display: none"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_user" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT PERSONNEL/CLIENT MODAL -->
<div class="modal fade" id="editUserModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-edit"></span> Edit User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="edit-user-body" class="modal-body">
      
        
      </div><!-- end of modal body -->
        <!-- ALERTS -->
      <div class="row">
        <div class="col-lg-12">
          <span id="pass_alert" class="alert"></span>
          <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>
          <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="upd_user" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <!-- data tables -->
  <script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
  <!-- plugins:js -->
  <script src="../../components/js/vendor.bundle.base.js"></script>
  <script src="../../components/js/vendor.bundle.addons.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <!-- select2 plugin -->
  <script src="../../components/select2/select2.min.js"></script>
  <!-- End custom js for this page-->

<!-- show the project option if tool keeper is selected -->
<script>
$('#RoleType').change(function(){
  var role = $(this).val(); 
  if(role == 3)
  {
    $('#proj_div').show();
  }
  else
  {
    $('#proj_div').hide();
  }
})
</script>

<!-- CHECK IF PASSWORD MATCH IN UPDATE USER DETAILS -->
<script>
$('#upd_password2').keyup(function(){
  var pass = $('#upd_password').val();
  var pass2 = $(this).val();
  //alert(pass);
  if(pass != pass2)
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
  }
  else
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:green'>Password match</label>";
  }
})
</script>

<!-- SAVE USER FUNCTION -->
<script>
$('#save_user').click(function(e){
  e.preventDefault();

  var firstname = $('#fname').val();
  var lastname = $('#lname').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var role = $('#RoleType').val();
  var project = $('#project').val();
  var myData = 'firstname=' + firstname + '&lastname=' + lastname + '&username=' + username + '&password=' + password + '&access_type=' + role + '&project=' + project;

  if(firstname != "" && lastname != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/save_user.php",
      data: myData,

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          $('#save-success').html("<center><i class='fa fa-check menu-icon'></i> User successfully added.</center>");
          $('#save-success').show().fadeOut(5000);

          //page will reload after 2 seconds if success
          setTimeout(function(){
            location.reload();
          }, 1000)
        }
        else
        {
          $('#save-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the system administrator.</center>");
          $('#save-warning').show().fadeOut(5000);
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
  else
  {
    $('#save-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the field needed.</center>");
    $('#save-warning').show().fadeOut(5000);
  }
})
</script>

<!-- UPDATE USERS FUNCTION -->
<!-- GET THE DATA OF USERS BY ID -->
<script>
$('.edit-user').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  $.ajax({
    type: "POST",
    url: "../../controls/view_user_byID.php",
    data: {id: id},

    success: function(html)
    {
      $('#editUserModal').modal('show');
      $('#edit-user-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//SAVE USER UPDATE FUNCTION
$('#upd_user').click(function(e){
  e.preventDefault();

  var id = $('#upd_id').val();
  var firstname = $('#upd_fname').val();
  var lastname = $('#upd_lname').val();
  var access = $('#access_type').val();
  var cat = $('#access_cat').val();
  var project = $('#upd_project').val();
  var username = $('#upd_username').val();
  var password = $('#upd_password').val();
  var password2 = $('#upd_password2').val();
  var myData = 'id=' + id + '&firstname=' + firstname + '&lastname=' + lastname + '&username=' + username + '&access_type=' + access + 'access_cat='+ cat + '&project=' + project + '&password=' + password;

  if(password == password2)
  {
    $.ajax({
      type: "POST",
      url: "../../controls/update_user.php", 
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          $('#upd-success').html("<center><i class='fa fa-check menu-icon'></i> User details successfully updated.</center>");
          $('#upd-success').show().fadeOut(5000);

          setTimeout(function(){
            location.reload();
          }, 1000)
        }
        else
        {
          $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the system administrator.</center>");
          $('#upd-warning').show().fadeout(5000);
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
  else
  {
    $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Password not match. Please try again.</center>");
    $('#upd-warning').show().fadeOut(5000);
    return false;
  }
}) 
</script>

<!-- DELETE USER FUNCTION -->
<script>
$('.delete-user').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');

  if(confirm('WARNING! Are you sure you want to remove this user in the list?'))
  {
    $.ajax({
      type: "POST",
      url: "../../controls/delete_user.php",
      data: {id: id},

      success: function(response)
      {
        alert(response);
        if(response > 0)
        {
          alert('User successfully removed!');
          location.reload();
        }
        else
        {
          alert('ERROR! Remove Failed. Please contact the system administrator for assistance.');
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
})
</script>

<!--ADD-USER Auto Generate username based in input details -->
<script>
$('#lname').blur(function(e){
  e.preventDefault();

  var str = $('#fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#username').val(username);
})

$('#fname').blur(function(e){
  e.preventDefault();

  var str = $('#fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#username').val(username);
})
</script>

<!-- checkbox functions -->
<script>
$('#checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
      if(selected.length > 1)
      {
        $('#btndelete').show();
        $('.delete-user').hide();
        $('.edit-user').hide();
      }
      else
      {
        $('#btndelete').hide();
        $('.delete-user').show();
        $('.edit-user').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit-user').show();
      $('.delete-user').show();
      $('#btndelete').hide();
    });
  }
});

//checklist functions
$(document).on('change', '.checklist', function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
  if(selected.length > 1)
  {
    //$('.delete_type').show();
    $('#btndelete').show();
    $('.delete-user').hide();
    $('.edit-user').hide();
  }
  else
  {
    $('#btndelete').hide();
    $('.delete-user').show();
    $('.edit-user').show();
  }
});
</script>

<!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();
})
</script>

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable()({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
</body>
</html>