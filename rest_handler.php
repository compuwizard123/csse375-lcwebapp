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
		case "add_course_for_tutor":
			$result = add_course_for_tutor($mysqli, $args["LCTutorID"],$args["LCCourseID"]);
			break;
		case "remove_course_for_tutor":
			$result = remove_course_for_tutor($mysqli, $args["LCTutorID"],$args["LCCourseID"]);
			break;
		case "add_timeslot_for_tutor":
			$result = add_timeslot_for_tutor($mysqli, $args["LCTutorID"], $args["LCTimeslotID"]);
			break;
		case "remove_timeslot_for_tutor":
			$result = remove_timeslot_for_tutor($mysqli, $args["LCTutorID"], $args["LCTimeslotID"]);
			break;
		case "add_timeslot_for_tutor_on_day":
			$result = add_timeslot_for_tutor_on_day($mysqli, $args["LCTutorID"],$args["LCTimeslotID"],$args["LCDayofweek"]);
			break;
		case "remove_timeslot_for_tutor_on_day":
			$result = remove_timeslot_for_tutor_on_day($mysqli, $args["LCTutorID"],$args["LCTimeslotID"],$args["LCDayofweek"]);
			break;
		case "add_image_url_for_tutor":
			$result = add_image_url_for_tutor($mysqli, $args["LCTutorID"],$args["LCTutorImageURL"]);
			break;
		case "remove_image_url_for_tutor":
			$result = remove_image_url_for_tutor($mysqli, $args["LCTutorID"]);
			break;
		case "update_image_url_for_tutor":
			$result = update_image_url_for_tutor($mysqli, $args["LCTutorID"],$args["LCTutorImageURL"]);
			break;
		case "add_course":
			$result= add_course($mysqli, $args["LCCourseDepartment"],$args["LCCourseNumber"],$args["LCCourseDescription"]);
			break;
		case "remove_course":
			$result = remove_course($mysqli, $args["LCCourseNumber"]);
			break;
		case "get_tutor_timeslots":
			$result = get_tutor_timeslots($mysqli, $args["LCTutorID"]);
			break;
		case "get_tutor_timeslots_for_day":
			$result = get_tutor_timeslots_for_day($mysqli, $args["LCTutorID"], $args["LCDayofweek"]);
			break;
		case "add_tutor":
			$result = add_tutor($mysqli, $args["LCTutorName"],$args["LCTutorYear"],$args["LCTutorID"],$args["LCTutorMajor"],$args["LCTutorRoomNumber"],$args["LCTutorBio"]);
			break;
		case "delete_tutor":
			$result = delete_tutor($mysqli, $args["LCTutorID"]);
			break;
		case "get_course_by_crn":
			$result = get_course_by_crn($mysqli, $args['LCCourseNumber']);
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