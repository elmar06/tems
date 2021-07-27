<?php
include '../config/clsConnection.php';
include '../objects/clsRepairHistory.php';

$database = new clsConnection();
$db = $database->connect();

$repair = new RepairHistory($db);

$get = $repair->view_repair_history();
while($row = $get->fetch(PDO::FETCH_ASSOC))
{
    //check the date if null
    $date1 = $row['date_repair'];
    $date2 = $row['date_returned'];
    if($date1 == ''){
        $date1 = '-';
    }else{
        $date1 = date('F j, Y', strtotime($row['date_repair']));
    }
    if($date2 == ''){
        $date2 = '-';
    }else{
        $date2 = date('F j, Y', strtotime($row['date_returned']));
    } 

    echo '
    <tr>
        <td>'.$row['code'].'</td>
        <td style="max-width: 200px;">'.$row['description'].'</td>
        <td><center>'.$row['location'].'</center></td>
        <td><center>'.$date1.'</center></td>
        <td><center>'.$date2.'</center></td>
        <td style="max-width: 200px;">'.$row['remarks'].'</td>
    </tr>';
}

?>