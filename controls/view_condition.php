<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';
include '../objects/clsPersonnel.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);
$person = new Personnel($db);

$asset->id = $_POST['id'];
$view = $asset->get_asset_byID();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
    // Change the line below to your timezone!
    date_default_timezone_set('Asia/Manila');
    echo '
    <div class="form-group">
        <div class="row">
        <div class="col-lg-6">
            <label for="exampleInputEmail1">T&E Barcode</label>
            <input type="text" class="form-control" id="toolcode" value="'.$row['code'].'" disabled>
            <input type="text" class="form-control" id="id" value="'.$row['asset_id'].'" disabled style="display:none">
        </div>
        <div class="col-lg-6">
            <label for="exampleInputEmail1">Assignee</label>';

                $view = $person->view_person();
                while($row1 = $view->fetch(PDO::FETCH_ASSOC))
                {
                  if($row['assign'] == $row1['person_id'])
                  {
                    echo '<input type="text" class="form-control" id="assignee" value="'.$row['fullname'].'" disabled>';
                  }             
                }
            
            echo '
        </div>
        </div><br>
        <div class="row">
        <div class="col-lg-12">
            <label for="exampleInputEmail1">Tool Description</label>
            <textarea type="text" class="form-control" id="decription" rows="4" disabled>'.$row['description'].'</textarea>
        </div>
        </div><br>
        <div class="row">
            <div class="col-sm-6">
                <label>Status:</label><br>
                <select id="condition" type="text" class="form-control" style="width: 100%">
                    <option value="0" selected disabled>Please select a Tool Condition</option>
                    <option value="Under Repair">Mark as Under Repair</option>
                    <option value="Functional">Mark as Repaired</option>
                </select>
            </div>
            <div class="col-lg-6">
            <label for="exampleInputEmail1">Remarks</label>
            <textarea type="text" class="form-control" id="remarks" rows="4">'.$row['repair_remark'].'</textarea>   
            </div>
        </div>
    </div>
    <div id="upd-warning" class="alert alert-danger" role="alert" style="display: none"></div>
    <div id="upd-success" class="alert alert-success" role="alert" style="display: none"></div>';
}
?>