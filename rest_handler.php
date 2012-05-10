<?php
	require_once('db_con.php');
	require_once('tutor_controller.php');
	
	$args = json_decode(file_get_contents('php://input'), true);
	header('Cache-Control: no-cache, must-revalidate');
	header('Content-type: application/json');
	
	switch(str_replace('/rest/', '', $_SERVER['REQUEST_URI']))
	{
		case "add_course_for_tutor":
			$result = add_course_for_tutor($args["LCTutorID"],$args["LCCourseID"]);
			break;
		case "remove_course_for_tutor":
			$result = remove_course_for_tutor($args["LCTutorID"],$args["LCCourseID"]);
			break;

		case "add_tutor":
			$result = add_tutor($args["LCTutorName"],$args["LCTutorYear"],$args["LCTutorID"],$args["LCTutorMajor"],$args["LCTutorRoomNumber"],$args["LCTutorBio"], $args["LCCoursesArray"]);
			break;
		case "delete_tutor":
			$result = delete_tutor($args["LCTutorID"]);
			break;

		case "get_course_by_crn":
			$result = get_course_by_crn($args['LCCourseNumber']);
			break;

		case "get_tutor_by_id":
			$result = get_tutor_by_id($args['LCTutorID']);
			break;
			
		case "get_tutors_by_name":
			$result = get_tutors_by_name($args["LCTutorName"],$args["LCCourseNumber"]);
			break;

		case "check_if_booked":
			$result = check_if_booked($args["LCTutorID"],$args["LCTimeslotID"],$args["LCDate"]);
			break;
			
		case "get_tutors_by_course":
			$result = get_tutors_by_course($args["LCCourseNumber"]);
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