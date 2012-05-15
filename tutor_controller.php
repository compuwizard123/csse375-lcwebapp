<?php
	include_once("tutor.php");
	include_once("course.php");
	include_once("tutor_timeslot.php");
	include_once("course_controller.php");
	
	//NOTE: Expects the classes passed in to already be in the course table
	//      drop-down list could ensure this
	//TODO: add support for pictures once their implementation is finalized, fix adding courses
	function add_tutor($mysqli, $name,$year,$TID,$major,$room_number,$about_tutor)
	{
		$result = $mysqli->query("INSERT INTO tutor (name,year, TID, major, Room_Number, about_tutor) VALUES ('". $name ."' , '". $year ."' , '". $TID ."', '". $major ."','" . $room_number . "','" . $about_tutor ."')");
		
		return $result;
	}
	
	function update_tutor($mysqli, $name, $year, $TID, $major, $room_number, $about_tutor)
	{
		$result = $mysqli->query("UPDATE tutor SET name = '" . $name . "', year = '" . $year . "', major = '" . $major . "', Room_Number = '" . $room_number . "', about_tutor = '" . $about_tutor . "' WHERE TID = '" . $TID ."'");
		
		return $result;
	}
	
	function delete_tutor($mysqli, $TID)
	{
		$deletion_result = $mysqli->query("DELETE FROM tutor_course WHERE TID = '" . $TID . "'");
		$deletion_result = $mysqli->query("DELETE FROM tutor_timeslots WHERE TID = '" . $TID . "'");
		$deletion_result = $mysqli->query("DELETE FROM booked_timeslots WHERE TID = '" . $TID . "'");
		$deletion_result = $mysqli->query("DELETE FROM tutor WHERE TID = '" . $TID . "'");
		
		return $deletion_result;
	}
	
	function add_course_for_tutor($mysqli, $TID,$CID)
	{
		$result = $mysqli->query("INSERT INTO tutor_course (TID,CID) VALUES ('". $TID . "','" . $CID ."')");
		return $result;
	}
	
	function remove_course_for_tutor($mysqli, $TID,$CID)
	{
		$result = $mysqli->query("DELETE FROM tutor_course WHERE TID = '". $TID . "' AND CID = '" . $CID ."'");
		return $result;
	}
	
	function add_timeslot_for_tutor($mysqli, $TID, $TSID)
	{
		$result = $mysqli->query("INSERT INTO tutor_timeslot (TID,TSID) VALUES ('". $TID . "','" . $TSID ."')");
		return $result;
	}
	
	function remove_timeslot_for_tutor($mysqli, $TID, $TSID)
	{
		$result = $mysqli->query("DELETE FROM tutor_timeslot WHERE TID = '". $TID . "' AND TSID = '" . $TSID ."'");
		return $result;
	}
	
	function add_timeslot_for_tutor_on_day($mysqli, $TID, $TSID, $dayofweek)
	{
		$result = $mysqli->query("INSERT INTO tutor_timeslot (TID,TSID, DAYOFWEEK) VALUES ('". $TID . "','" . $TSID ."','" . $dayofweek . "')");
		return $result;
	}
	
	function remove_timeslot_for_tutor_on_day($mysqli, $TID, $TSID, $dayofweek)
	{
		$result = $mysqli->query("DELETE FROM tutor_timeslot WHERE TID = '". $TID . "' AND TSID = '" . $TSID ."' AND DAYOFWEEK = '" . strtoUpper($dayofweek) ."'");
		return $result;
	}
	
	function get_course_by_crn($mysqli, $course_number)
	{
		$result = $mysqli->query("SELECT CID, department, course_number, course_description FROM course WHERE course_number = '" . $course_number . "'");
		$course_object = $result->fetch_object("course");
		return $course_object;
	}
	
	function get_course_by_similar_crn($mysqli, $course_number)
	{
		$result = $mysqli->query("SELECT CID, department, course_number, course_description FROM course WHERE course_number LIKE '" . $course_number . "'");
		$course_object = $result->fetch_object("course");
		return $course_object;
	}
	
	function get_tutor_by_id($mysqli, $tutor_id)
	{
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor FROM tutor WHERE tutor.TID = '" . $tutor_id . "'");
		$tutor_object = $result->fetch_object("tutor");
		return $tutor_object;
	}
	
	function get_tutors_by_course($mysqli, $course)
	{
		$result = $mysqli->query("SELECT DISTINCT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor FROM course INNER JOIN (tutor_course INNER JOIN tutor ON (tutor_course.TID=tutor.TID)) ON (course.CID=tutor_course.CID) WHERE course.course_number LIKE '%" . $course . "%'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		return $results_array;
	}
	
	function get_tutors_by_name($mysqli, $name)
	{		
		$result = $mysqli->query("SELECT DISTINCT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor FROM tutor WHERE tutor.name LIKE '%" . $name . "%' ORDER BY tutor.name");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		
		return $results_array;
	}
	
	function get_tutors_by_name_and_course($mysqli, $name, $course)
	{
		$result = $mysqli->query("SELECT DISTINCT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor FROM course INNER JOIN (tutor_course INNER JOIN tutor ON (tutor_course.TID=tutor.TID)) ON (course.CID=tutor_course.CID) WHERE tutor.name LIKE '%"  . $name ."%' AND course.course_number LIKE '%" . $course . "%'");
		$results_array = array();
		
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		
		return $results_array;
	
	}
	
	function get_tutors_by_major($mysqli, $major)
	{
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major FROM tutor WHERE tutor.major = '%" . $major . "%'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutors_by_year($mysqli, $year)
	{
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major FROM tutor WHERE tutor.year = '" . $year . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutor_courses_tutored($mysqli, $tutor_id)
	{
		$result = $mysqli->query("SELECT course.CID, course.department, course.course_number, course.course_description FROM course INNER JOIN tutor_course ON (course.CID = tutor_course.CID ) WHERE tutor_course.TID = '" . $tutor_id . "'");
		$results_array = array();
		while($results_obj = $result->fetch_object('Course'))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutor_timeslots_for_day($mysqli, $tutor_id, $day)
	{
		$result = $mysqli->query("SELECT timeslot.TSID, timeslot.Time,timeslot.Period, tutor_timeslot.DAYOFWEEK FROM (timeslot INNER JOIN (tutor INNER JOIN tutor_timeslot ON tutor.TID = tutor_timeslot.TID) ON (timeslot.TSID =tutor_timeslot.TSID)) WHERE tutor.TID = '" . $tutor_id . "' AND tutor_timeslot.DAYOFWEEK = '" . strtoupper($day) . "'");
		$results_array = array();
		while($results_obj = $result->fetch_object('TutorTimeslot'))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutor_timeslots($mysqli, $tutor_id)
	{
		$result = $mysqli->query("SELECT timeslot.TSID, timeslot.Time,timeslot.Period, tutor_timeslot.DAYOFWEEK FROM (timeslot INNER JOIN (tutor INNER JOIN tutor_timeslot ON tutor.TID = tutor_timeslot.TID) ON (timeslot.TSID =tutor_timeslot.TSID)) WHERE tutor.TID = '" . $tutor_id . "'");
		$results_array = array();
		while($results_obj = $result->fetch_object('TutorTimeslot'))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutor_booked_timeslots($mysqli, $tutor_id, $date)
	{
		$result = $mysqli->query("SELECT TSID, tutee_uname  FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND booked_day = '". $date ."'" );
		
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function check_if_booked($mysqli,$tutor_id,$timeslot_id,$date)
	{
		$result = $mysqli->query("SELECT TID FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND booked_day = '". $date ."' AND TSID = '". $timeslot_id ."'");
		
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function book_timeslot($mysqli, $tutor_id, $tutee_uname, $timeslot_id,$date)
	{
		$check = get_tutor_booked_timeslots($mysqli, $tutor_id,$date);

		if ($check) return NULL;
		
		$result = $mysqli->query("INSERT INTO booked_timeslots (TID,TSID, tutee_uname, booked_day) VALUES ('". $tutor_id ."' , '". $timeslot_id ."' , '". $tutee_uname ."', '". $date ."')");
		return $result;
	}

	function unbook_timeslot($mysqli, $tutor_id,$timeslot_id,$date)
	{	
		$result = $mysqli->query("DELETE FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND TSID = '". $timeslot_id ."' AND booked_day = '". $date ."'");
		
		return $result;
	}
	
	//TODO: rewrite?
	function merge_timeslots(&$tutor_scheduled_timeslots, $tutor_booked_timeslots)
	{
		foreach($tutor_booked_timeslots as $booking)
		{
			$scheduled_timeslot = get_timeslot_by_tsid($mysqli, $tutor_scheduled_timeslots, $booking['TSID']);
			if($scheduled_timeslot != null)
			{
				$scheduled_timeslot->book($booking['tutee_uname'], $booking['booked_day']);
			}
		}
	}	
	
	function get_timeslot_by_tsid($timeslots, $tsid)
	{
		foreach($timeslots as $timeslot)
		{
			if($timeslot->get_tsid() == $tsid)
			{
				return $timeslot;
			}
		}
		return null;
	}
?>