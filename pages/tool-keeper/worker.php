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
  <link rel="shortcut icon" href="../../images/innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.min.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php 
    include '../../includes/tool_header.php'; 
  ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div>
                <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#NewWorkerModal"><i class="fa fa-user-plus"></i>Add Worker</button>
                <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#UploadModal"><i class="fa fa-upload"></i>Upload File</button>
                <a href="user.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                <button id="btndelete" type="button" class="btn btn-dark btn-rounded" style="display: none"><i class="fa fa-trash-o"></i>Delete</button>
              </div><br>
              <table id="worker_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th align="center"  style="max-width: 30px;"><input type="checkbox" id="checkboxall"/></th>
                      <th>Worker ID</th>
                      <th>Fullname</th>
                      <th><center>Trade</center></th>
                      <th><center>Project</center></th>
                      <th><center>Action</center></th>
                    </tr>
                </thead>
                <tbody id="worker-body">
                  <?php
                    $view = $worker->view_worker();
                    while($row = $view->fetch(PDO::FETCH_ASSOC))
                    {
                      echo '
                      <tr>
                        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['work-id'].'" style="max-width: 30px;"></td>
                        <td>'.$row['worker_id'].'</td>
                        <td>'.$row['fullname'].'</td>
                        <td>'.$row['trade_name'].'</td>
                        <td>'.$row['proj_name'].'</td>
                        <td style="width:20%"><center><a class="edit-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
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

<!-- MODAL SECTION -->
<!-- NEW WORKER MODAL -->
<div id="NewWorkerModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-id-badge"></span> Worker Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label for="exampleInputEmail1"><span class="fa fa-barcode"></span> Worker Barcode/ID No.</label>
            <input type="text" class="form-control date-warranty" id="worker-id" placeholder="Worker Barcode No. here" />
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-id-card"></span> Fullname</label>
            <input type="text" class="form-control date-warranty" id="fullname" placeholder="Fullname here" />
          </div>
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-address-card-o"></span> Address</label>
            <input type="text" class="form-control date-warranty" id="address" placeholder="Address here" />
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-wrench"></span> Trade</label>
            <select id="trade" type="text" class="form-control" style="width: 100%">
              <option selected disabled>Please select Trade</option>
                <?php
                  $view = $dept->view_dept();
                  while($row=$view->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['department'].'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="col-sm-6">
            <label for="exampleInputEmail1"><span class="fa fa-building"></span> Project</label>
            <select id="project" type="text" class="form-control" style="width: 100%">
              <option selected disabled>Please select Project</option>
                <?php
                  $view = $loc->view_loc();
                  while($row=$view->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['location'].'</option>';
                  }
                ?>
            </select>
          </div>
        </div><br><!-- end of row -->
        <div id="add-warning" class="alert alert-danger" role="alert" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button id="addWorker" class="btn btn-primary">Add</button>
        <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div> 

<!-- UPDATE WORKER DETAILS MODAL -->
<div id="UpdWorkerModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-id-badge"></span> Worker Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="update-body" class="modal-body">
        <!-- modal body goes here -->
      </div>
      <div class="modal-footer">
        <button id="btnUpdWorker" class="btn btn-primary">Update</button>
        <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div> 

<!-- UPLOAD MODAL -->
<div id="UploadModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-cloud-upload"></span> Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="alert alert-info" role="alert"><span class="fa fa-info-circle"></span> Please select a file to upload in worker's database. Please use CSV(Comma delimited) format.</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label for="exampleInputEmail1">Upload File</label><br>
              <form name="form" method="post" action="" enctype="multipart/form-data">
                <input type="file" id="filecover" name = "files[]" value="Browse" onchange="readURL(this);" accept=".csv" /><br>
              </form><br>
          </div>
        </div>
        <div id="loading" style="display: none"><center><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></center>
        </div>
        <div id="upload-success" class="alert alert-success" role="alert" style="display: none"></div>
        <div id="upload-warning" class="alert alert-danger" role="alert" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button id="btnUpload" class="btn btn-primary">Upload File</button>
        <button class="btn btn-default" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
    </div>
  </div>
</div> 
  
  <!-- data tables -->
  <script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
  <!-- jquery -->
  <script src="../../components/jquery/jquery-3.4.1.min.js"></script>
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

<!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();
})
</script>

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('#worker_table').DataTable();
  });
