function getCanListing(){

	var url = "listing.php?mode=list"; // the script where you handle the form input.

	$.ajax({

		   type: "POST",

		   url: url,

		   data: $("#canListingForm").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   document.getElementById('results').innerHTML = data // show response from the php script.

		   }

		 });

	return false; // avoid to execute the actual submit of the form.

}

function getCanListingIntro(){

	var url = "listing.php?mode=list"; // the script where you handle the form input.

	$.ajax({

		   type: "POST",

		   url: url,

		   data: $("#canListingFormIntro").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   document.getElementById('results').innerHTML = data // show response from the php script.

		   }

		 });

	return false; // avoid to execute the actual submit of the form.

}



function getQuery(){

	var url = "listing.php?mode=search"; // the script where you handle the form input.

	$.ajax({

		   type: "POST",

		   url: url,

		   data: $("#skuSearchForm").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   document.getElementById('results').innerHTML = data // show response from the php script.

		   }

		 });

	return false; // avoid to execute the actual submit of the form.

}



function getQueryIntro(){

	var url = "listing.php?mode=search"; // the script where you handle the form input.

	$.ajax({

		   type: "POST",

		   url: url,

		   data: $("#skuSearchFormIntro").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   document.getElementById('results').innerHTML = data // show response from the php script.

		   }

		 });

	return false; // avoid to execute the actual submit of the form.

}

			

function addRow(){

	document.getElementById('addSkus').innerHTML += '<tr><td><input type="text" id="sku[]" name="sku[]" /></td><td><input type="text" id="qty[]" name="qty[]" /></td></tr>';

}

function addPalletRow(){

	document.getElementById('addSkusToPallet').innerHTML += '<tr><td><input type="text" id="sku[]" name="sku[]" /></td><td><input type="text" id="qty[]" name="qty[]" /></td></tr>';

}



function updateForm(e){

	if(e.value == 'unpalletized'){

		document.getElementById('pallet-select').disabled = true;

		document.getElementById('palletName').disabled = true;

		document.getElementById('can-select-add').disabled = false;

	}

	else if(e.value == 'new'){

		document.getElementById('palletName').disabled = false;

		document.getElementById('pallet-select').disabled = true;

		document.getElementById('can-select-add').disabled = false;

	}

	else if(e.value == 'existing'){

		document.getElementById('pallet-select').disabled = false;

		document.getElementById('palletName').disabled = true;

		document.getElementById('can-select-add').disabled = true;

	}

	

}



function transferCan(form){

	var id = $(form).find(":selected").val();

	var url = "update.php?mode=transfer&canid=" + id; // the script where you handle the form input.

	$.ajax({

		   type: "POST",

		   url: url,

		   data: $("#transferForm").serialize(), // serializes the form's elements.

		   success: function(data)

		   {

			   document.getElementById('results').innerHTML = '<h3>Pallet successfully transferred</h3>'; // show response from the php script.

		   }

		 });

	return false; // avoid to execute the actual submit of the form.

}

