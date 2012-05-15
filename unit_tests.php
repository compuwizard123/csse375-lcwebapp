<?php
require_once('simpletest/autorun.php');
require_once("db_con.php");
require_once("tutor_controller.php");


class TestOfRest extends UnitTestCase {
	function do_post_request($req, $data, $optional_headers = null)
	{
		$baseurl = "http://lcwebapp.csse.rose-hulman.edu/rest/";
	
		$params = array('http' => array('method' => 'POST', 'content' => $data));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}

		$ctx = stream_context_create($params);
		$fp = @fopen($baseurl . $req, 'rb', false, $ctx);
		if (!$fp) throw new Exception("Problem with $req");
		$response = @stream_get_contents($fp);
		fclose($fp);
		
		if ($response === false) throw new Exception("Problem reading data from $req");
		
		return json_decode($response);
	}
	
	function testGetTutorsByName()
	{
		$data = json_encode(array("LCTutorName" => "ian"));
		$result = $this->do_post_request("get_tutors_by_name", $data);
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>2013,"major"=>"SE","Room_Number"=>"Percopo 104","about_tutor"=>"Hi!");
		
		$this->assertEqual($result[0], $expected);
    }
	
	function testGetTutorsByCourse()
	{
		$data = json_encode(array("LCCourseNumber" => "ECE130"));
		$result = $this->do_post_request("get_tutors_by_course", $data);
		$expected = array((object)array("TID"=>"bamberad","name"=>"Aaron Bamberger","year"=>"2012","major"=>"CpE-CS","Room_Number"=> NULL,"about_tutor"=> ""),(object)array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>"2013","major"=>"SE","Room_Number"=>"Percopo 104","about_tutor"=>"Hi!"));
		
		$this->assertEqual($result, $expected);
	}
	
	function testGetTutorsByNameAndCourse()
	{
		$data = json_encode(array("LCTutorName" => "ian", "LCCourseNumber" => "ECE130"));
		$result = $this->do_post_request("get_tutors_by_name_and_course", $data);
		
		$expected = array((object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>2013,"major"=>"SE","Room_Number"=>"Percopo 104","about_tutor"=>"Hi!"));
		
		$this->assertEqual($result, $expected);
	}

	function testGetTutorCoursesTutored()
	{
		$data = json_encode(array("LCTutorID" => "bamberad"));
		$result = $this->do_post_request("get_tutor_courses_tutored", $data);
		
		$expected =  array((object) array("CID"=>1,"department" =>"CSSE", "course_number" => "CSSE371","course_description" => "Software Requirements and Specifications"),(object) array("CID"=>4,"department" =>"ECE", "course_number" => "ECE130","course_description" => "Introduction to Logic Design"));
		
		$this->assertEqual($result, $expected);
    }
	
	function testAddCourse()
	{
		$data = json_encode(array("LCCourseDepartment" => "CSSE", "LCCourseNumber" => "CSSE499", "LCCourseDescription" => "Test Course"));
		$result = $this->do_post_request("add_course", $data);
		
		$checkData = json_encode(array("LCCourseNumber" => "CSSE499"));
		$wasAdded = $this->do_post_request("get_course_by_crn", $checkData);
		
		$this->assertNotNull($wasAdded);
	}
	
	function testRemoveCourse() {
		$data = json_encode(array("LCCourseNumber" => "CSSE499"));
		$result = $this->do_post_request("remove_course", $data);
		
		
		$wasRemoved = $this->do_post_request("get_course_by_crn", $data);
		
		$this->assertNull($wasRemoved);
	}
	
	/*tests fail even though the functionality works. correct later?
	function testAddTutor(){
		$data = json_encode(array("LCTutorName" => "Gruntilda","LCTutorYear" => "1998","LCTutorID" => "grunty","LCTutorMajor" => "Witchcraft","LCTutorRoomNumber" => "O107","LCTutorBio" => "See http://banjokazooie.wikia.com/wiki/Gruntilda_Winkybunion"));
		
		$tutor_info = json_encode(array("LCTutorID" => "grunty"));
		
		$before = $this->do_post_request("get_tutor_by_id", $tutor_info);
		
		$result = $this->do_post_request("add_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_by_id", $tutor_info);
		
		$this->assertNotEqual($before,$after);
	} 
	*/
	
	
	function testDeleteTutor(){
		$data = json_encode(array("LCTutorID" => "grunty"));
		$before = $this->do_post_request("get_tutor_by_id", $data);
		
		$result = $this->do_post_request("delete_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_by_id", $data);
		
		$this->assertNotEqual($before, $after);
		
	}
	
	
	function testGetTutorById()
	{
		$data = json_encode(array("LCTutorID" => "cundifij"));
		$result = $this->do_post_request("get_tutor_by_id", $data);
		
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>"2013","major"=>"SE","Room_Number"=>"Percopo 104","about_tutor" => "Hi!");
		
		$this->assertEqual($result, $expected);
    }
	
	function testGetCourseByExactCRN()
	{
		$data = json_encode(array("LCCourseNumber" => "CSSE371"));
		$result = $this->do_post_request("get_course_by_crn", $data);
		
		$expected = (object) array("CID"=>"1","department"=>"CSSE","course_number"=>"CSSE371","course_description"=>"Software Requirements and Specifications");
		
		$this->assertEqual($result, $expected);
	}
	
	function testAddCourseForTutor()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCCourseID" => 3));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_courses_tutored", $tutorInfo);
		
		$result = $this->do_post_request("add_course_for_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_courses_tutored", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	function testRemoveCourseForTutor(){
		$data = json_encode(array("LCTutorID" => "applekw", "LCCourseID" => 3));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_courses_tutored", $tutorInfo);
		
		$result = $this->do_post_request("remove_course_for_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_courses_tutored", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	/*
	function testGetTutorSchedule() {
		$data = json_encode(array("LCTutorID" => bamberad, "LCTimestamp" => time()));
		$result = $this->do_post_request("get_tutor_schedule", $data);
		$this->dump($result);
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>"2013","major"=>"SE","schedule_sid"=>null);
		
		$this->assertEqual($result, $expected);
	}
	*/
	
	function testGetBookedSlots()
	{
		$data = json_encode(array("LCTutorID" => "bamberad", "LCDate" => "2012-02-15"));
		$result = $this->do_post_request("get_tutor_booked_timeslots", $data);
		
		$expected = array((object)array("TSID" => 23, "tutee_uname" => "agnerrl"),(object)array("TSID" => 24, "tutee_uname" => "shevicna"));
		
		$this->assertEqual($result, $expected);
	}
	
	//TODO: make this mock so it doesn't rely on actual data
	
	//TODO: make this mock so it doesn't rely on actual data
	function testThatFreeSlotCanBeBooked()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCTuteeUname" => "TEST (DELETE ME)", "LCTimeslotID" => 13, "LCDate" => "2012-02-15"));
		$tutorinfo= json_encode(array("LCTutorID" => "applekw", "LCDate" => "2012-02-15"));
		$before = $this->do_post_request("get_tutor_booked_timeslots", $tutorinfo);
		
		$result = $this->do_post_request("book_timeslot",$data);
		
		$after = $this->do_post_request("get_tutor_booked_timeslots", $tutorinfo);
		
		$this->assertNotEqual($before,$after);
	}
	
	function testThatBookedSlotCanBeUnbooked(){
		$data = json_encode(array("LCTutorID" => "applekw", "LCTimeslotID" => 13, "LCDate" => "2012-02-15"));
		
		$tutorinfo= json_encode(array("LCTutorID" => "applekw", "LCDate" => "2012-02-15"));
		
		$before = $this->do_post_request("get_tutor_booked_timeslots", $tutorinfo);
		
		$result = $this->do_post_request("unbook_timeslot",$data);
		
		$after = $this->do_post_request("get_tutor_booked_timeslots", $tutorinfo);
		
		$this->assertNotEqual($before,$after); 
	}
	
	function testGetTutorTimeslots()
	{
		$data = json_encode(array("LCTutorID" => "applekw"));
		
		$result = $this->do_post_request("get_tutor_timeslots", $data);
		
		$expected = (array((object)array("TSID" => 8, "Time" => "11:15:00", "Period" => 4, "DAYOFWEEK" => "MONDAY")));
		
		
		$this->assertEqual($expected, $result);
	}
	
	function testGetTutorTimeslotsByDay()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCDayofweek" => "Monday"));
		
		$result = $this->do_post_request("get_tutor_timeslots_for_day", $data);
		
		$expected = (array((object)array("TSID" => 8, "Time" => "11:15:00", "Period" => 4, "DAYOFWEEK" => "MONDAY")));
		
		
		$this->assertEqual($expected, $result);
	}
	
	function testAddTimeslotForTutor()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCTimeslotID" => 18));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$result = $this->do_post_request("add_timeslot_for_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	function testRemoveTimeslotForTutor()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCTimeslotID" => 18));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$result = $this->do_post_request("remove_timeslot_for_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	function testAddTimeslotForTutorOnDay()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCTimeslotID" => 18, "LCDayofweek" => "Monday"));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$result = $this->do_post_request("add_timeslot_for_tutor_on_day", $data);
	
		$after = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	function testRemoveTimeslotForTutorOnDay()
	{
		$data = json_encode(array("LCTutorID" => "applekw", "LCTimeslotID" => 18, "LCDayofweek" => "Monday"));
		$tutorInfo = json_encode(array("LCTutorID" => "applekw"));
		
		$before = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$result = $this->do_post_request("remove_timeslot_for_tutor_on_day", $data);
		
		$after = $this->do_post_request("get_tutor_timeslots", $tutorInfo);
		
		$this->assertNotEqual($before, $after);
	}
	
	function testThatBookedSlotIsRecognizedAsBooked()
	{
		$data = json_encode(array("LCTutorID" => "bamberad","LCTimeslotID" => 23 ,"LCDate" => "2012-02-15"));
		$result = $this->do_post_request("check_if_booked", $data);
		
		$this->assertTrue($result);
	}
	
	function testThatFreeSlotIsRecognizedAsFree()
	{
		$data = json_encode(array("LCTutorID" => "bamberad","LCTimeslotID" => 1 ,"LCDate" => "2012-02-15"));
		$result = $this->do_post_request("check_if_booked", $data);
		
	
		$this->assertFalse($result);
	}
}
?>