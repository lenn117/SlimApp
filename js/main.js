// The root URL for the RESTful services
var rootURL = "http://localhost/slimapp/index.php/";
var currentCar;

// Retrieve car list when application starts
findAll();

// Nothing to delete in initial application state
$('#btnDelete').hide();

// Register listeners
$('#btnSearch').click(function() {
	search($('#searchKey').val());
	return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function(e) {
	if (e.which == 13) {
		search($('#searchKey').val());
		e.preventDefault();
		return false;
	}
});

$('#btnAdd').click(function() {
	newCar();
	return false;
});

$('#btnSave').click(function() {
	if ($('#carId').val() == '')
		addCar();
	else
		updateCar();
	return false;
});

$('#btnDelete').click(function() {
	deleteCar();
	return false;
});

$('#carList a').live('click', function() {
	findById($(this).data('identity'));
});

function search(searchKey) {
	if (searchKey == '')
		findAll();
	else
		findByName(searchKey);
}

function newCar() {
	$('#btnDelete').hide();
	currentCar = {};
	renderDetails(currentCar); // Display empty form
}

function findAll() {
	console.log('findAll');
	$.ajax({
		type : 'GET',
		url : rootURL + 'cars',
		dataType : "json", // data type of response
		success : renderList
	});
}

function findByName(searchKey) {
	console.log('findByName: ' + searchKey);
	$.ajax({
		type : 'GET',
		url : rootURL + 'cars/search/' + searchKey,
		dataType : "json",
		success : renderList
	});
}

function findById(id) {
	console.log('findById: ' + id);
	$.ajax({
		type : 'GET',
		url : rootURL + 'cars/' + id,
		dataType : "json",
		success : function(data) {
			$('#btnDelete').show();
			console.log('findById success: ' + data.id);
			currentCar = data;
			renderDetails(currentCar);
		}
	});
}

function addCar() {
	console.log('addCar');
	$.ajax({
		type : 'POST',
		contentType : 'application/json',
		url : rootURL + 'cars',
		dataType : "json",
		data : formToJSON(),
		success : function(data, textStatus, jqXHR) {
			console.log('Car has been added successfully');
			$('#btnDelete').show();
			$('#carId').val(data.id);
			findAll();
		},
		error : function(jqXHR, textStatus, errorThrown) { console.log('addCar error: ' + textStatus); }
	});
}

function updateCar() {
	console.log('updateCar');
	$.ajax({
		type : 'PUT',
		contentType : 'application/json',
		url : rootURL + 'cars/' + $('#carId').val(),
		dataType : "json",
		data : formToJSON(),
		success : function(data, textStatus, jqXHR) { console.log('Car details updated successfully'); },
		error : function(jqXHR, textStatus, errorThrown) { console.log('updateCar error: ' + textStatus); }
	});
}

function deleteCar() {
	console.log('deleteCar');
	$.ajax({
		type : 'DELETE',
		url : rootURL + 'cars/' + $('#carId').val(),
		success : function(data, textStatus, jqXHR) { console.log('Car & details deleted successfully');},
		error : function(jqXHR, textStatus, errorThrown) { console.log('deleteCar error'); }
	});
	findAll();
}

function renderList(data) {
	var list = data == null ? [] : (data instanceof Array ? data : [ data ]);
	$('#carList li').remove();
	$.each(list, function(index, car) {
		$('#carList').append('<li><a data-identity="' + car.id + '">' + car.name + '</a></li>');
	});
}

function renderDetails(car) {
	$('#carId').val(car.id);
	$('#name').val(car.name);
	$('#model').val(car.model);
	$('#year').val(car.year);
	$('#prevOwner').val(car.prevOwner);
}

// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
	return JSON.stringify({
		"id" : $('#carId').val(),
		"name" : $('#name').val(),
		"model" : $('#model').val(),
		"year" : $('#year').val(),
		"prevOwner" : $('#prevOwner').val(),
	});
}
