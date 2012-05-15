<?php
	require_once('db_con.php');
	require_once('tutor_controller.php');
	require_once('course_controller.php');
	
	$args = json_decode(file_get_contents('php://input'), true);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	$mysqli = getDBCon();
	$result = null;
	switch(str_replace('/rest/', '', $_SERVER['REQUEST_URI']))
	{
		case "get_tutor_timeslots":
			$result = get_tutor_timeslots($mysqli, $args["LCTutorID"]);
			break;
		case "get_tutor_timeslots_for_day":
			$result = get_tutor_timeslots_for_day($mysqli, $args["LCTutorID"], $args["LCDayofweek"]);
			break;
		case "get_courses_by_crn":
			$result = get_courses_by_crn($mysqli, $args['LCCourseNumber']);
			break;
		case "get_tutor_by_id":
			$result = get_tutor_by_id($mysqli, $args['LCTutorID']);
			break;
		case "get_tutors_by_name":
			$result = get_tutors_by_name($mysqli, $args["LCTutorName"]);
			break;
		case "check_if_booked":
			$result = check_if_booked($mysqli, $args["LCTutorID"],$args["LCTimeslotID"],$args["LCDate"]);
			break;
		case "get_tutors_by_course":
			$result = get_tutors_by_course($mysqli, $args["LCCourseNumber"]);
			break;
		case "get_tutors_by_name_and_course":
			$result = get_tutors_by_name_and_course($mysqli,$args["LCTutorName"] ,$args["LCCourseNumber"]);
			break; 			
		case "get_tutor_booked_timeslots":
			$result = get_tutor_booked_timeslots($mysqli, $args['LCTutorID'], $args['LCDate']);
			break;
		case "get_tutor_courses_tutored":
			$result = get_tutor_courses_tutored($mysqli, $args['LCTutorID']);
			break;
		case "book_timeslot":
			$result = book_timeslot($mysqli, $args['LCTutorID'], $args['LCTuteeUname'],$args['LCTimeslotID'],$args['LCDate']);
			break;
		case "unbook_timeslot":
			$result = unbook_timeslot($mysqli, $args['LCTutorID'],$args['LCTimeslotID'],$args['LCDate']);
			break;
		case "authenticate":
			require_once('authenticate.php');
			$result = authenticate($args['username'], $args['password']);
			break;
	}
	
	echo(json_encode($result));
?>