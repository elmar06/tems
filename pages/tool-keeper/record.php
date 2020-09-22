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
  <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/datepicker.min.css">
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
                <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#ReportModal"><i class="fa fa-print"></i>Generate Report</button>
                <a href="user.php" class="btn btn-dark btn-rounded" ><span class ="fa fa-refresh"></span> Refresh Table</a>
                <button id="btndelete" type="button" class="btn btn-dark btn-rounded" style="display: none"><i class="fa fa-trash-o"></i>Delete</button>
              </div><br>
              <table id="record_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th>Tool Code</th>
                      <th>Description</th>
                      <th>Borrower's name</th>
                      <th><center>Date Borrowed</center></th>
                      <th><center>Date Returned</center></th>
                      <th><center>Status</center></th>
                    </tr>
                </thead>
                <tbody>
                  
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
<!-- REPORT GENERATION MODAL -->
<div id="ReportModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-bar-chart"></span> Report Generation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <p><i>Generate report by:</i></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1">Weekly</label><br>
          </div>
          <div class="col-sm-5">
            <label for="exampleInputEmail1" style="font-size: 12px">From</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control date" id="date_from"/>
              </div>
          </div>
          <div class="col-sm-5">
            <label for="exampleInputEmail1" style="font-size: 12px">To</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text fa fa-calendar"></span>
                </div>
                <input type="text" class="form-control date" id="date_to"/>
              </div>
          </div>
        </div>
        <div class="row">  
          <div class="col-sm-1">
            <button id="clear_assign" type="button" class="close clear-data" aria-label="Close" hidden>
              <span style="color: red" class="fa fa-remove"></span>
            </button>
          </div>
        </div><br><!-- end of row -->
        <div class="row">
          <div class="col-sm-2">
            <label for="exampleInputEmail1">Monthly</label><br>
          </div>
          <div class="col-sm-8">
            <select id="reportDepartment" type="text" class="form-control" style="width: 100%">
              <option value="" selected disabled>Please select Project</option>
                <?php
                  $view = $loc->view_loc();
                  while($row=$view->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['location'].'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="col-sm-1"> 
            <button id="clear_dept" type="button" class="close clear-data" aria-label="Close" hidden>
              <span style="color: red" class="fa fa-remove"></span>
            </button>
          </div>
        </div><br><!-- end of row -->
        <div id="report-warning" class="alert alert-danger" role="alert" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button id="btnGenerate" class="btn btn-primary">Generate</button>
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
<!-- date picker -->
<script src="../../components/datetimepicker/js/bootstrap-datepicker.js"></script>

<!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();
  //call datepicker function
  $('.date').datepicker({
    format: 'mm/dd/yyyy'
  });
})
</script>

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('#record_table').DataTable();
  });
</script>
</body>
</html>