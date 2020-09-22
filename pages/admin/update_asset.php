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
    include '../../includes/header.php';
    //get the asset details by ID 
    $id = $_GET['id'];
    $asset->id = $id;

    $sel = $asset->get_asset_byID();

    while($row = $sel->fetch(PDO::FETCH_ASSOC)) 
    {
    	$desc=$row['description']; $specs=$row['specs']; $project=$row['project']; $category=$row['category']; $code=$row['code']; $trade=$row['trade'];
      $brand=$row['brand']; $barcode=$row['barcode']; $quantity=$row['quantity']; $price=$row['price']; $serial=$row['serial']; $model=$row['model'];
      $condition=$row['tool_condition']; $assign=$row['assign']; $image=$row['image']; $notes=$row['notes'];
    	$transferred=date_format(new DateTime($row['date_transfer']), "m/d/Y");
      $warranty=date_format(new DateTime($row['date_warranty']), "m/d/Y");
    	$image=$row['image'];
      //check if date_warranty is null
      if($warranty == 'NA')
      {
        $warranty = 'NA';
      }

    	//check image if null
    	if($image == '')
    	{
    		$image = '../../images/no-image.png';
    	}   	
    }
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
                      <label for="exampleInputEmail1">Asset Description</label>
                      <input type="text" class="form-control" id="upd_id" value="<?php echo $id;?>" style="display: none"/>
                      <textarea type="text" class="form-control" id="description" placeholder="Enter description" rows="5"><?php echo $desc;?></textarea>
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Specification</label>
                      <textarea type="text" class="form-control" id="specification" placeholder="Enter Specification" rows="5"><?php echo $specs;?></textarea>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Project/Building</label>
                      <select type="text" class="form-control js-example-basic-single" id="project">
                        <?php
                          $view = $loc->view_loc();
                          while($row = $view->fetch(PDO::FETCH_ASSOC))
                          {
                            if($project == $row['id'])
                            {
                              echo '<option value='.$project.' selected>'.$row['location'].'</option>';
                            }
                            else
                            {
                               echo '<option value='.$row['id'].'>'.$row['location'].'</option>';
                            } 
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Tool Category</label>
                      <select type="text" class="form-control js-example-basic-single" id="category" name="category">
                        <?php
                          $view = $type->view_type();
                          while($row=$view->fetch(PDO::FETCH_ASSOC))
                          {
                            if($category == $row['type_id'])
                            {
                              echo '<option value='.$project.' selected>'.$row['type'].'</option>';
                            }
                            else
                            {
                               echo '<option value='.$row['type_id'].'>'.$row['type'].'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label>Tool & Equipment Code</label><br>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text fa fa-barcode"></span>
                        </div>
                        <input type="text" class="form-control" id="code" value="<?php echo $code;?>">
                      </div>
                    </div>                    
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Trade</label>
                      <select type="text" class="form-control js-example-basic-single" id="trade" name="trade">
                        <?php
                          $view = $dept->view_dept();
                          while($row=$view->fetch(PDO::FETCH_ASSOC))
                          {
                            if($trade == $row['id'])
                            {
                              echo '<option value='.$trade.' selected>'.$row['department'].'</option>';
                            }
                            else
                            {
                               echo '<option value='.$row['id'].'>'.$row['department'].'</option>';
                            }
                          }
                        ?>
                      </select>
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Brand</label>
                      <input type="text" class="form-control" id="brand" placeholder="Enter Brand" value="<?php echo $brand;?>">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Barcode</label>
                      <input type="text" class="form-control" id="barcode" placeholder="Enter Barcode" value="<?php echo $barcode;?>">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-4" hidden>
                      <label for="exampleInputEmail1">Quantity</label>
                      <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity" value="<?php echo $quantity; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Price</label>
                      <input type="text" class="form-control" id="price" placeholder="Enter Price" value="<?php echo $price; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">End of Warranty</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text fa fa-calendar"></span>
                        </div>
                        <input type="text" class="form-control date-warranty" id="date_warranty" value="<?php echo $warranty; ?>"/>&nbsp;
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
                      <input type="text" class="form-control" id="serial" placeholder="Enter Serial Number" value="<?php echo $serial; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Model</label>
                       <input type="text" class="form-control" id="model" placeholder="Enter Serial Number" value="<?php echo $model; ?>">
                    </div>
                    <div class="col-lg-4">
                      <label for="exampleInputEmail1">Condition</label>
                      <select type="text" class="form-control" id="condition">
                        <?php
                          if($condition == 'Functional')
                          {
                            echo '<option selected>Functional</option>
                                  <option>For Trade In</option>
                                  <option>For Repair</option>
                                  <option>In Storage</option>';
                          }
                          elseif($condition == 'For Trade In')
                          {
                           echo '<option>Functional</option>
                                 <option selected>For Trade In</option>
                                 <option>For Repair</option>
                                 <option>In Storage</option>';
                          }
                          elseif($condition == 'For Repair')
                          {
                           echo '<option>Functional</option>
                                 <option>For Trade In</option>
                                 <option selected>For Repair</option>
                                 <option>In Storage</option>';
                          }
                          elseif($condition == 'In Storage')
                          {
                           echo '<option>Functional</option>
                                 <option selected>For Trade In</option>
                                 <option>For Repair</option>
                                 <option selected>In Storage</option>';
                          }
                          else
                          {
                            echo '<option>Functional</option>
                                  <option>For Trade In</option>
                                  <option>For Repair</option>
                                  <option>Stored</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-3">
                      <label for="exampleInputEmail1">Assigned To</label>
                      <select type="text" class="form-control js-example-basic-single" id="assign_person">
                        <?php
                          $view = $person->view_person();
                          while($row = $view->fetch(PDO::FETCH_ASSOC))
                          {
                            if($assign == $row['person_id'])
                            {
                            	echo '<option value='.$assign.' selected>'.$row['fullname'].'</option>';
                            }
                            else
                            {
                            	 echo '<option value='.$row['person_id'].'>'.$row['fullname'].'</option>';
                            }
                           
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
                        <input type="text" class="form-control date-transfer" id="date_transfer" value="<?php echo $transferred; ?>"/>
                      </div>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-7">
                      <label for="exampleInputEmail1">Notes</label>
                      <textarea type="text" class="form-control" id="notes" placeholder="Enter Notes" rows="5"><?php echo $notes; ?></textarea><br>
                      <label>History of Transfer</label>
                        <table class="table-hover table-bordered" style="font-size: 12px ">
                          <thead>
                              <tr>
                                <th>Date Transfer</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Reason of Transfer</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php 
                                //get the transfer history data by asset id
                                $record->asset_id = $id;

                                $get_record = $record->get_records();
                                while($row1 = $get_record->fetch(PDO::FETCH_ASSOC))
                                {
                                  $transfer_reason = $row1['reason'];
                                  $transfer_date = $row1['transfer_date'];
                                  $date = date('F d, Y', strtotime($transfer_date));
                                  $from = '';
                                  $to = '';
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

                                   echo '
                                    <tr>
                                      <td>'.$date.'</td>
                                      <td>'.$from.'</td>
                                      <td>'.$to.'</td>
                                      <td>'.$row1['reason'].'</td>
                                    </tr>';
                                }
                              ?> 
                          </tbody>
                        </table>
                    </div>
                    <div class="col-lg-5">
                      <label for="exampleInputEmail1">Attach Image</label><br>
                      <form name="form" method="post" action="" enctype="multipart/form-data">
                        <input type="file" id="filecover" name = "files[]" value="Browse" onchange="readURL(this);"/><br>
                        <img src = "<?php echo $image; ?>" style="width:430px; height:245px;" id="preview_image"></input>
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
                      <button id="update_asset" type="button" class="btn btn-primary">Update Asset</button>
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
              <input type="text" class="form-control" id="emp_no" placeholder="Enter Employee Number" value="0">
            </div>
            <div class="col-lg-6">
              <label for="exampleInputEmail1">Contact Number</label>
              <input type="text" class="form-control" id="contact_num" placeholder="Enter Contact Number" value="0">
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
  <div class="container-fluid clearfix" center>
    <center><span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.innogroup.com.ph/" target="_blank">Innoland Development Corporation</a>. All rights reserved.</span>
    </span></center>
  </div>
</footer>

<!-- data tables -->
<script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
<!-- select2 plugin -->
<script src="../../components/select2/select2.min.js"></script>
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

<!-- when project/building is changed -->
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

<!-- SAVE ASSET -->
<script>
$('#update_asset').click(function(e){
  e.preventDefault();

  var id = $('#upd_id').val();
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

  var myData = 'id=' + id + '&description=' + description + '&specification=' + specs + '&project=' + project + '&category=' + category + '&code=' + code + '&trade=' + trade + '&brand=' + brand + '&barcode=' + barcode + '&quantity=' + quantity + '&price=' + price + '&date_warranty=' + date_warranty + '&serial=' + serial + '&model=' + model + '&condition=' + condition + '&assign_person=' + assign_person + '&date_transfer=' + date_transfer + '&notes=' + notes;

  if(description != '' || serial != '' || barcode != '')//check if empty
  {
      if(file_data)
      {
	      $.ajax({
	      type: "POST",
	      url: "../../controls/update_asset.php",
	      data: myData,

	      success: function(response)
	      {
          if(response > 0)
          {
            $.ajax({
              type: "POST",
              url: "../../controls/upload.php",
              data: form_data,
              contentType: false,
              cache: false,
              processData: false,
            
              success: function(response)
              {
                if(response > 0)
                {
                  $('#asset-success').html("<center><i class='fa fa-check menu-icon'></i> Asset Successfully updated.</center>");
                  $('#asset-success').show().fadeOut(5000);

                  //page will reload after 3 sec if successfully save
		              setTimeout(function(){
		              location.reload();
		              }, 2000)
                }
              }
            })
          }
          else
          {
            $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the administrator.</center>");
            $('#asset-warning').show().fadeOut(5000);
          }
        }
      })
    }
    else//save asset without image attachment
    {
      $.ajax({
        type: 'POST',
        url: '../../controls/update_asset.php',
        data: myData,

        success: function(response)
        {
          if(response > 0)
          {
            $('#asset-success').html("<center><i class='fa fa-check menu-icon'></i> Asset Successfully Updated.</center>");
            $('#asset-success').show().fadeOut(5000);		
          }
          else
          {
            $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the administrator.</center>");
            $('#asset-warning').show().fadeOut(5000);
          }
        }
      })
    }
  }
  else
  {
    $('#asset-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the data needed to proceed.</center>");
    $('#asset-warning').show().fadeOut(5000);
  }
})
</script>

<!-- UPLOAD RESTRICTIONS -->
<script>
$('#filecover').bind('change', function(){
    var ext = $('#filecover').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['gif','png','jpg','jpeg','bmp']) == -1)
    {
      $('#error1').slideDown("slow");
      $('#error2').slideUp("slow");
      $('#error3').slideUp("slow");
      $('#save_asset').attr('disabled', true);
    }
    else
    {
      var size = (this.files[0].size);
      if(size > 2097152)
      {
        $('#error2').slideDown("slow");
        $('#error1').slideUp("slow");
        $('#error3').slideUp("slow");
        $('#save_asset').attr('disabled', true);
      }
      else
      {
        $('#error2').slideUp("slow");
      }

      $('#error1').slideUp("slow");
      $('#error2').slideUp("slow");
      $('#error3').slideUp("slow");
      $('#save_asset').attr('disabled', false);
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

<!-- call the select2 plugin -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();

  $('.date-warranty').datepicker({
    format: 'mm/dd/yyyy'
  });

  $('.date-transfer').datepicker({
    format: 'mm/dd/yyyy'
  });
})
</script>

<!-- SAVE NEW PERSON FUNCTION -->
<script>
$('#save-person').click(function(e){
  e.preventDefault();

  var emp_no = $('#emp_no').val();
  var contact_num = $('#contact_num').val();
  var firstname = $('#fname').val();
  var lastname = $('#lname').val();
  var myData = 'emp_no=' + emp_no + '&contact_num=' + contact_num + '&firstname=' + firstname + '&lastname=' + lastname; /*+ '&department=' + department + '&location=' + location*/

  //alert(myData);
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
        if(response > 0)
        {
          $('#person-success').html("<center><i class='fa fa-check menu-icon'></i> Adding Successfull.</center>");
          $('#person-success').show().fadeOut(5000);

          var id = response;
          var fullname = firstname + ' ' + lastname;
          var newOption = $('<option value="'+id+'">'+fullname+'</option>').attr('selected', true);
          $('#assign_person').append(newOption);         
        }
        else
        {
          $('#person-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the administrator</center>");
          $('#person-warning').show().fadeOut(5000); 
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