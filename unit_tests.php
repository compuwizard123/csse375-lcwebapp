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
		$data = json_encode(array("LCTutorName" => "ian"));
		$result = $this->do_post_request("get_tutors_by_name", $data);
		
		$expected = (object) array("TID"=>3,"name"=>"Ian Cundiff","year"=>2013,"email"=>"cundifj","major"=>"SE","schedule_sid"=>null,"image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result[0], $expected);
    }
	
	
	
	function testGetTutorCoursesTutored() {
		$data = json_encode(array("LCTutorID" => "1"));
		$result = $this->do_post_request("get_tutor_courses_tutored", $data);
		$this->dump($result);
		
		$expected =  array((object) array("department" =>"CSSE", "course_number" => "CSSE371","course_description" => "Software Requirements and Specifications"),(object) array("department" =>"ECE", "course_number" => "ECE130","course_description" => "Introduction to Logic Design"));
		
		$this->assertEqual($result, $expected);
    }
	
	function testGetTutorById() {
		$data = json_encode(array("LCTutorID" => "3"));
		$result = $this->do_post_request("get_tutor_by_id", $data);
		$this->dump($result);
		
		$expected = (object) array("TID"=>"3","name"=>"Ian Cundiff","year"=>"2013","email"=>"cundifj","major"=>"SE","schedule_sid"=>null,"image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result, $expected);
    }
	/*
	function testGetTutorSchedule() {
		$data = json_encode(array("LCTutorID" => 1, "LCTimestamp" => time()));
		$result = $this->do_post_request("get_tutor_schedule", $data);
		$this->dump($result);
		
		$expected = (object) array("TID"=>"3","name"=>"Ian Cundiff","year"=>"2013","email"=>"cundifj@rose-hulman.edu","major"=>"SE","schedule_sid"=>null,"image_url"=>"http://lcwebapp.csse.rose-hulman.edu/TutorProfilePics/tutor-pic-3.jpg");
		
		$this->assertEqual($result, $expected);
	}
	*/
	
	
	function testGetBookedSlots(){
		$data = json_encode(array("LCTutorUname" => "bamberad", "LCDate" => "2012-02-15"));
		$result = $this->do_post_request("get_tutor_booked_timeslots", $data);
		$this->dump($result);
		
		
		$expected = array((object)array("TSID" => 23, "tutee_uname" => "agnerrl"),(object)array("TSID" => 24, "tutee_uname" => "shevicna"));
		
		$this->assertEqual($result, $expected);
	}
	
	//TODO: make this mock so it doesn't rely on actual data
	function testThatBookedSlotCanBeUnbooked(){
		$this->fail("Test not yet implemented");
	}
	
	
	//TODO: make this mock so it doesn't rely on actual data
	function testThatFreeSlotCanBeBooked(){
		$data = json_encode(array("LCTutorID" => "2", "LCTuteeUname" => "agnerrllll", "LCTimeslotID" => 13, "LCDate" => "2012-02-15"));
		$tutorinfo= json_encode(array("LCTutorID" => "2", "LCDate" => "2012-02-15"));
		$before = $this->do_post_request("get__tutor_booked_timeslots", $tutorinfo);
		
		$result = $this->do_post_request("book_timeslot",$data);
		
		$after = $this->do_post_request("get__tutor_booked_timeslots", $tutorinfo);
		
		$this->assertNotEqual($before,$after);
		
		
	}
	
	
	
	//TODO: make this mock so it doesn't rely on actual data
	function testThatBookedSlotCannotBeOverbooked(){
		$this->fail("Test not yet implemented");
	}
	
	
	
	
	
	
}
?>