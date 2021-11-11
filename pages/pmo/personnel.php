<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>AMS Tools + Equipment</title>
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
  <!-- DataTables -->
  <link rel="stylesheet" href="../../components/dataTables/css/dataTables.bootstrap.min.css">

</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php include '../../includes/pmo_header.php'; ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div>
                <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#newPersonModal"><i class="fa fa-plus"></i>New Personnel/Client</button>
                <a href="personnel.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                <button type="button" class="btn btn-dark btn-rounded" style="display: none" id="btndelete"><i class="fa fa-trash-o"></i>Delete</button>
              </div><br>
              <table id="personnel_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th style="width:10%"><center><input type="checkbox" id="checkboxall"></center></th>
                      <th>Employee No.</th>
                      <th>Firstname</th>
                      <th>Lastname</th>
                      <th>Contact No.</th>
                      <th style="width:20%"><center>Action</center></th>
                    </tr>
                </thead>
                <tbody id="location-body">
                  <?php
                    $person->project = $_SESSION['project-id']; 
                    $view_person = $person->view_person_by_proj();

                    while($row=$view_person->fetch(PDO::FETCH_ASSOC))
                    {
                      echo'
                      <tr>
                        <td style="width:10%"><center><input type="checkbox" name="checklist" class="checklist" value="'.$row['person_id'].'"/></center></td>
                        <td>'.$row['emp_no'].'</td>
                        <td>'.$row['firstname'].'</td>
                        <td>'.$row['lastname'].'</td>
                        <td>'.$row['contact'].'</td>
                        <td style="width:20%"><center><a class="edit-person" href="#" value="'.$row['person_id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="del-person" href="#" value="'.$row['person_id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
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
<div class="modal fade" id="newPersonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> Add New Personnel/Client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <div class="row">
          <div class="col-lg-6">
            <label for="exampleInputEmail1">Employee No.</label>
            <input type="text" class="form-control" id="emp_no" placeholder="Enter Employee Number">
          </div>
          <div class="col-lg-6">
            <label for="exampleInputEmail1">Contact Number</label>
            <input type="text" class="form-control" id="contact_num" placeholder="Enter Contact Number">
          </div>
        </div><br>
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
            <label for="exampleInputEmail1"><span class="fa fa-building"></span> Project</label>
            <select id="person_proj" type="text" class="form-control select2" style="width: 100%" disabled>';
            <?php
              $view = $loc->view_loc();
              while($loc_row=$view->fetch(PDO::FETCH_ASSOC))
              {
                if($_SESSION['project-id'] == $loc_row['id'])
                {
                  echo '<option value='.$loc_row['id'].' selected>'.$loc_row['location'].'</option>';
                }
              }
              ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <!-- ALERTS -->
            <div id="update-warning" class="alert alert-danger" role="alert" style="display: none"></div>
            <div id="update-success" class="alert alert-success" role="alert" style="display: none"></div>
          </div>
        </div>
      </div><!-- end of form-group -->
        <!-- ALERTS -->
        <div id="person-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        <div id="person-success" class="alert alert-success" role="alert" style="display: none"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save-person" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT PERSONNEL/CLIENT MODAL -->
<div class="modal fade" id="editPersonnelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-edit"></span> Edit Personnel Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="edit-personnel-body" class="modal-body">

      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="upd-person" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- data tables -->
<script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
<!-- plugins:js -->
<script src="../../components/js/vendor.bundle.base.js"></script>
<script src="../../components/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../../js/off-canvas.js"></script>
<script src="../../js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../../js/dashboard.js"></script>
<!-- End custom js for this page-->

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable();
  });
</script>

<!-- SAVE PERSONNEL FUNCTION -->
<script>
$('#save-person').click(function(e){
  e.preventDefault();

  var firstname = $('#fname').val();
  var lastname = $('#lname').val();
  var emp_no = $('#emp_no').val();
  var contact_num = $('#contact_num').val();
  var project = $('#project').val();
  var myData = 'firstname=' + firstname + '&lastname=' + lastname + '&emp_no=' + emp_no + '&contact_num=' + contact_num + '&project=' + project;

  if(firstname != "" && lastname != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/save_personnel.php",
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          $('#save-success').html("<center><i class='fa fa-check menu-icon'></i> Personnel Successfull Added.</center>");
          $('#save-success').show().fadeOut(5000);

            //page will reload after 3 seconds
           setTimeout(function(){
            window.location = "personnel.php";
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
    });
  }
  else
  {
    $('#save-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill out all the fields needed.</center>");
    $('#save-warning').show().fadeOut(5000);
  }
});  
</script>

<!-- UPDATE PERSONNEL FUNCTION -->
<!-- GET THE PERSONNEL DATA BY ID -->
<script>
$('.edit-person').click(function(e){
  e.preventDefault();
  var id = $(this).attr('value');

  $.ajax({
    type: "POST",
    url: "../../controls/view_person_byProj.php",
    data: {id: id},

    success: function(html)
    {
      $('#editPersonnelModal').modal('show');
      $('#edit-personnel-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})

//SAVE THE UPDATED DETAILS
$('#upd-person').click(function(e){
  e.preventDefault();

  var id = $('#upd_id_no').val();
  var emp_no = $('#upd_emp_no').val();
  var contact_num = $('#upd_contact_num').val();
  var firstname = $('#upd_fname').val();
  var lastname = $('#upd_lname').val();
  var myData = 'id=' + id + '&emp_no=' + emp_no + '&contact_num=' + contact_num + '&firstname=' + firstname + '&lastname=' + lastname;

  if(firstname != "" && lastname != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/update_personnel.php",
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          $('#update-success').html("<center><i class='fa fa-check menu-icon'></i> Personnel details Successfully updated.</center>");
          $('#update-success').show().fadeOut(5000);

          setTimeout(function(){
            location.reload();
          }, 1000)
        }
        else
        {
          $('#update-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update failed. Please contact the system administrator.</center>");
          $('#update-warning').show().fadeOut(5000);
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
    $('#update-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill out all fields.</center>");
    $('#update-warning').show().fadeOut(5000);
  }
})
</script>

<!-- DELETE PERSONNEL FUNCTION -->
<script>
$('.del-person').click(function(e){
  e.preventDefault();

  var id =$(this).attr('value');

  if(confirm('WARNING! Are you sure you want to remove this personnel?'))
  {
    $.ajax({
      type: "POST",
      url: "../../controls/delete_person.php",
      data: {id: id},

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          alert("Personnel Successfully Removed!");
          location.reload();
        }
        else
        {
          alert("ERROR! Remove Failed. Please contact the system administrator");
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
        $('.del-person').hide();
        $('.edit-person').hide();
      }
      else
      {
        $('#btndelete').hide();
        $('.del-person').show();
        $('.edit-person').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit-person').show();
      $('.del-person').show();
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
    $('.del-person').hide();
    $('.edit-person').hide();
  }
  else
  {
    $('#btndelete').hide();
    $('.del-person').show();
    $('.edit-person').show();
  }
});
</script>

</body>
</html>