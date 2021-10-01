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
  <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/datepicker.min.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php 
    include '../../includes/pmo_header.php'; 
  ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div id="main">
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-8">
                      <label for="exampleInputEmail1">Tools Description</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <textarea type="text" class="form-control" id="description" placeholder="Enter description" rows="5"></textarea>
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Specification</label>
                      <textarea type="text" class="form-control" id="specification" placeholder="Enter Specification" rows="5" required></textarea>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Project/Building</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <select type="text" class="form-control js-example-basic-single" id="project" required="required">
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
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Tool Category</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <select type="text" class="form-control js-example-basic-single" id="category" name="category" required="required">
                        <?php
                          $type->status = 0;
                          $view = $type->view_type();
                          while($row=$view->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<option value='.$row['type_id'].'>'.$row['type'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label>Tool & Equipment Code</label>&nbsp;<span style="color: red; font-size: 16px">*</span><br>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text fa fa-barcode"></span>
                        </div>
                        <input type="text" class="form-control" id="code" required="required">
                      </div>
                    </div>                    
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Trade</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <select type="text" class="form-control js-example-basic-single" id="trade" name="trade" required="required">
                        <?php
                          $view = $dept->view_dept();
                          while($row=$view->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<option value='.$row['id'].'>'.$row['department'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Brand</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <input type="text" class="form-control" id="brand" placeholder="Enter Brand" required="required">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Price</label>
                      <input type="text" class="form-control" id="price" placeholder="Enter Price" value="0.00">
                    </div>
                    <div class="col-lg-4" hidden>
                      <label for="exampleInputEmail1">Barcode</label>
                      <input type="text" class="form-control" id="barcode" placeholder="Enter Model" value="0000-0000">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4" hidden>
                      <label for="exampleInputEmail1">Quantity</label>
                      <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity" value="1">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">End of Warranty</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control date-warranty" id="date_warranty"/>&nbsp;
                        <a id="not_applicable" href="#" data-toggle="modal" data-target="#newTradeModal" style="color: red"><span class="fa fa-ban" style="color: red"></span> Mark as NA</a>
                        <a id="applicable" href="#" data-toggle="modal" data-target="#newTradeModal" hidden><span class="fa fa-check-circle"></span> Input Date</a>
                      </div>
                    </div>
                  </div><br><hr>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">GENERAL</label>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Serial Number</label>
                      <input type="text" class="form-control" id="serial" placeholder="Enter Serial Number">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Model</label>
                      <input type="text" class="form-control" id="model" placeholder="Enter Model">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Tool & Equipment Condition</label>
                       <select type="text" class="form-control" id="condition">
                        <option>Functional</option>
                        <option>For Trade In</option>
                        <option>For Repair</option>
                        <option>In Storage</option>
                      </select>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-3">
                      <label for="exampleInputEmail1">Assigned To</label>
                      <select type="text" class="form-control js-example-basic-single" id="assign_person">
                        <?php
                          $person->project = $_SESSION['project-id'];
                          $view = $person->view_person_by_proj();
                          while($row = $view->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<option value='.$row['person_id'].'>'.$row['fullname'].'</option>';
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-1">
                      <div><br>
                        <a href="#" data-toggle="modal" data-target="#newPersonModal"><span class="fa fa-plus-square"></span> New</a>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <label>Date Transferred</label><br>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control date-transfer" id="date_transfer"/>
                      </div>
                    </div>
                    
                  </div><br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Notes</label>
                      <textarea type="text" class="form-control" id="notes" placeholder="Enter Notes" rows="18"></textarea>
                    </div>
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Attach Image</label><br>
                      <form name="form" method="post" action="" enctype="multipart/form-data">
                        <input type="file" id="filecover" name = "files[]" value="Browse" onchange="readURL(this);"/><br>
                        <img src = "../../images/no-image.png" style="width:430px; height:245px;" id="preview_image"></input>
                        <p id="error1" style="display:none; color:#FF0000;">
                          Invalid Image Format! Image Format Must Be JPG, JPEG, PNG or GIF.
                        </p>
                        <p id="error2" style="display:none; color:#FF0000;">
                          Maximum File Size Limit is 1MB.
                        </p>
                         <p id="error3" style="display:none; color:#FF0000;">
                          File is already exist.
                        </p>
                      </form>
                    </div>
                  </div><br>
                  <div class="row">
                    <!-- Alerts -->
                    <div class="col-lg-12">
                      <div id="asset-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                      <div id="asset-success" class="alert alert-success" role="alert" style="display: none"></div>
                    </div>
                  </div>  
                  <div class="row">
                    <div class="col-lg-12">
                      <button id="save_asset" type="button" class="btn btn-primary">Add Asset</button>
                      <button id="btnclear" type="button" class="btn btn-secondary" data-dismiss="modal">Clear</button>
                    </div>
                  </div>
                </div><!-- end of form-group --> 
              </div><!-- /main -->
            </div><!-- /card-body -->
          </div><!-- /card -->
        </div><!-- /cal-lg-12 -->
      </div><!-- end of row -->
  </div><!-- end of container-fluid -->
</div><!-- end of container-scroller -->

<!-- MODALS SECTION -->
<!-- NEW ASSIGNEE MODAL -->
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
            <select id="person-proj" type="text" class="form-control select2" style="width: 100%" disabled>
            <?php
              $view = $loc->view_loc();
              while($loc_row=$view->fetch(PDO::FETCH_ASSOC))
              {
                if($_SESSION['project-id'] == $loc_row['id'])
                {
                  echo '<option value="'.$loc_row['id'].'" selected>'.$loc_row['location'].'</option>';
                }
                else
                {
                  echo '<option value="'.$loc_row['id'].'">'.$loc_row['location'].'</option>';
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

<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="container-fluid clearfix"><center>
    <center><span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.innogroup.com.ph/" target="_blank">Innoland Development Corporation</a>. All rights reserved.</span>
    </span></center>
  </div>
</footer>

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
<!-- date picker -->
<script src="../../components/datetimepicker/js/bootstrap-datepicker.js"></script>
<!-- select2 plugin -->
<script src="../../components/select2/select2.min.js"></script>


<!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();

  $('.date-warranty').datepicker({
    format: 'mm/dd/yyyy'
  }).datepicker('setDate', new Date());

  $('.date-transfer').datepicker({
    format: 'mm/dd/yyyy'
  }).datepicker('setDate', new Date());
})
</script>
<!-- MARK NOT APPLICABLE OF DATE WARRANTY-->
<script>
  $('#not_applicable').click(function(){
    var value = 'NA';
    $('#date_warranty').attr('disabled', true);
    $('#date_warranty').val(value);
    $(this).hide();
    $('#applicable').attr('hidden', false);
  })

  $('#applicable').click(function(){
    $(this).hide();
    $('#not_applicable').show();
    $('#date_warranty').attr('disabled', false);

    //re enter the current date
    $('.date-warranty').datepicker({
      format: 'mm/dd/yyyy'
    }).datepicker('setDate', new Date());

  })
</script>

<!-- get the new T&E code -->
<!-- get code upon loading the page -->
<script>
$(document).ready(function(){
  var proj = $('#project').val();
  var cat = $('#category').val();
  var cat_code = ('0000' + cat).slice(-2);
  var myData = 'proj=' + proj + '&cat=' + cat;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_code.php',
    data: myData,
    dataType: 'json',
    cache: false,

    success: function(result)
    {
      var proj_code = result[0];
      var series = result[1];
      var series_no = ('0000' + series).slice(-4);
      var code = proj_code + '-' + cat_code + '-' + series_no;
      $('#code').val(code);
    }
  })
})
</script>

<!-- when category is changed -->
<script>
$('#category').on('change', function(){
  var proj = $('#project').val();
  var cat = $(this).val();
  var cat_code = ('0000' + cat).slice(-2);
  var myData = 'proj=' + proj + '&cat=' + cat;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_code.php',
    data: myData,
    dataType: 'json',
    cache: false,

    success: function(result)
    {
      var proj_code = result[0];
      var series = result[1];
      var series_no = ('0000' + series).slice(-4);
      var code = proj_code + '-' + cat_code + '-' + series_no;
      $('#code').val(code);
    }
  })
})
</script>
<!-- when project is changed -->
<script>
$('#project').on('change', function(){
  var proj = $(this).val();
  var cat = $('#category').val();
  var cat_code = ('0000' + cat).slice(-2);
  var myData = 'proj=' + proj + '&cat=' + cat;

  $.ajax({
    type: 'POST',
    url: '../../controls/get_code.php',
    data: myData,
    dataType: 'json',
    cache: false,

    success: function(result)
    {
      var proj_code = result[0];
      var series = result[1];
      var series_no = ('0000' + series).slice(-4);
      var code = proj_code + '-' + cat_code + '-' + series_no;
      $('#code').val(code);
    }
  })
})
</script>

