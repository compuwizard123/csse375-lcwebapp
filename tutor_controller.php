<?php
	include_once("db_con.php");
	include_once("tutor.php");
	include_once("course.php");
	include_once("tutor_timeslot.php");
	
	//NOTE: assumes that the array of courses passed in are already in the 'course' table
	//      on tutor creation, allowing them to select courses from a list would ensure this
	//TODO: add support for pictures once their implementation is finalized, fix adding courses
	function add_tutor($name,$year,$TID,$major,$room_number,$about_tutor, $course_array){
		
		$mysqli = getDBCon();
		$tutor_insertion_result = $mysqli->query("INSERT INTO tutor (name,year, TID, major, Room_Number, about_tutor) VALUES ('". $name ."' , '". $year ."' , '". $TID ."', '". $major ."','" . $room_number . "','" . $about_tutor ."')");
		
		
		/*
		foreach($course_array as $course){
			
			
			$course_info = get_course_by_crn($course);
			$course_add_result = add_course_for_tutor($TID,$course_info->CID);
			
		}
		
		*/
		unset($mysqli);
		return $tutor_insertion_result->fetch_all(MYSQLI_ASSOC);
	}
	
	function delete_tutor($TID){
		$mysqli = getDBCon();
		$deletion_result = $mysqli->query("DELETE FROM tutor_course, tutor_timeslot, booked_timeslots, tutor WHERE TID = '" . $TID ."')");
		
		unset($mysqli);
		return $deletion_result->fetch_all(MYSQLI_ASSOC);
	}
	
	function add_course_for_tutor($TID,$CID){
		$mysqli = getDBCon();
		$result = $mysqli->query("INSERT INTO tutor_course (TID,CID) VALUES ('". $TID . "','" . $CID ."')");
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function remove_course_for_tutor($TID,$CID){
		$mysqli = getDBCon();
		$result = $mysqli->query("DELETE FROM tutor_course WHERE TID = '". $TID . "' AND CID = '" . $CID ."'");
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	function get_course_by_crn($course_number){
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT CID, department, course_number, course_description FROM course WHERE course_number = '" . $course_number . "'");
		$course_object = $result->fetch_object("course");
		unset($mysqli);
		return $course_object;
	}
	
	function get_tutor_by_id($tutor_id)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID=tutor_images.TID) WHERE tutor.TID = '" . $tutor_id . "'");
		$tutor_object = $result->fetch_object("tutor");
		unset($mysqli);
		return $tutor_object;
	}
	
	function get_tutors_by_course($course)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT DISTINCT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor tutor_images.image_url FROM course INNER JOIN (tutor_course INNER JOIN (tutor INNER JOIN tutor_images ON (tutor.TID = tutor_images.TID)) ON (tutor_course.TID=tutor.TID)) ON (course.CID=tutor_course.CID) WHERE course.course_number LIKE '" . $course . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutors_by_name($name, $course)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major, tutor.Room_Number, tutor.about_tutor, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON ( tutor.TID = tutor_images.TID ) WHERE tutor.name LIKE '%" . $name . "%' ORDER BY tutor.name");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $result_obj);
		}
		
		unset($mysqli);
		if (!empty($course_id)) array_push($results_array,get_tutors_by_course($course));
		return $results_array;
	}
	
	function get_tutors_by_major($major)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID = tutor_images.TID) WHERE tutor.major = '%" . $major . "%'");
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
		$result = $mysqli->query("SELECT tutor.TID, tutor.name, tutor.year, tutor.major, tutor_images.image_url FROM tutor INNER JOIN tutor_images ON (tutor.TID=tutor_images.TID) WHERE tutor.year = '" . $year . "'");
		$results_array = array();
		while($result_obj = $result->fetch_object("tutor"))
		{
			array_push($results_array, $results_obj);
		}
		unset($mysqli);
		return $results_array;
	}
	
	function get_tutor_courses_tutored($tutor_id)
	{
		$mysqli = getDBCon();
		$result = $mysqli->query("SELECT course.department, course.course_number, course.course_description FROM course INNER JOIN tutor_course ON (course.CID = tutor_course.CID ) WHERE tutor_course.TID = '" . $tutor_id . "'");
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	//TODO: rewrite
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
	
	
	function get_tutor_booked_timeslots($tutor_id, $date)
	{
		$mysqli = getDBCon();
		
		$result = $mysqli->query("SELECT TSID, tutee_uname  FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND booked_day = '". $date ."'" );
		
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	/* TODO: Fix later
	function check_if_booked($tutor_id,$timeslot_id,$date)
	{
		$mysqli = getDBCon();
		
		$result = $mysqli->query("SELECT TID FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND booked_day = '". $date ."' AND TSID = '". $timeslot_id ."'");
		
		unset($mysqli);
		
		return $result;
	}
	*/
	
	function book_timeslot($tutor_id, $tutee_uname, $timeslot_id,$date)
	{
		$mysqli = getDBCon();
		
		$check = get_tutor_booked_timeslots($tutor_id,$date);

		if ($check) return NULL;
		
		$result = $mysqli->query("INSERT INTO booked_timeslots (TID,TSID, tutee_uname, booked_day) VALUES ('". $tutor_id ."' , '". $timeslot_id ."' , '". $tutee_uname ."', '". $date ."')");
		
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
		
	}
	
	function unbook_timeslot($tutor_id,$timeslot_id,$date)
	{
		$mysqli = getDBCon();
		
		$result = $mysqli->query("DELETE FROM booked_timeslots WHERE TID = '". $tutor_id ."' AND TSID = '". $timeslot_id ."' AND booked_day = '". $date ."'");
		
		unset($mysqli);
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	
	//TODO: rewrite?
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