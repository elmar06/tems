<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

$get = $asset->get_asset_for_repair();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    //check the date if null
    $date1 = $row['date_repair'];
    $date2 = $row['date_return'];
    if($date1 == ''){
    $date1 = '-';
    }else{
    $date1 = date('F j, Y', strtotime($row['date_repair']));
    }
    if($date2 == ''){
    $date2 = '-';
    }else{
    $date2 = date('F j, Y', strtotime($row['date_return']));
    } 

    echo '
    <tr>
        <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['asset_id'].'"></td>
        <td>'.$row['code'].'</td>
        <td style="max-width: 200px;">'.$row['description'].'</td>
        <td><center>'.$row['location'].'</center></td>
        <td><center>'.$date1.'</center></td>
        <td><center>'.$date2.'</center></td>
        <td style="max-width: 200px;">'.$row['repair_remark'].'</td>
        </tr>';
}
?>