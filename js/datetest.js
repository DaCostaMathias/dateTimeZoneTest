/*
 * I would like you to implement the functions AddTime, SubTime, Confirm and Delete.
 * AddDate needs to be modified to add the timezone if a timezone has been selected.
 * There are bonus points for combining AddTime.php and SubTime.php into a single script.
 */

var itemIterator = 0;
var itemInUse;
$(document).ready(function() {
	//init the datetime picker
	 $(function () {
		 $('#datetimepicker').datetimepicker({
			validateOnBlur:true,
			dayOfWeekStart : 1,
			lang:'en',
			step:10
});
     });
	 //init the listener on button
	$('#add_btn').on('click', AddDate);
	$('#addtime_btn').on('click', AddTime);
	$('#subtract_btn').on('click', SubTime);
	$('#confirm_btn').on('click', Confirm);
	$('#tzchange_btn').on('click', TZChange);
	
	
});

function AddDate(e) {
	e.preventDefault();

	if ( $('#datetimepicker').val() == "" )
	{
		$(".alert").removeClass("in").show();
		$(".alert").delay(200).addClass("in").fadeOut(2000);
		return false;
	}
	
	var offset = 0;
	var display = "";
	//get the value from the timezone selector
	var tzselected = $('#timezone option:selected').val();
	
	//if no option selected
	if (tzselected == "false") {
		//use the users local timezone
		offset = (new Date()).getTimezoneOffset();
		
	}
	else  {
			
	//create the offset for the timezone selected
	var tz= tzselected.split(':');
	//calcul of the offset for the time zone selected(difference between UTC/GMT time in minute)
	offset = ((tz[0])*60)*-1;
	
	
	}
	//init the string before display
	if (offset <= 0) {
		display = $('#datetimepicker').val() + "+" + ("00" + (Math.abs(offset) / 60)).slice(-2);
	} else {
		display = $('#datetimepicker').val() + "-" + ("00" + (offset / 60)).slice(-2);
	}

	//add the new <div> with the time and timezone selected
	$('#dates_div').append(
		$("<div>", { id: "test"}).append(
			
			$("<p>", {
				//replace T by " " to look more humain
				text: display.replace("T", " "),
				//create an id with a number
				id: "date"+itemIterator
			}),
			$("<button>", {
				class: "btn btn-default",
				text: "transform",
				click: Transform
			}),
			$("<button>", {
				class: "btn btn-default",
				text: "delete",
				click: Delete
			})
		)
	);
	//incrementation of the number for id
	itemIterator++;
	
}

function Delete(e) {
	e.preventDefault();
	// Remove the selected div
	this.parentElement.remove();
}

function Transform(e) {
	e.preventDefault();
	// Create a transform div
	itemInUse = $(this).siblings('p').attr('id');
	
	$("#datetime_placeholder").text($($(e.target).siblings("p")[0]).text());
	$("#datetime_placeholder").css("text-align","center");
	$("#transform_div").css("display", "");
}

/*
 * This function takes the modified time and places it back in it's original position
 * Also hides the transform div
 * e: event that triggered it
 */
function Confirm(e) {
	e.preventDefault();
	//get the new value and update the former <div>
	$('#'+itemInUse).text($('#datetime_placeholder').text());
	//hide the transform <div>
	$("#transform_div").css("display", "none");
	return false;
}

/*
 * Adds the corresponding values to the date using a php script
 * Updates the #datetime_placeholder value after each addition
 * e: event that triggered it
 */
function AddTime(e) {
e.preventDefault();
	//get the date we want to change
	var orig = $('#datetime_placeholder').text();
	//init the value at 0 
	var days = 0;
	var hours = 0;
	var mins = 0;
	//action the serveur should perform
	var action = "add";
	
	//get the value from the textbox
	if($('#days').val() != "")
		days = $('#days').val();
		
	if($('#hours').val() != "")
		hours = $('#hours').val();
		
	if(	$('#minutes').val() != "")
		mins = $('#minutes').val();
		
	//asynchrone call, defaul methode = GET
	$.ajax({
		//to ManipulateTime.php
		url: "ManipulateTime.php",
		//init the query
		data: { action: action, orig: orig, days: days, hours: hours, mins: mins },
		success: function(response) {
			//update the field with the new value
			$('#datetime_placeholder').text(response);
		}
	});

	return false;
}

/*
 * Subtracts the corresponding values to the date using a php script
 * Updates the #datetime_placeholder value after each subtraction
 * e: event that triggered it
 */
function SubTime(e) {
	e.preventDefault();
	//get the date we want to change
	var orig = $('#datetime_placeholder').text();
	//init the value at 0 
	var days = 0;
	var hours = 0;
	var mins = 0;
	//action the serveur should perform
	var action = "sub";
	
	//get the value from the textbox
	if($('#days').val() != "")
		days = $('#days').val();
		
	if($('#hours').val() != "")
		hours = $('#hours').val();
		
	if(	$('#minutes').val() != "")
		mins = $('#minutes').val();

	//asynchrone call, defaul methode = GET
	$.ajax({
		//to ManipulateTime.php
		url: "ManipulateTime.php",
		//init the query
		data: { action: action, orig: orig, days: days, hours: hours, mins: mins },
		success: function(response) {
			//update the field with the new value
			$('#datetime_placeholder').text(response);
		}
	});

	return false;
}

/*
 * Takes a datetime and changes the time into that timezone
 * eg. 2016-08-08 12:00:00+12 (Pacific/Auckland) changes to 2016-08-08 01:00:00+01 (Africa/Bangui)
 */
function TZChange(e) {
e.preventDefault();
	//get the initial value
	var orig = $('#datetime_placeholder').text();
	//get the new timezone
	var toArea;
	//if none selected we get the user's local timezone
	if ( $('#timezone_change option:selected').val() == "false")
		{toArea =moment.tz.guess();}
	else
		toArea = $('#timezone_change option:selected').val().replace(" ","_");
	
	//formate the string for momentjs
	var formatedDate =orig.replace(/[/]/g,"-");
	//change the timezone of the date and get it with the wanted format with moment-timezonejs
	var dateTransformed = moment.tz(formatedDate, toArea).format("YYYY/MM/DD HH:mmZ");
	//dysplay the new date with the different timezon without the 3 last characteres(minutes of the timezone offset); 
	$('#datetime_placeholder').text(dateTransformed.substr(0,19));
	
	

} 