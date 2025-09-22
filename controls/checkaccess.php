<?php
session_start();
include '../config/clsConnectionMain.php';
include '../objects/clsUser.php';

$database2 = new clsConnectionMain();
$db2 = $database2->connectMain();
$user = new Users($db2);

//check the role and access in main.access 
$user->user_id = $_SESSION['id'];
$user->system_id = 3; //AMS T&E
$get = $user->check_access();
if($row = $get->fetch(PDO::FETCH_ASSOC)){
    extract($row);
    if($row['count'] > 0){
        $_SESSION['role'] = $row['role'];
        echo 1;
    }else{
        echo 0;
    }
}
?>