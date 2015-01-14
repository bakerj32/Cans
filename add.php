<?php
	include('includes/preferences.php');
	$con = mysql_connect($server, $dbusername, $dbpassword);
	if (!$con){
	  die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($db, $con);
	
	include('functions.php');
	
	$cans = getCanList();
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script src="js/functions.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function(){
				$("#tabs").tabs();
			});
			
			function addRow(){
				document.getElementById('addSkus').innerHTML += '<tr><td><input type="text" id="sku[]" name="sku[]" /></td><td><input type="text" id="qty[]" name="qty[]" /></td></tr>';
			}
			function addPalletRow(){
				document.getElementById('addSkusToPallet').innerHTML += '<tr><td><input type="text" id="sku[]" name="sku[]" /></td><td><input type="text" id="qty[]" name="qty[]" /></td></tr>';
			}
		</script>
	</head>
	<body>
 
		<div id="tabs">
		  <ul>
			<li><a href="#tabs-1">Add Parts</a></li>
			<li><a href="#tabs-2">Create Pallet</a></li>
		  </ul>
		  <div id="tabs-1">
			<form action="addResponse.php?mode=sku" method="post">
				<label>Add To Can: <select name="can-select" id="can-select">
					<?php
						foreach($cans as $can){
							print '<option value="'.$can['id'].'">'.$can['name'].'</option>';
						}
					?>
				</select></label><br />
				<table id="addSkus">
					<tr>
						<th>Sku</th>
						<th>Qty.</th>
					</tr>
					<tr>
						<td><input type="text" name="sku[]" /></td>
						<td><input type="text" name="qty[]" /></td>
					</tr>
				</table>
				<button type="button" onClick="addRow()">Add Row</button>
				<input type="submit" />
			</form>
		  </div>
		  <div id="tabs-2">
			<form action="addResponse.php?mode=pallet" method="post">
				<label>Add To Can: <select name="can-select" id="can-select">
					<?php
						foreach($cans as $can){
							print '<option value="'.$can['id'].'">'.$can['name'].'</option>';
						}
					?>
				</select></label><br />
				<label>Pallet Description: <input type="text" name="description" id="description" /></label><br />
				<table id="addSkusToPallet">
					<tr>
						<th>Sku</th>
						<th>Qty.</th>
					</tr>
					<tr>
						<td><input type="text" name="sku[]" /></td>
						<td><input type="text" name="qty[]" /></td>
					</tr>
				</table>
				<button type="button" onClick="addPalletRow()">Add Row</button>
				<input type="submit" />
				
			</form>
		  </div>
		</div>
		 
		 
	</body>
</html>