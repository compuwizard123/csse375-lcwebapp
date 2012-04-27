<?php
	require_once('db_con.php');
	require_once('tutor_controller.php');
	
	$args = json_decode(file_get_contents('php://input'), true);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	switch(str_replace('/rest/', '', $_SERVER['REQUEST_URI']))
	{			
		case "get_tutor_by_id":
			$result = get_tutor_by_id($args['LCTutorID']);
			break;
			
		case "get_tutors_by_name":
			$result = get_tutors_by_name($args["LCTutorName"]);
			break;
			
		case "check_if_booked":
			$result = check_if_booked($args["LCTutorID"],$args["LCTimeslotID"],$args["LCDate"]);
			break;
			
		case "get_tutors_by_course":
			$result = get_tutors_by_course($args["LCCourse"]);
			break; 
			
		case "get_tutor_booked_timeslots":
			$result = get_tutor_booked_timeslots($args['LCTutorID'], $args['LCDate']);
			break;
			
		case "get_tutor_courses_tutored":
			$result = get_tutor_courses_tutored($args['LCTutorID']);
			break;
			
		case "book_timeslot":
			$result = book_timeslot($args['LCTutorID'], $args['LCTuteeUname'],$args['LCTimeslotID'],$args['LCDate']);
			break;
			
		case "unbook_timeslot":
			$result = unbook_timeslot($args['LCTutorID'],$args['LCTimeslotID'],$args['LCDate']);
			break;
			
		case "authenticate":
			require_once('authenticate.php');
			$result = authenticate($args['username'], $args['password']);
			break;
	}
	
	echo(json_encode($result));
?>