<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsLocation.php';
include '../objects/clsDepartment.php';
include '../objects/clsPersonnel.php';
include '../objects/clsUser.php';
include '../objects/clsType.php';
include '../objects/clsRecord.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$loc = new Location($db);
$dept = new Department($db);
$person = new Personnel($db);
$user = new Users($db);
$type = new Type($db);
$record = new TransferRecord($db);

$asset->id = $_POST['id'];
$view = $asset->get_asset_byID();

while($row = $view->fetch(PDO::FETCH_ASSOC))
{
	$desc=$row['description']; $specs=$row['specs']; $project=$row['project']; $category=$row['category']; $code=$row['code']; $trade=$row['trade'];
  $brand=$row['brand']; $barcode=$row['barcode']; $quantity=$row['quantity']; $price=$row['price']; $serial=$row['serial']; $model=$row['model'];
  $condition=$row['tool_condition']; $assign=$row['assign']; $image=$row['image']; $notes=$row['notes'];
  $warranty=date_format(new DateTime($row['date_warranty']), "m/d/Y");
  $transferred=date_format(new DateTime($row['date_transfer']), "m/d/Y");
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

	echo '<div class="row">
          <div class="col-lg-8">
            <label for="exampleInputEmail1">Asset Description</label>
            <input type="text" class="form-control" id="upd_id" value="<?php echo $id;?>" style="display: none"/>
            <textarea type="text" class="form-control" id="description" placeholder="Enter description" rows="5" disabled>'.$desc.'</textarea>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Specification</label>
            <textarea type="text" class="form-control" id="specification" placeholder="Enter Specification" rows="5" disabled>'.$specs.'</textarea>
          </div>
        </div><br>
        <div class="row">
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Project</label>
            <select type="text" class="form-control js-example-basic-single" id="project" disabled>';

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
            echo'</select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Tool Category</label>
            <select type="text" class="form-control js-example-basic-single" id="category" name="category" disabled>';

                $view = $type->view_type();
                while($row=$view->fetch(PDO::FETCH_ASSOC))
                {
                  if($category == $row['id'])
                  {
                    echo '<option value='.$project.' selected>'.$row['type'].'</option>';
                  }
                  else
                  {
                     echo '<option value='.$row['id'].'>'.$row['type'].'</option>';
                  }
                }

            echo'</select>
          </div>
          <div class="col-lg-4">
            <label>Tool & Equipment Code</label><br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text fa fa-barcode"></span>
              </div>
              <input type="text" class="form-control" id="code" value="'.$code.'" disabled>
            </div>
          </div>                    
        </div><br>
        <div class="row">
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Trade</label>
            <select type="text" class="form-control js-example-basic-single" id="trade" name="trade" disabled>';

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

            echo'</select>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Brand</label>
            <input type="text" class="form-control" id="brand" placeholder="Enter Brand" value="'.$brand.'" disabled>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Barcode</label>
            <input type="text" class="form-control" id="barcode" placeholder="Enter Barcode" value="'.$barcode.'" disabled>
          </div>
        </div><br>
        <div class="row">
          <div class="col-lg-4" hidden>
            <label for="exampleInputEmail1">Quantity</label>
            <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity" value="'.$quantity.'" disabled>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Price</label>
            <input type="text" class="form-control" id="price" placeholder="Enter Price" value="'.$price.'" disabled>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">End of Warranty</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control date-warranty" id="date_warranty" value="'.$warranty.'" disabled>
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
            <input type="text" class="form-control" id="serial" placeholder="Enter Serial Number" value="'.$serial.'" disabled>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Model</label>
             <input type="text" class="form-control" id="model" placeholder="Enter Serial Number" value="'.$model.'" disabled>
          </div>
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Condition</label>
            <select type="text" class="form-control" id="condition" disabled>';

                if($condition == 'Functional')
                {
                  echo '<option selected>Functional</option>
                        <option>For Trade In</option>
                        <option>For Repair</option>
                        <option>Stored</option>';
                }
                elseif($condition == 'For Trade In')
                {
                 echo '<option>Functional</option>
                       <option selected>For Trade In</option>
                       <option>For Repair</option>
                       <option>Stored</option>';
                }
                elseif($condition == 'For Repair')
                {
                 echo '<option>Functional</option>
                       <option>For Trade In</option>
                       <option selected>For Repair</option>
                       <option>Stored</option>';
                }
                elseif($condition == 'Stored')
                {
                 echo '<option>Functional</option>
                       <option selected>For Trade In</option>
                       <option>For Repair</option>
                       <option selected>Stored</option>';
                }
                else
                {
                  echo '<option>Functional</option>
                        <option>For Trade In</option>
                        <option>For Repair</option>
                        <option>Stored</option>';
                }

            echo'</select>
          </div>
        </div><br>
        <div class="row">
          <div class="col-lg-4">
            <label for="exampleInputEmail1">Assigned To</label>
            <select type="text" class="form-control js-example-basic-single" id="assign_person" disabled>';

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

            echo'</select>
          </div>
         <div class="col-lg-4">
            <label>Date Transferred</label><br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control date-transfer" id="date_transfer" value="'.$transferred.'" disabled>
            </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-lg-7">
            <label for="exampleInputEmail1">Notes</label>
            <textarea type="text" class="form-control" id="notes" placeholder="Enter Notes" rows="5" disabled>'.$notes.'</textarea><br>
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
                <tbody>';

                      //get the transfer history data by asset id
                      $record->asset_id = $_POST['id'];

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

                         echo 
                          '<tr>
                            <td>'.$date.'</td>
                            <td>'.$from.'</td>
                            <td>'.$to.'</td>
                            <td>'.$row1['reason'].'</td>
                          </tr>';
                      }

                echo'</tbody>
              </table>
          </div>
          <div class="col-lg-5">
            <label for="exampleInputEmail1">Attach Image</label><br>
            <form name="form" method="post" action="" enctype="multipart/form-data">
              <img src = "'.$image.'" style="width:365px; height:225px;" id="preview_image"></input>
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
        </div>';
}

?>