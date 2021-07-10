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
  <?php 
    include '../../includes/super_header.php'; 
  ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div>
                <a href="#" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#newTypeModal"><i class="fa fa-plus"></i>New T&E Category</a>
                <a href="category.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                <a href="#" class="btn btn-dark btn-rounded" style="display:none" id="btndelete"><i class="fa fa-trash-o"></i>Delete Asset Type</a>
              </div><br>
              <table id="type-table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th style="width:5%"><center><input type="checkbox" id="checkboxall"></center></th>
                      <th style="width:8%">Category ID</th>
                      <th style="width:30%">Category Name</th>
                      <th style="width:70%">Description</th>
                      <th style="width:20%"><center>Action</center></th>
                    </tr>
                </thead>
                <tbody id="type-body">
                  <?php
                    $view = $type->view_type();
 
                    while($row = $view->fetch(PDO::FETCH_ASSOC))
                    {
                      extract($row);
                      echo '
                        <tr>
                          <td style="width:5%"><center><input type="checkbox" name="checklist" class="checklist" value="'.$row['id'].'"/></center></td>
                          <td style="width:8%"><center>'.$row['type_id'].'</center></td>
                          <td style="width:30%">'.$row['type'].'</td>
                          <td style="width:70%">'.$row['description'].'</td>
                          <td style="width:20%"><center><a class="edit_type" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete_type" href="#" value="'.$row['id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
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
<!-- NEW ASSET TYPE MODAL -->
<div class="modal fade" id="newTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> New Asset Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">T&E Category Name</label>
            </div>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="created_by" value="<?php echo $user_id; ?>" hidden>
              <input type="text" class="form-control" id="type" placeholder="Enter New Category Name">
            </div>
          </div><br>
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">Description</label>
            </div>
            <div class="col-lg-9">
              <textarea type="text" class="form-control" id="desc" placeholder="Enter Category Description" rows="4"></textarea>
            </div>
          </div>
        </div><!-- end of form-group -->
        <!-- Alerts -->
        <div id="warning" class="alert alert-danger" role="alert"></div>
        <div id="success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_type" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT ASSET TYPE MODAL -->
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-edit"></span> T&E Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="edit-type-modal" class="modal-body">

          <!-- MODAL BODY GOES HERE -->
      <!-- Alerts -->
      <div id="upd_warning" class="alert alert-danger" role="alert"></div>
      <div id="upd_success" class="alert alert-success" role="alert"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_edit" type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- data tables -->
<script src="../../components/dataTables/js/dataTables.bootstrap.min.js"></script>
<!-- <script src="../components/dataTables/js/jquery.dataTables.min.js"></script> -->
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
    $('.table').DataTable()({
      'paging'      : true,
      'searching'   : true,
      'ordering'    : true,
      'autoWidth'   : false
    });
  });
</script>

<!-- hide alert -->
<script>
$('.alert').hide();
</script>

<!-- SAVE ASSET TYPE FUNCTIONS -->
<script>
$('#save_type').click(function(e){
  e.preventDefault();

  var type = $('#type').val();
  var desc = $('textarea#desc').val();
  var myData = 'type=' + type + '&description=' + desc;
    
    if(type != "")
    { 
      $.ajax({
      type: "POST",
      url: "../../controls/save_type.php",
      data: myData,

        success: function(response)
        {
          if(response > 0)
          {
            $('#success').html("<center><i class='fa fa-check menu-icon'></i> Category Successfully Added.</center>");
            $('#success').show().fadeOut(5000);

            //page will reload after 3 sec if successfully save
            setTimeout(function(){
              location.reload();
            }, 1000)
          }
          else
          {
            $('#warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the system administrator.</center>");
            $('#warning').show().fadeOut(5000);
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
      $('#warning').html("<center><i class='fa fa-warning menu-icon'></i> Please input Asset Type.</center>");
      $('#warning').show().fadeOut(5000);
    }
});
</script>

<!-- update asset type function -->
<script>
  //get the data per ID
$('.edit_type').click(function(e){
  e.preventDefault();
  var id = $(this).attr('value');

  $.ajax({
    type: "POST",
    url: "../../controls/view_type_byID.php",
    data: {id: id},

    success: function(html)
    {
      $('#editTypeModal').modal('show');
      $('#edit-type-modal').html(html);
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  });
});

//save updated asset type function
$('#save_edit').click(function(e){
  e.preventDefault();

  var id = $('#upd_id').val();
  var type = $('#upd_type').val();
  var desc = $('textarea#upd_desc').val();
  var myData = 'id=' + id + '&type=' + type + '&description=' + desc;

  if(type != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/update_type.php",
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
         //page will reload after 3 sec if successfully save
          setTimeout(function(){
            location.reload();
          }, 1000)
        }
        else
        {
          $('#upd_warning').html("<center><i class='fa fa-warning menu-icon'></i> Update failed. Please contact the administrator.</center>");
          $('#upd_warning').show().fadeOut(5000);
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
    $('#upd_warning').html("<center><i class='fa fa-warning menu-icon'></i> Please input Asset Type.</center>");
    $('#upd_warning').show().fadeOut(5000);
  } 
});
</script>

<!-- delete asset type function -->
<script>
$('.delete_type').click(function(e){
  e.preventDefault();

    var id = $(this).attr('value');
    var myData = 'id=' + id;
    //alert(myData);
    if(confirm('WARNING! Are you sure you want to delete this T&E Category?'))
    {
      $.ajax({
        type: "POST",
        url: "../../controls/delete_type.php",
        data: myData,

        success: function(response)
        {
          if(response > 0)
          { 
            alert("T&E Category successfully removed.");
            location.reload();
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
      });
    }
});
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
        $('.delete_type').hide();
        $('.edit_type').hide();
      }
      else
      {
        $('#btndelete').hide();
        $('.delete_type').show();
        $('.edit_type').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit_type').show();
      $('.delete_type').show();
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
    $('.delete_type').hide();
    $('.edit_type').hide();
  }
  else
  {
    $('#btndelete').hide();
    $('.delete_type').show();
    $('.edit_type').show();
  }
});
</script>

</body>
</html>