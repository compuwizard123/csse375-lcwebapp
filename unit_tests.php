<?php
require_once('simpletest/autorun.php');

class TestOfRest extends UnitTestCase {
	function do_post_request($req, $data, $optional_headers = null) {
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
	
	function testGetTutorsByName() {
		$data = json_encode(array("LCTutorName" => "ian", "LCCourseNumber" => ""));
		$result = $this->do_post_request("get_tutors_by_name", $data);
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>2013,"major"=>"SE","Room_Number"=>"Percopo 104","about_tutor"=>"Hi!","image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result[0], $expected);
    }
	

	function testGetTutorCoursesTutored() {
		$data = json_encode(array("LCTutorID" => "bamberad"));
		$result = $this->do_post_request("get_tutor_courses_tutored", $data);
		
		$expected =  array((object) array("CID"=>1,"department" =>"CSSE", "course_number" => "CSSE371","course_description" => "Software Requirements and Specifications"),(object) array("CID"=>4,"department" =>"ECE", "course_number" => "ECE130","course_description" => "Introduction to Logic Design"));
		
		$this->assertEqual($result, $expected);
    }
	
	/*
	function testAddTutorWithCoursesSpecified(){
		$data = json_encode(array("LCTutorName" => "Gruntilda","LCTutorYear" => "1998","LCTutorID" => "grunty","LCTutorMajor" => "Witchcraft","LCTutorRoomNumber" => "O107","LCTutorBio" => "See http://banjokazooie.wikia.com/wiki/Gruntilda_Winkybunion", "LCCoursesArray" => array('CSSE371','CSSE374')));
		
		$tutor_info = json_encode(array("LCTutorID" => "grunty"));
		
		$before = $this->do_post_request("get_tutor_by_id", $tutor_info);
		
		$result = $this->do_post_request("add_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_by_id", $tutor_info);
		
		$this->assertNotNull($after);
		$this->assertNotEqual($before,$after);
		
	} */
	/*
	function testAddTutorWithNoCoursesSpecified(){
		$this->fail("Not yet implemented.");
	}
	
	function testAddTutorWithNullBio(){
		$this->fail("Not yet implemented.");
	}
	*/
	
	/*
	function testDeleteTutor(){
		$data = json_encode(array("LCTutorID" => "grunty"));
		$before = $this->do_post_request("get_tutor_by_id", $data);
		
		$result = $this->do_post_request("delete_tutor", $data);
		
		$after = $this->do_post_request("get_tutor_by_id", $data);
		
		$this->assertNotEqual($before, $after);
		$this->assertNull($after);
	}
	*/
	function testGetTutorById() {
		$data = json_encode(array("LCTutorID" => "cundifij"));
		$result = $this->do_post_request("get_tutor_by_id", $data);
		
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>"2013","major"=>"SE","Room_Number"=>"Percopo 104","about_tutor" => "Hi!","image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result, $expected);
    }
	
	function testGetCourseByExactCRN(){
		$data = json_encode(array("LCCourseNumber" => "CSSE371"));
		$result = $this->do_post_request("get_course_by_crn", $data);
		
		$expected = (object) array("CID"=>"1","department"=>"CSSE","course_number"=>"CSSE371","course_description"=>"Software Requirements and Specifications");
		
		$this->assertEqual($result, $expected);
	}
	
	function testAddCourseForTutor(){
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
		
		$expected = (object) array("TID"=>"cundifij","name"=>"Ian Cundiff","year"=>"2013","major"=>"SE","schedule_sid"=>null,"image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result, $expected);
	}
	*/
	
	function testGetBookedSlots(){
		$data = json_encode(array("LCTutorID" => "bamberad", "LCDate" => "2012-02-15"));
		$result = $this->do_post_request("get_tutor_booked_timeslots", $data);
		
		$expected = array((object)array("TSID" => 23, "tutee_uname" => "agnerrl"),(object)array("TSID" => 24, "tutee_uname" => "shevicna"));
		
		$this->assertEqual($result, $expected);
	}
	
	//TODO: make this mock so it doesn't rely on actual data
	
	//TODO: make this mock so it doesn't rely on actual data
	function testThatFreeSlotCanBeBooked(){
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
	
	/*
	function testThatBookedSlotIsRecognizedAsBooked(){
		$data = json_encode(array("LCTutorID" => "bamberad","LCTimeslotID" => 23 ,"LCDate" => "2012-02-15"));
		$result = $this->do_post_request("check_if_booked", $data);

		$this->assertTrue($result);
	}
	//TODO: make this mock so it doesn't rely on actual data
	function testThatBookedSlotCannotBeOverbooked(){
		$this->fail("Test not yet implemented");
	}
	
	function testThatFreeSlotIsRecognizedAsFree(){
		$data = json_encode(array("LCTutorID" => "bamberad","LCTimeslotID" => 1 ,"LCDate" => "2012-02-15"));
		$result = $this->do_post_request("check_if_booked", $data);
		$this->dump($result);
	
		$this->assertFalse($result);
	}
	*/
}
?>