<script>
//This function will validate image before uploading
var a = 0;
//bind to onchange event of your input field
$('#filecover').bind('change', function(){
  if($('input:submit').attr('disabled',false))
  {
    $('input:submit').attr('disabled', false);
  }
  //check the extension of the image if valid
  var ext = $('#filecover').val().split('.').pop().toLowerCase();
  if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
  {
    $('#save_asset').prop("disabled", true);
    $('#error1').slideDown("slow");
    $('#error2').slideUp("slow");
    a = 0;
  }
  else
  {
    var size = (this.files[0].size);
    if(size > 1048576)
    {
      $('#save_asset').prop("disabled", true);
      $('#error2').show();
      a = 0;
    }
    else
    {
      a = 1;
      $('#error2').slideUp("slow");
      $('#save_asset').attr('disabled',false);
    }
  }

  //check if true
  if(a == 1)
  {
    $('#save_asset').attr('disabled',false);
    $('#error1').slideUp("slow");
  }
});
//SAVE ASSET 
$('#save_asset').click(function(e){
  e.preventDefault();

  var description = $('#description').val();
  var specs = $('#specification').val();
  var project = $('#project').val();
  var category = $('#category').val();
  var code = $('#code').val();
  var trade = $('#trade').val();
  var brand = $('#brand').val();
  var barcode = $('#barcode').val();
  var quantity = $('#quantity').val();
  var price = $('#price').val();
  var date_warranty = $('#date_warranty').val();
  var serial = $('#serial').val();
  var model = $('#model').val();
  var condition = $('#condition').val();
  var assign_person = $('#assign_person').val();
  var date_transfer = $('#date_transfer').val();
  var notes = $('#notes').val();  

  //initialize the form data for further validation
  var file_data = $('#filecover').prop('files')[0];
  var form_data = new FormData();
  form_data.append('files', file_data);

  var myData = 'description=' + description + '&specification=' + specs + '&project=' + project + '&category=' + category + '&code=' + code + '&trade=' + trade + '&brand=' + brand + '&barcode=' + barcode + '&quantity=' + quantity + '&price=' + price + '&date_warranty=' + date_warranty + '&serial=' + serial + '&model=' + model + '&condition=' + condition + '&assign_person=' + assign_person + '&date_transfer=' + date_transfer + '&notes=' + notes;
  //data for updating the logs
  var proj = $('#project').val();
  var cat = $('#category').val();
  var cat_code = ('0000' + cat).slice(-2);
  var myUpdData = 'proj=' + proj + '&cat=' + cat;

  if(description != '' && brand != '')//check if empty
  {
      if(file_data)
      {
        //this is to check if the image already exist        
        $.ajax({
          type: "POST",
          url: "../../controls/check_image.php",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,

          success: function(response)
          {
            if(response > 0)
            {
              $('#error3').slideDown('slow');
            }
            else
            {
              //if image does not exist proceed for saving
              $('#error3').slideUp('slow');
              $.ajax({
              type: "POST",
              url: "../../controls/save_asset.php",
              data: myData,

              success: function(response)
              {
                if(response > 0)
                {
                  //upload the image after saving the details in asset
                  $.ajax({
                    type: "POST",
                    url: "../../controls/upload.php",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                  
                    success: function(response)
                    {
                      alert(response);
                      if(response > 0)
                      {
                        //if uploaded update the logs
                        $.ajax({
                          type: 'POST',
                          url: '../../controls/upd_log.php',
                          data: myUpdData,

                          success: function(response)
                          {
                            if(response > 0)
                            {
                              $('#asset-success').html("<center><i class='fa fa-check menu-icon'></i> Asset Successfully added.</center>");
                              $('#asset-success').show().fadeOut(5000);
                              //reload page after 1 second
                              setTimeout(function(){
                                location.reload();
                              }, 1000)
                            }
                            else
                            {
                              $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Logs Update Failed. Please contact the administrator.</center>");
                              $('#asset-warning').show().fadeOut(5000);
                            }
                          }
                        })                         
                      }
                      else
                      {
                        $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Image Upload Failed. Please contact the administrator.</center>");
                        $('#asset-warning').show().fadeOut(5000);
                      }
                    }
                  })
                }
                else
                {
                  $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding Failed. Please contact the administrator.</center>");
                  $('#asset-warning').show().fadeOut(5000);
                }
              }
            })
          }
        },
          error: function(xhr, ajaxOptions, thrownError)
        {
          alert(thrownError);
        }
      })
    }
    else//save asset without image attachment
    {
      $.ajax({
        type: 'POST',
        url: '../../controls/save_asset.php',
        data: myData,

        success: function(response)
        {
          if(response > 0)
          {
            //if uploaded update the logs
            $.ajax({
              type: 'POST',
              url: '../../controls/upd_log.php',
              data: myUpdData,

              success: function(response)
              {
                if(response > 0)
                {
                  $('#asset-success').html("<center><i class='fa fa-check menu-icon'></i> Asset Successfully added.</center>");
                  $('#asset-success').show();
                  setTimeout(function(){
                    $('#asset-sucess').fadeOut();
                  }, 3000)
                }
                else
                {
                  $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Logs Update Failed. Please contact the administrator.</center>");
                  $('#asset-warning').show();
                  setTimeout(function(){
                    $('#asset-warning').fadeOut();
                  }, 5000)
                }
              }
            })              
          }
          else
          {
            $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding Failed. Please contact the administrator.</center>");
            $('#asset-warning').show();
            setTimeout(function(){
              $('#asset-warning').fadeOut();
            }, 5000)
          }
        }
      })
    }
  }
  else
  {
    $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the data needed to proceed.</center>");
    $('#asset-warning').show();
    setTimeout(function(){
      $('#asset-warning').fadeOut();
    }, 5000)
  }
})
</script>