</script>
<!-- add new worker functions -->
<script>
$('#addWorker').click(function(e){
  e.preventDefault();

  var id = $('#worker-id').val();
  var fullname = $('#fullname').val();
  var address = $('#address').val();
  var trade = $('#trade').val();
  var project = $('#project').val();
  var myData = 'id=' + id + '&fullname=' + fullname + '&address=' + address + '&trade=' + trade + '&project=' + project;

  if(id != '' && fullname != '' && address != '' && trade != null && project != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/toolkeeper/save_worker.php',
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          $('#worker-id').val('');
          $('#fullname').val('');
          $('#address').val('');
          $('#trade option:eq(0)').prop('selected', true);
          $('#project option:eq(0)').prop('selected', true);
          $('#NewWorkerModal').modal('hide');

          //get the new list of worker
          $.ajax({
            type: 'POST',
            url: '../../controls/toolkeeper/view_worker.php',

            success: function(html)
            {
              $('#worker-body').fadeOut();
              $('#worker-body').fadeIn();
              $('#worker-body').html(html);
            }
          })
        }
        else
        {
          $('#add-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the administrator</center>");
          $('#add-warning').show().fadeOut(5000);
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
    $('#add-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the field needed.</center>");
    $('#add-warning').show().fadeOut(5000);
  }
})
</script>

<!-- edit worker details function -->
<script>
$('.edit-worker').click(function(){
  var id = $(this).attr('value');

  $.ajax({
    type: 'POST',
    url: '../../controls/toolkeeper/get_worker_data.php',
    data: {id: id},

    success: function(html)
    {
      $('#update-body').html(html);
      $('#UpdWorkerModal').modal('show');
    }
  })
})
</script>

<script>
$('#btnUpdWorker').click(function(e){
  e.preventDefault();

  var id = $('#upd_id').val();
  var worker_id = $('#upd_worker-id').val();
  var fullname = $('#upd_fullname').val();
  var address = $('#upd_address').val();
  var trade = $('#upd_trade').val();
  var project = $('#upd_project').val();
  var myData = 'id=' + id + '&worker_id=' + worker_id + '&fullname=' + fullname + '&address=' + address + '&trade=' + trade + '&project=' + project;

  if(worker_id != '' && fullname != '' && address != '' && trade != null && project != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/toolkeeper/upd_worker.php',
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          $('#UpdWorkerModal').modal('hide');
          //get the new list of worker
          $.ajax({
            type: 'POST',
            url: '../../controls/toolkeeper/view_worker.php',

            success: function(html)
            {
              $('#worker-body').fadeOut();
              $('#worker-body').fadeIn();
              $('#worker-body').html(html);
            }
          })
        }
        else
        {
          $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the administrator.</center>");
          $('#upd-warning').show().fadeOut(5000);
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
    $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the field needed.</center>");
    $('#upd-warning').show().fadeOut(5000);
  }
})
</script>

<!-- updload file function -->
<script>
$('#btnUpload').click(function(e){
  e.preventDefault();

  //initialize the form data for further validation
  var file_data = $('#filecover').prop('files')[0];
  var form_data = new FormData();
  form_data.append('files', file_data);

  $.ajax({
    type: 'POST',
    url: '../../controls/toolkeeper/upload_file.php',
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function(){
      $('#loading').show();
    },
    success: function(response)
    {
      if(response > 0)
      {
        $('#loading').hide();
        $('#upload-success').html("<center><i class='fa fa-warning menu-icon'></i> Upload successfull.</center>");
        $('#upload-success').show().fadeOut(5000);

        //get the new list of workers
        $.ajax({
          url: '../../controls/toolkeeper/view_worker.php',

          success: function(html)
          {
            $('#worker-body').fadeOut();
            $('#worker-body').fadeIn();
            $('#worker-body').html(html);
          }
        })
      }
      else
      {
        $('#loading').hide();
        $('#upload-warning').html("<center><i class='fa fa-warning menu-icon'></i> Updload Failed. Please contact the administrator.</center>");
        $('#upload-warning').show().fadeOut(5000);
      }
    }
  })
})
</script>
</body>
</html>