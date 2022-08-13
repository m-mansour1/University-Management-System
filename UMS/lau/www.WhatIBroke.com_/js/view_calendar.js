/* Wait for DOM to load etc */
var branch= document.getElementById('txt_branch').value;
$(document).ready(function(){

	//Initialisations
	initialise_calendar();
	initialise_color_pickers();
	initialise_buttons();
	initialise_event_generation();
	initialise_update_event();
});


/* Initialise buttons */
function initialise_buttons(){

	$('.btn').button();
}


/* Binds and initialises event generation functionality */
function initialise_event_generation(){

	//Bind event
	$('#btn_gen_event').bind('click', function(){

		//Retrieve template event
		var template_event = $('#external_event_template').clone();
		var background_color = $('#txt_background_color').val();
		var border_color = $('#txt_border_color').val();
		var text_color = $('#txt_text_color').val();
		var title = $('#txt_title').val();
                 var instructor= $('#txt_instructor').val();
				 var branch= document.getElementById('txt_branch').value;
				 
		var description = $('#txt_description').val();
		var price = $('#txt_price').val(); 
		var available = $('#txt_available').val();

		//Edit id
		$(template_event).attr('id', get_uni_id());

		//Add template data attributes
		$(template_event).attr('data-background', background_color);
		$(template_event).attr('data-border', border_color);
		$(template_event).attr('data-text', text_color);
		$(template_event).attr('data-title', title);
                $(template_event).attr('data-instructor', instructor);
				
		$(template_event).attr('data-description', description);
		$(template_event).attr('data-price', price);
		$(template_event).attr('data-available', available);

		//Style external event
		$(template_event).css('background-color', background_color);
		$(template_event).css('border-color', border_color);
		$(template_event).css('color', text_color);

		//Set text of external event
		$(template_event).text(title);
                $(template_event).text(instructor);
		//Append to external events container
		$('#external_events').append(template_event);

		//Initialise external event
		initialise_external_event('#' + $(template_event).attr('id'));

		//Show
		$(template_event).fadeIn(2000);
	});
}


/* Initialise external events */
function initialise_external_event(selector){

	//Initialise booking types
	$(selector).each(function(){

		//Make draggable
		$(this).draggable({
			revert: true,
			revertDuration: 0,
			zIndex: 999,
			cursorAt: {
				left: 10,
				top: 1
			}
		});

		//Create event object
		var event_object = {
			title: $.trim($(this).text())
		};

		//Store event in dom to be accessed later
		$(this).data('eventObject', event_object);
	});
}


/* Initialise color pickers */
function initialise_color_pickers(){

	//Initialise color pickers
	$('.color_picker').miniColors({
		'trigger': 'show',
		'opacity': 'none'
	});
}


/* Initialises calendar */
function initialise_calendar(){

	//Initialise calendar
	$('#calendar').fullCalendar({
		theme: true,
		firstDay: 1,
		header: {
			left: 'today prev,next',
			center: 'title',
                        center: 'instructor',
			right: 'month,agendaWeek,agendaDay'
		},
		defaultView: 'agendaWeek',
		minTime: '6:00am',
		maxTime: '6:00pm',
		allDaySlot: false,
		columnFormat: {
			month: 'ddd',
			week: 'ddd dd/MM',
			day: 'dddd M/d'
		},
		eventSources: [
			{
				
				url: "http://localhost/AUCE/www.WhatIBroke.com_/json.php",
				editable: true
			}
		],
		droppable: true,
		drop: function(date, all_day){
			external_event_dropped(date, all_day, this);
		},
		eventClick: function(cal_event, js_event, view){
			calendar_event_clicked(cal_event, js_event, view);
		},
		editable: true
	});	

	//Initialise external events
	initialise_external_event('.external-event');
}


/* Handle an external event that has been dropped on the calendar */
function external_event_dropped(date, all_day, external_event){

	//Create vars
	var event_object;
	var copied_event_object;
	var duration = 60;
	var cost;

	//Retrive dropped elemetns stored event object
	event_object = $(external_event).data('eventObject');

	//Copy so that multiple events don't reference same object
	copied_event_object = $.extend({}, event_object);
	
	//Assign reported start and end dates
	copied_event_object.start = date;
	copied_event_object.end = new Date(date.getTime() + duration * 60000);
	copied_event_object.allDay = all_day;

	//Assign colors etc
	copied_event_object.backgroundColor = $(external_event).data('background');
	copied_event_object.textColor = $(external_event).data('text');
	copied_event_object.borderColor = $(external_event).data('border');

	//Assign text, price, etc
	copied_event_object.id = get_uni_id();
        copied_event_object.instructor = $(external_event).data('instructor');
	copied_event_object.title = $(external_event).data('title');
	copied_event_object.description = $(external_event).data('description');
	copied_event_object.price = $(external_event).data('price');
	copied_event_object.available = $(external_event).data('available');

	//Render event on calendar
	$('#calendar').fullCalendar('renderEvent', copied_event_object, true);
}


/* Initialise event clicks */
function calendar_event_clicked(cal_event, js_event, view){

	//Set generation values
	set_event_generation_values(cal_event.id, cal_event.backgroundColor, cal_event.borderColor, cal_event.textColor, cal_event.title, cal_event.instructor,cal_event.description, cal_event.price, cal_event.available);
}


/* Set event generation values */
function set_event_generation_values(event_id, bg_color, border_color, text_color, title,instructor, description, price, available){

	//Set values
	$('#txt_background_color').miniColors('value', bg_color);
	$('#txt_border_color').miniColors('value', border_color);
	$('#txt_text_color').miniColors('value', text_color);
	$('#txt_title').val(title);
        $('#txt_instructor').val(instructor);
	$('#txt_description').val(description);
	$('#txt_price').val(price);
	$('#txt_available').val(available);
	$('#txt_current_event').val(event_id);
}


/* Generate unique id */
function get_uni_id(){

	//Generate unique id
	return new Date().getTime() + Math.floor(Math.random()) * 500;
}


/* Initialise update event button */
function initialise_update_event(){
	var test = $('#calendar').fullCalendar( 'clientEvents');
	//Bind event
	$('#btn_update_event').bind('click', function(){

		//Create vars
		var current_event_id = $('#txt_current_event').val();

		//Check if value found
		if(current_event_id){

			//Retrieve current event
			var current_event = $('#calendar').fullCalendar('clientEvents', current_event_id);

			//Check if found
			if(current_event && current_event.length == 1){

				//Retrieve current event from array
				current_event = current_event[0];

				//Set values
				current_event.backgroundColor = $('#txt_background_color').val();
				current_event.textColor = $('#txt_text_color').val();
				current_event.borderColor = $('#txt_border_color').val();
				current_event.title = $('#txt_title').val();
                                 current_event.instructor = $('#txt_instructor').val();
				current_event.description = $('#txt_description').val();
				current_event.price = $('#txt_price').val();
				current_event.available = $('#txt_available').val();

				//Update event
				$('#calendar').fullCalendar('updateEvent', current_event);
			}
		}
	});
}