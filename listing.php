<?php

	include('includes/preferences.php');
	$con = mysql_connect($server, $dbusername, $dbpassword);
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db, $con);
	
	include('functions.php');
	
	$mode = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '',$_GET['mode']);
	
	if($mode == 'list'){
		$canId = $_POST['can-select'];
		$skus = getCanContents($canId);
		$cans = getCanList();
		
		$html = '<p>Showing results for can '.$canId.'</p>
				<form action="update.php?mode=sku" method="post">';
		$pallet_id = -1;
		$count = 0;
		foreach($skus as $sku){
		
			if($sku['pallet_id'] != $pallet_id){
				if($count == 0){ 
					$html .= '<table id="pallet-table">';
					// Display Edit options of Pallets
					if($sku['pallet_id'] != 0){
						$html .= '<tr>
									<th align="left">'.$sku['description'].'</th>
									<th><a href="editPallet.php?mode=delete&id='.$sku['pallet_id'].'">[Take All]</a></th>
									<th><form id="transferForm">
									<input type="hidden" name="palletId" value="'.$sku['pallet_id'].'" />
									<select name="can-select-transfer[]" id="can-select-transfer" onchange="transferCan(this)">
									<option value="0">Transfer Pallet</option>';		
									foreach($cans as $can){
										$html .= '<option value="'.$can['id'].'">'.$can['name'].'</option>';
									}
						$html .= '</select></form></th>
								</tr>'; 
					}
					else{
						$html .= '<tr>
									<th align="left">'.$sku['description'].'</th>
									<th></th>
									<th></th>
								  </tr>';
					}
					$count += 1; 
				}
				else{
					if($sku['pallet_id'] != 0){
						$html .= '<tr>
									<th align="left">'.$sku['description'].'</th>
									<th><a href="editPallet.php?mode=delete&id='.$sku['pallet_id'].'">[Take All]</a></th>
									<th><form id="transferForm">
									<input type="hidden" name="palletId" value="'.$sku['pallet_id'].'" />
									<select name="can-select-transfer[]" id="can-select-transfer" onchange="transferCan(this)">
									<option value="0">Transfer Pallet</option>';
									foreach($cans as $can){
										$html .= '<option value="'.$can['id'].'">'.$can['name'].'</option>';
									}
						$html .= '</select></form></th>
									</tr>'; 
						$count += 1; 
					}
					else{
						$html .= '<tr>
									<th align="left">'.$sku['description'].'</th>
									<th></th>
									<th></th>
								   </tr>';
					}
				}
			}
			$html .= '<tr>
							<td>'.$sku['sku'].'</td>
							<td align="center"><a href="update.php?mode=delete&id='.$sku['sid'].'">Take All</a></td>
							<td align="center">Qty: <input size="4" type="text" value="'.$sku['qty'].'" name="qty[]" />
								<input type="hidden" value="'.$sku['sid'].'" name="id[]" /></td>
						</tr>';
			
			$pallet_id = $sku['pallet_id'];
		
		}
		$html .= '</table><input type="submit" /></form>';
	}
	
	else if($mode == 'search'){
		if(empty($_POST['query'])){$query = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['queryIntro']); }
		else{
			$query = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_POST['query']);
		}
		$skus = getSearchResults($query);
		$html = '<h3>Showing results for "'.$query.'"</h3>';
		$can_id = -1;
		foreach($skus as $sku){
			if($sku['can_id'] != $can_id){
				$html .= '<h4>'.$query.' in Can '.$sku['can_id'].'</h4>';
			}
			$html .= '<p><b>'.$sku['sku'].'</b> - Quantity: '.$sku['qty'].'</p>';
			
			$can_id = $sku['can_id'];
		}
		
	}
	echo $html;
?>