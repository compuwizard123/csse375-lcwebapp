<?php
	include_once("tutor.php");
	include_once("course.php");
	include_once("tutor_timeslot.php");
	
	
	function add_course($mysqli, $department,$course_number, $course_description)
	{
		$result = $mysqli->query("INSERT INTO course VALUES ('DEFAULT','" . $department . "','" . $course_number . "','" . $course_description . "')");
		return $result->fetch_all(MYSQLI_ASSOC);

	}
	
	
	function remove_course($mysqli, $course_number)
	{
		$result = $mysqli->query("DELETE FROM course WHERE course_number = '" . $course_number ."'");
		return $result->fetch_all(MYSQLI_ASSOC);
	}
	
	
	
	
	
	
?>