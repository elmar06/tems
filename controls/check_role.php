<?php
	session_start();
	if($_SESSION['role'] == 2)//Admin
	{
		header('Location: ../pages/admin/home.php');
	}
	elseif($_SESSION['role'] == 3)//PMO Admin
	{
		header('Location: ../pages/pmo/home.php');
	}
    elseif($_SESSION['role'] == 4)//KENZO Timekeeper
	{
		header('Location: ../pages/kenzo/home.php');
	}
	else//KENZO Toolkeeper
	{
		header('Location: ../pages/tool-keeper/home.php');
	}
?>