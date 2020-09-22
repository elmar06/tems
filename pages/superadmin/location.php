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
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php include '../../includes/super_header.php'; ?>
  <!-- main panel -->
    <div class="container-fluid page-body-wrapper">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <div id="content">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" href="#personnel" data-toggle="tab"><span class="fa fa-building"></span> Project</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#department" data-toggle="tab"><span class="fa fa-wrench"></span> Trade</a>
                  </li>
                </ul>
              <!-- TAB PANE CONTENT PERSONNEL -->
              <div id="my-tab-content" class="tab-content">
                  <div class="tab-pane active" id="personnel">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-body">
                              <div>
                                <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#newLocationModal"><i class="fa fa-plus"></i>New Project</button>
                                <a href="location.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                                <button id="del_location" type="button" class="btn btn-dark btn-rounded"><i class="fa fa-trash-o"></i>Delete</button>
                              </div><br>
                              <table id="personnel_table" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                      <th style="width:10%"><center><input type="checkbox" id="loc_checkboxall"></center></th>
                                      <th style="width:70%">Project Name</th>
                                      <th style="width:20%"><center>Project Code</center></th>
                                      <th style="width:20%"><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody id="location-body">
                                  <?php
                                    //$loc->status = 0;
                                    $view_loc = $loc->view_loc();

                                    while($row=$view_loc->fetch(PDO::FETCH_ASSOC))
                                    {
                                      echo'
                                      <tr>
                                        <td style="width:10%"><center><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"/></center></td>
                                        <td style="width:70%">'.$row['location'].'</td>
                                        <td style="width:20%"><center>'.$row['code'].'</center></td>
                                        <td style="width:20%"><center><a class="edit-loc" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-loc" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
                                      </tr>';
                                    }
                                  ?>
                                </tbody>
                              </table>
                          </div><!-- end of card-body -->
                        </div><!-- end of card -->
                      </div><!-- end of column -->
                    </div><!-- end of row -->
                  </div><!-- end of tab-pane personnel -->

                  <!-- TAB PANE CONTENT DEPARTMENT -->
                  <div class="tab-pane" id="department">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="card">
                          <div class="card-body">
                              <div>
                                <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#newDepartmentModal"><i class="fa fa-plus"></i>New Trade</button>
                                <a href="location.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                                <button id="del_department" type="button" class="btn btn-dark btn-rounded"><i class="fa fa-trash-o"></i>Delete</button>
                              </div><br>
                              <table id="dept_table" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                      <th style="width:10%"><center><input type="checkbox" id="dept_checkboxall"></center></th>
                                      <th style="width:70%">Trade Name</th>
                                      <th style="width:20%"><center>Action</center></th>
                                    </tr>
                                </thead>
                                <tbody id="dept-body">
                                  <?php
                                    $view_dept = $dept->view_dept();

                                    while($row=$view_dept->fetch(PDO::FETCH_ASSOC))
                                    {
                                      echo'
                                        <tr>
                                          <td style="width:10%"><center><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"/></center></td>
                                          <td style="width:70%">'.$row['department'].'</td>
                                          <td style="width:20%"><center><a class="edit-dept" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-dept" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
                                        </tr>';
                                    }
                                  ?>
                                </tbody>
                              </table>
                          </div><!-- end of card-body -->
                        </div><!-- end of card -->
                      </div><!-- end of column -->
                    </div><!-- end of row -->
                  </div><!-- end of tab-pane personnel -->

              </div><!-- end of tab-content -->
            </div><!-- end of id=content -->
          </div><!-- end of col-lg-12 -->
        </div><!-- end of row -->
      </div><!-- end of content-wrapper -->    
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
<!-- NEW LOCATION MODAL -->
<div class="modal fade" id="newLocationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> Add New Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">Project Name</label>
            </div>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="location" placeholder="Enter Project Name">
            </div>
          </div><br>
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">Project Code</label>
            </div>
             <div class="col-lg-9">
              <input type="text" class="form-control" id="loc_code" placeholder="Enter Project Code">
            </div>
          </div>
        </div><!-- end of form-group -->
      <!-- Alerts -->
      <div id="new_loc_warning" class="alert alert-danger" role="alert"></div>
      <div id="new_loc_success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_location" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- NEW DEPARTMENT MODAL -->
