<?php
	function getCanList(){
		$cans = array();
		$canQuery = mysql_query("SELECT id, name FROM cans ORDER BY id ASC");
		while($can = mysql_fetch_assoc($canQuery)){
			array_push($cans, $can);
		}
		return $cans;
	}
	
	function getPalletList(){
		$pallets = array();
		$palletQuery = mysql_query("SELECT id, description, can_id FROM pallets ORDER BY description ASC");
		while($pallet = mysql_fetch_assoc($palletQuery)){
			array_push($pallets, $pallet);
		}
		return $pallets;
	}
	
	function getCanContents($canId){
		$skus = array();
		//Get Palletized Skus
		$canQuery = mysql_query("SELECT skus.id as sid, skus.sku, skus.qty, skus.can_id, skus.pallet_id, pallets.* FROM skus, pallets WHERE skus.can_id = '".$canId."' AND skus.pallet_id = pallets.id ORDER BY pallet_id");
		while($sku = mysql_fetch_assoc($canQuery)){
			array_push($skus, $sku);
		}
		//Get Unpalletized Skus
		$canQuery = mysql_query("SELECT id as sid, sku, qty, can_id, pallet_id FROM skus WHERE can_id = '".$canId."' AND pallet_id = 0 ORDER BY sku");
		while($sku = mysql_fetch_assoc($canQuery)){
			$sku['description'] = 'Unpalletized';
			array_push($skus, $sku);
		}
		return $skus;
	}
	
	function getSearchResults($query){
		$skus = array();
		// Search for exact match
		$resultsQuery = mysql_query("SELECT * FROM skus WHERE sku = '".$query."' ORDER BY can_id");
		$count = 0;
		while($sku = mysql_fetch_assoc($resultsQuery)){
			array_push($skus, $sku);
			$count++;
		}
		// If none found, search with LIKE
		if($count == 0){
			$resultsQuery = mysql_query("SELECT * FROM skus WHERE sku LIKE '".$query."%' ORDER BY can_id");
			while($sku = mysql_fetch_assoc($resultsQuery)){
				array_push($skus, $sku);
			}
		}
		return $skus;
	}
	
	function getNextPalletId(){
		$idQuery = mysql_query("SELECT id FROM pallets ORDER BY last_updated DESC LIMIT 1");
		$id = mysql_fetch_row($idQuery);
		return $id[0];
	}
?>