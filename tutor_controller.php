<?php
	include_once("db_con.php");
	include_once("tutor.php");
	include_once("tutor_timeslot.php");
	include_once("tutor_list.php");
	
	function get_tutor_by_id($tutor_id)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.email, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID=tutor_images.TID) WHERE tutor.TID = '" . $tutor_id . "'");
		$tutor_object = $result->fetch_object("tutor");
		unset($mysqli);
		return $tutor_object;
	}
	
	function get_tutors_by_course($course)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT DISTINCT tutor.TID, tutor.name, tutor.year, tutor.email, tutor.major, tutor_images.image_url FROM course INNER JOIN (tutor_course INNER JOIN (tutor INNER JOIN tutor_images ON (tutor.TID = tutor_images.TID)) ON (tutor_course.TID=tutor.TID)) ON (course.CID=tutor_course.CID) WHERE course.course_number = '" . $course . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutors_by_name($name)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.email, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON ( tutor.TID = tutor_images.TID ) WHERE tutor.name LIKE '" . $name . "%' ORDER BY tutor.name");
		//$tutor_list = new TutorList();
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutors_by_major($major)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.email, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID = tutor_images.TID) WHERE tutor.major = '" . $major . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $results_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutors_by_year($year)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.email, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID=tutor_images.TID) WHERE tutor.year = '" . $year . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $results_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutor_schedule($tutor_id, $timestamp)
	{
		$day = date("l", $timestamp);
		$date = date("Y-m-d", $timestamp);
		$timeslots = get_tutor_timeslots($tutor_id, $day);
		$booked = get_tutor_booked($tutor_id, $date);
		merge_timeslots($timeslots, $booked);
		return $timeslots;
	}
	
	function get_tutor_courses_tutored($tutor_id)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT course.department, course.course_number, course.course_description FROM course INNER JOIN tutor_course ON (course.CID = tutor_course.CID ) WHERE tutor_course.TID = '" . $tutor_id . "'");
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function get_tutor_timeslots($tutor_id, $day)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, timeslot.TSID, timeslot.Day, timeslot.Time, tutor.Name FROM (timeslot INNER JOIN (tutor INNER JOIN tutor_timeslot ON ( tutor.TID = tutor_timeslot.TID )) ON ( timeslot.TSID = tutor_timeslot.TSID )) WHERE tutor.TID = '" . $tutor_id . "' AND DAY = '" . strtoupper($day) . "'");
		unset($mysqli);
		$results_array = array();
		while($results_obj = $result->fetch_object('TutorTimeslot'))
		{
			array_push($results_array, $results_obj);
		}
		return $results_array;
	}
	
	function get_tutor_booked($tutor_id, $date)
	{
		$mysqli = getDBCon();
		//$date = date('Y-m-d');
		$result = $mysqli->query("SELECT tutor.TID, tutor.Name, timeslot.TSID, booked_timeslots.tutee_uname, booked_timeslots.booked_day FROM timeslot INNER JOIN (tutor INNER JOIN booked_timeslots ON (tutor.TID=booked_timeslots.TID)) ON (timeslot.TSID=booked_timeslots.TSID) WHERE tutor.TID='" . $tutor_id ."' AND booked_timeslots.booked_day='" . $date . "'");
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function merge_timeslots(&$tutor_scheduled_timeslots, $tutor_booked_timeslots)
	{
		foreach($tutor_booked_timeslots as $booking)
		{
			$scheduled_timeslot = get_timeslot_by_tsid($tutor_scheduled_timeslots, $booking['TSID']);
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