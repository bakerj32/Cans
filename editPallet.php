<?php
	include('includes/preferences.php');
	$con = mysql_connect($server, $dbusername, $dbpassword);
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db, $con);
	
	include('functions.php');
	
	$mode = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['mode']);
	$id = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['id']);
	if($mode == 'delete'){
		mysql_query("DELETE FROM pallets WHERE id = '".$id."'");
		mysql_query("DELETE FROM skus WHERE pallet_id = '".$id."'");
		
		header('Location: index.php');
	}
	
	else if($mode == 'edit'){
		$skusQuery = mysql_query("SELECT * FROM skus WHERE pallet_id = '".$id."'");
		$html = '<form action="update.php?mode=sku" method="post">
				<table>
					<tr>
						<th>SKU</th>
						<th>Qty.</th>
						<th>Take All</th>
					</tr>';
		while($sku = mysql_fetch_assoc($skusQuery)){
			$html .= '<tr>
						<td>'.$sku['sku'].'</td>
						<td><input size="4" type="text" value="'.$sku['qty'].'" name="qty[]" />
						<input type="hidden" value="'.$sku['id'].'" name="id[]" /></td>
						<td><a href="update.php?mode=delete&id='.$sku['id'].'">Take All</a></td>
					</tr>';
		}
		$html .= '</table><input type="submit" /></form>';
		echo $html;
	}
	
	
?>