<div class="modal fade" id="newDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> Add New Trade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">Trade Name</label>
            </div>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="new_department" placeholder="Enter Department">
            </div>
          </div>
        </div><!-- end of form-group -->
      <!-- Alerts -->
      <div id="new_dept_warning" class="alert alert-danger" role="alert"></div>
      <div id="new_dept_success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_department">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT LOCATION MODAL -->
<div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-edit"></span> Edit Location Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit-location-body" class="form-group">

        </div><!-- end of form-group -->
      <!-- Alerts -->
      <div id="upd_loc_warning" class="alert alert-danger" role="alert"></div>
      <div id="upd_loc_success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upd_location">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT DEPARTMENT MODAL -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-edit"></span> Edit Department Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="edit-dept-body" class="form-group">

        </div><!-- end of form-group -->
      <!-- Alerts -->
      <div id="upd_dept_warning" class="alert alert-danger" role="alert"></div>
      <div id="upd_dept_success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upd_department">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- data tables -->
<script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
<script src="../../components/js/vendor.bundle.base.js"></script>
<script src="../../components/js/vendor.bundle.addons.js"></script>
<script src="../../js/off-canvas.js"></script>
<script src="../../js/misc.js"></script>
<script src="../../js/dashboard.js"></script>
<!-- End custom js for this page-->

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable();
  });
</script>

<!-- HIDE THE DELETE BUTTON -->
<script>
  $(document).ready(function(){
    $('#del_location').hide();
    $('#del_department').hide();
    $('.alert').hide();//hide alert
  })
</script>

