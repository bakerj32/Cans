<?php
	include('includes/preferences.php');
	$con = mysql_connect($server, $dbusername, $dbpassword);
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db, $con);
	include('functions.php');
	
	$mode = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['mode']);
	
	if($mode == 'delete'){
		$id = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['id']);
		mysql_query("DELETE FROM skus WHERE id = '".$id."'");
	}
	elseif($mode == 'transfer'){
		$palletId = $_POST['palletId'];
		$canId = $_GET['canid'];
		mysql_query("UPDATE pallets SET can_id = '".$canId."' WHERE id = '".$palletId."'");
		mysql_query("UPDATE skus SET can_id = '".$canId."' WHERE pallet_id = '".$palletId."'");
	}
	else{
		$qtys = $_POST['qty'];
		$ids = $_POST['id'];
		
		for($i = 0; $i < count($qtys); $i++){
			mysql_query("UPDATE skus SET qty = '".$qtys[$i]."' WHERE id = '".$ids[$i]."'");
		}
	}
	header('Location: index.php');
?> 