<!-- PREVIEW image before uploading -->
<script type="text/javascript">
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#preview_image').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

<!-- SAVE NEW PERSON FUNCTION -->
<script>
$('#save-person').click(function(e){
  e.preventDefault();

  var emp_no = $('#emp_no').val();
  var contact_num = $('#contact_num').val();
  var firstname = $('#fname').val();
  var lastname = $('#lname').val();
  var project = $('#person-proj').val();
  var myData = 'emp_no=' + emp_no + '&contact_num=' + contact_num + '&firstname=' + firstname + '&lastname=' + lastname + '&project=' + project; 

  alert(myData);
  if(firstname == "" || lastname == "" || emp_no == "" || contact_num == "")
  {
    $('#person-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all fields needed.</center>");
    $('#person-warning').show().fadeOut(5000);    
  }
  else
  {
    $.ajax({
      type: "POST",
      url: "../../controls/save_personnel.php",
      data: myData,

      success: function(response)
      {
        alert(response);
        if(response > 0)
        {
          $('#person-success').html("<center><i class='fa fa-check menu-icon'></i> Adding Successfull.</center>");
          $('#person-success').show();
          setTimeout(function(){
            $('#person-success').fadeOut();
          }, 3000)

          var id = response;
          var fullname = firstname + ' ' + lastname;
          var newOption = $('<option value="'+id+'">'+fullname+'</option>').attr('selected', true);
          $('#assign_person').append(newOption);         
        }
        else
        {
          $('#person-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the administrator</center>");
          $('#person-warning').show();
          setTimeout(function(){
            $('#person-warning').fadeOut();
          }, 3000)
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

</body>
</html>