<!-- SAVE NEW LOCATION -->
<script>
$('#save_location').click(function(e){
  e.preventDefault()

  var location1 = $('#location').val();
  var code = $('#loc_code').val();

  $.ajax({
    type: "POST",
    url: "../../controls/save_location.php",
    data: {location: location1, code: code},

    success: function(response)
    {
      if(response > 0)
      {
        $('#new_loc_success').html("<center><i class='fa fa-check menu-icon'></i> Adding Successfull.</center>");
        $('#new_loc_success').show().fadeOut(5000);
        //page will reload after 3 sec if successfully save  
        setTimeout(function(){
          window.location.reload();
        },1000)
      }
      else
      {
        $('#new_loc_warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the system administrator.</center>");
        $('#new_loc_warning').show().fadeOut(5000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});
</script>

<!-- UPDATE LOCATION FUNCTION -->
<script>
$('.edit-loc').click(function(e){
  e.preventDefault();
  var id = $(this).attr('value');

  $.ajax({
    type: "POST",
    url: "../../controls/view_location_byID.php",
    data: {id: id},

    success: function(html)
    {
      $('#editLocationModal').modal('show');
      $('#edit-location-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});

//SAVE UPDATED LOCATION
$('#upd_location').click(function(e){
  e.preventDefault();

  var id = $('#upd_id_loc').val();
  var location = $('#upd_loc').val();
  var code = $('#upd_code').val();
  var myData = 'id=' + id + '&location=' + location + '&code=' + code;

  $.ajax({
    type: "POST",
    url: "../../controls/update_location.php",
    data: myData,

    success: function(response)
    {
      if(response > 0)
      {
        $('#upd_loc_success').html("<center><i class='fa fa-check menu-icon'></i> Project Successfully Updated.</center>");
        $('#upd_loc_success').show().fadeOut(5000);

        //page will reload after 1 sec if successfully save  
        setTimeout(function(){
          window.location.reload();
        }, 1000)
      }
      else
      {
        $('#new_loc_warning').html("<center><i class='fa fa-warning menu-icon'></i> Update failed. Please contact the system administrator.</center>");
        $('#new_loc_warning').show().fadeOut(5000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});
</script>

<!-- DELETE/REMOVE LOCATION -->
<script>
$('.delete-loc').click(function(e){
  var id = $(this).attr('value');

  if(confirm('WARNING! Are you sure you want to delete this Project on the list?'))
  {
    $.ajax({
      type: "POST",
      url: "../../controls/delete_location.php",
      data: {id: id},

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          alert('Project successfully deleted in the list');
          
          //page will reload after 2 sec if successfully save  
          setTimeout(function(){
            window.location.reload();
          },1000)
        }
        else
        {
          alert('Failed to delete the location. Please contact the Administrator for assistance.');
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    });
  }
}); 
</script>

<!-- SAVE DEPARTMENT FUNCTIONS -->
<script>
$('#save_department').click(function(e){
  e.preventDefault();

  var department = $('#new_department').val();

  $.ajax({
    type: "POST",
    url: "../../controls/save_department.php",
    data: {department: department},

    success: function(response)
    { 
      //alert(response);
      if(response > 0)
      {
        $('#new_dept_success').html("<center><i class='fa fa-check menu-icon'></i> Trade Successfully Added.</center>");
        $('#new_dept_success').show().fadeOut(5000);
        //page will reload after 3 sec if successfully save  
        setTimeout(function(){
          window.location.reload();
        }, 1000)
      }
      else
      {
        $('#new_dept_warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the administrator.</center>");
        $('#new_dept_warning').show().fadeOut(5000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
}); 
</script>

<!-- EDIT DEPARTMENT FUNCTIONS -->
<script>
$('.edit-dept').click(function(e){
  e.preventDefault();
  var id = $(this).attr('value');
  //alert(id);
  $.ajax({
    type: "POST",
    url: "../../controls/view_dept_byID.php",
    data: {id: id},

    success: function(html)
    {
      $('#editDepartmentModal').modal('show');
      $('#edit-dept-body').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});

/*SAVE UPDATED DEPARTMENT*/
$('#upd_department').click(function(e){
  e.preventDefault();

  var id = $('#upd_id_dept').val();
  var department = $('#upd_dept').val();
  var myData = 'id=' + id + '&department=' + department;
  //alert(myData);
  $.ajax({
    type: "POST",
    url: "../../controls/update_department.php",
    data: myData,

    success: function(response)
    {
      //alert(response);
      if(response > 0)
      {
        $('#upd_dept_success').html("<center><i class='fa fa-check menu-icon'></i> Trade Successfully Updated.</center>");
        $('#upd_dept_success').show().fadeOut(5000);

        //page will reload after 2 sec if successfully save  
        setTimeout(function(){
          window.location.reload();
        }, 1000)        
      }
      else
      {
        $('#upd_dept_warning').html("<center><i class='fa fa-warning menu-icon'></i> Update failed. Please contact the administrator.</center>");
        $('#upd_dept_warning').show().fadeOut(5000);
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});
</script>
<!-- DELETE TRADE -->
<script>
 $('.delete-dept').click(function(e){
  e.preventDefault();

  var id = $(this).attr('value');
  var myData = 'id=' + id;
  if(confirm("WARNING! Are you sure you want to delete this Department?"))
  {
    $.ajax({
      type: "POST",
      url: "../../controls/delete_department.php",
      data: myData,

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          alert("Department successfully removed.");
          window.location.reload();
        }
        else
        {
          alert("ERROR! Delete failed. Please contact the administrator.");
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
 });
</script>

<!-- LOCATION CHECKBOX FUNCTIONS -->
<script>
$('#loc_checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
      if(selected.length > 1)
      {
        $('#del_location').show();
        $('.delete-loc').hide();
        $('.edit-loc').hide();
      }
      else
      {
        $('#del_location').hide();
        $('.delete-loc').show();
        $('.edit-loc').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit-loc').show();
      $('.delete-loc').show();
      $('#del_location').hide();
    });
  }
});

//LOCATION CHECKLIST FUNCTION
$(document).on('change', '.checklist', function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
  if(selected.length > 1)
  {
    $('#del_location').show();
    $('.delete-loc').hide();
    $('.edit-loc').hide();
  }
  else
  {
    $('#del_location').hide();
    $('.delete-loc').show();
    $('.edit-loc').show();
  }
});
</script>

<!-- DEPARTMENT CHECKBOX FUNCTIONS -->
<script>
$('#dept_checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
      if(selected.length > 1)
      {
        $('#del_department').show();
        $('.delete-dept').hide();
        $('.edit-dept').hide();
      }
      else
      {
        $('#del_department').hide();
        $('.delete-dept').show();
        $('.edit-dept').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit-dept').show();
      $('.delete-dept').show();
      $('#del_department').hide();
    });
  }
});

//DEPARTMENT CHECKLIST FUNCTION
$(document).on('change', '.checklist', function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
  if(selected.length > 1)
  {
    $('#del_department').show();
    $('.delete-dept').hide();
    $('.edit-dept').hide();
  }
  else
  {
    $('#del_department').hide();
    $('.delete-dept').show();
    $('.edit-dept').show();
  }
});
</script>
</body>
</html>