<?php

	include('includes/preferences.php');
	$con = mysql_connect($server, $dbusername, $dbpassword);
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db, $con);
	include('functions.php');

	$skus = $_POST['sku'];
	$qtys = $_POST['qty'];
	$palletType = $_POST['pallet-type'];
	$line = array('sku' => '', 'qty' => '');
	
	// Insert newly created pallets
	if($palletType == 'new'){
		$canId = $_POST['can-select-add'];
		$palletDescription = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['palletName']);
		mysql_query("INSERT INTO pallets (can_id, description) VALUES ('".$canId."', '".$palletDescription."')");
	}
	
	for($i = 0;$i < count($skus); $i++){
		if($skus[$i] != '' && $qtys[$i] != ''){
			$line['sku'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$skus[$i]);
			$line['qty'] = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$qtys[$i]);
			
			// Unpalletized Parts
			if($palletType == 'unpalletized'){
				$canId = $_POST['can-select-add'];
				mysql_query("INSERT INTO skus (can_id, sku, qty) VALUES ('".$canId."', '".$line['sku']."', '".$line['qty']."')");
			}
				
			// Create new Pallet
			else if($palletType == 'new'){				
				// Get ID of newly created pallet
				$nextId = intval(getNextPalletId());
				
				mysql_query("INSERT INTO skus (can_id, pallet_id, sku, qty) VALUES ('".$canId."', '".$nextId."', '".$line['sku']."', '".$line['qty']."')");
			}
			// Add to existing Pallet
			else if($palletType == 'existing'){
				$palletId = $_POST['pallet-select'];
				$canIdQuery = mysql_query("SELECT can_id FROM pallets WHERE id = '".$palletId."'");
				$canId = mysql_fetch_row($canIdQuery);
				
				mysql_query("INSERT INTO skus (can_id, pallet_id, sku, qty) VALUES ('".$canId[0]."', '".$palletId."', '".$line['sku']."', '".$line['qty']."')");
			}
		}
	}
	
	
	mysql_close($con);
	
	header('Location: index.php');
?>