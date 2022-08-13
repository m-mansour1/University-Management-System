<!doctype html>
<html>

<head>
	<!-- Title etc -->
	<title>Calendar</title>

	<!-- Stylesheets etc -->
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.9.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="css/fullcalendar.css" />
	<link rel="stylesheet" type="text/css" href="css/view_calendar.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.miniColors.css" />
</head>

<BODY aLink=#FFFFFF bgColor=#9dbbf8 leftMargin=0 link=#000066>

	</table>

	<style type="text/css">
		style .imagebox {
			width: 100%;
			height: 100%;
			background-image: url("images\log.jpg");
			background-repeat: no-repeat;
			background-position: 50% 50%;
		}

		INPUT {
			background-color: white;
			color: black;
			font-family: cooper black;
			font-size: 20 pt
		}
	</style>


	</td>
	</tr>
	</table>
	<br>



	<body>

		<!-- Content Wrapper -->
		<div id="content_wrapper">

			<!-- Calendar div -->
			<div id="calendar">
			</div>

			<!-- Event generation -->
			<div id="event_generation_wrapper" style="display: none">


				<input id='txt_title' type='hidden' value='Title' /><br />
				<input id='txt_instructor' type='hidden' value='instructor' /><br />
				<input id='txt_branch' type='hidden' value="<?php echo $d6; ?>" /><br />
				<input id='txt_price' type='hidden' value='5.00' /><br />
				<input id='txt_available' type='hidden' value='5' /><br />
				<input id="btn_gen_event" type="hidden" value="New Template" class='btn' />
				<input id="btn_update_event" type="hidden" value="Update Event" class='btn' />
				<input id="txt_current_event" type="hidden" value="" />
			</div>

			<!-- Booking types list -->

		</div>

		<!-- Include scripts at bottom to aid dom loading and prevent hangs -->
		<script type='text/javascript' src='js/jquery.min.js'></script>
		<script type='text/javascript' src='js/jquery-ui-1.9.2.custom.min.js'></script>
		<script type='text/javascript' src='js/fullcalendar.js'></script>
		<script type='text/javascript' src='js/view_calendar.js'></script>
		<script type='text/javascript' src='js/jquery.miniColors.js'></script>
	</body>

</html>