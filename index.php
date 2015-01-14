<?php 

	include('includes/preferences.php');

	$con = mysql_connect($server, $dbusername, $dbpassword);

	if (!$con){

	  die('Could not connect: ' . mysql_error());

	}

	mysql_select_db($db, $con);

	

	include('functions.php');

	

	$cans = getCanList();

	$pallets = getPalletList();

	

?>



<html>

	<head>

		<link rel="stylesheet" type="text/css" href="css/styles.css">

		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

		<script src="js/jquery.js" type="text/javascript"></script>

		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

		<script src="js/functions.js" type="text/javascript"></script>

		<script type="text/javascript">

			$(document).ready(function(){

				$("#tabs").tabs();

				$("#skuSearchForm").submit(function() {

					getQuery();

					return false;

				});

				

				$("#skuSearchFormIntro").submit(function() {

					getQueryIntro();

					return false;

				});

			});

		</script>

	</head>

	<body>

		<div id="container">

			<div id="header">

				<a href="index.php"><img style="float: left; margin-bottom: 10px" src="logo.gif" /></a>

				

				

				<!-- Sku Search -->

				<form action="listing.php?mode=search" method="post" id="skuSearchForm" >

					<label><b>Or Search By SKU:</b></label><input type="text" id="query" name="query" />

					<button type="button" name="submitQuery" id="submitQuery" onClick="getQuery()">Search</button>

				</form>

				

				<form action="listing.php?mode=list" method="post" id="canListingForm">

					<label><b>Display Can Contents:</b></label><select name="can-select" id="can-select" onchange="getCanListing()">

						<?php

							foreach($cans as $can){

								print '<option value="'.$can['id'].'">'.$can['name'].'</option>';

							}

						?>

					</select>

					<button type="button" name="submitCanListing" id="submitCanListing" onClick="getCanListing()">List</button>

				</form>

			</div>

			<div id="mainbody">

				<div id="tabs" style="height:auto;">

				  <ul>

					<li><a href="#results">Results</a></li>

					<li><a href="#add">Add Parts</a></li>

					<li><a href="#diagram">Can Diagram</a></li>

					

				  </ul>

				  <div id="results">

					<center>

						

						<h3>Search  By SKU</h3>

						<!-- Sku Search -->

						<form style="float: none;" action="listing.php?mode=search" method="post" id="skuSearchFormIntro" >

							<input type="text" id="queryIntro" name="queryIntro" />

							<button type="button" name="submitQuery" id="submitQuery" onClick="getQueryIntro()">Search</button>

						</form>

						<h3>Or Display Can Contents:</h3>

						<form style="float: none;" action="listing.php?mode=list" method="post" id="canListingFormIntro">

							<select name="can-select" id="can-select" onchange="getCanListingIntro()">

								<?php

									foreach($cans as $can){

										print '<option value="'.$can['id'].'">'.$can['name'].'</option>';

									}

								?>

							</select>

							<button type="button" name="submitCanListingIntro" id="submitCanListingIntro" onClick="getCanListingIntro()">List</button>

						</form>

					</center>

				  </div>

				  <div id="add">

					<form action="addResponse.php?mode=pallet" method="post">

						<span style="font-size: 20px;"><label><b>Add To Can: </b></span><select name="can-select-add" id="can-select-add">

							<?php

								foreach($cans as $can){

									print '<option value="'.$can['id'].'">'.$can['name'].'</option>';

								}

							?>

						</select></label><br />

						<input onchange="updateForm(this)" type="radio" name="pallet-type" value="unpalletized" checked/>Unpalletized</br >

						<input onchange="updateForm(this)" type="radio" name="pallet-type" value="new" />New Pallet <input type="text" name="palletName" id="palletName" disabled="disabled" /><br />

						<input onchange="updateForm(this)" type="radio" name="pallet-type" value="existing" />Existing Pallet <select name="pallet-select" id="pallet-select" disabled="disabled">

							<?php

								

								foreach ($pallets as $pallet){

									print '<option value="'.$pallet['id'].'">'.$pallet['description'].'</option>';

								}

							?>

						</select><br /><br />

						<table id="addSkusToPallet">

							<tr>

								<th>Sku</th>

								<th>Qty.</th>

							</tr>

							<tr>

								<td><input type="text" name="sku[]" /></td>

								<td><input type="text" name="qty[]" /></td>

							</tr>

							<tr>

								<td><input type="text" name="sku[]" /></td>

								<td><input type="text" name="qty[]" /></td>

							</tr>

							<tr>

								<td><input type="text" name="sku[]" /></td>

								<td><input type="text" name="qty[]" /></td>

							</tr>

							<tr>

								<td><input type="text" name="sku[]" /></td>

								<td><input type="text" name="qty[]" /></td>

							</tr>

							<tr>

								<td><input type="text" name="sku[]" /></td>

								<td><input type="text" name="qty[]" /></td>

							</tr>

						</table>

						<input type="submit" />

						<button type="button" onClick="addPalletRow()">Add Row</button>

					</form>

					</div>

					<div id="diagram"><center><h3>Can Diagram</h3><img style="border: 1px solid black;" src="candiagram.png" /></center></div>

				  </div>

				</div>

			</div>

			<div id="footer">

			</div>

		</div>

	</body>

</html>