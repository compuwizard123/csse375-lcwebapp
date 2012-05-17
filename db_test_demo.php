<?php

require_once('simpletest/autorun.php');
require_once("db_con.php");
require_once("tutor_controller.php");


class TestQueries extends UnitTestCase
{
	private $mysqli;
	
	
	function setUp() {
	
        $this->mysqli = getTestDBCon();
		$this->mysqli->autocommit(false);
    }
	
	function tearDown() {
      $this->mysqli->rollback();
    }
	
	
	
	function testBookTimeslot()
	{
	
		book_timeslot($this->mysqli, "applekw", "test", 23,"2012-05-15");
		$check = check_if_booked($this->mysqli,"applekw",23,"2012-05-15");
		$this->assertTrue($check);
		
	}
	
	function testUnbookTimeslot()
	{
		
		//unbook_timeslot($this->mysqli, "applekw",23,"2012-05-15");
		//$check = check_if_booked($this->mysqli,"applekw",23,"2012-05-15");
		//$this->assertFalse($check);
		
		
		unbook_timeslot($this->mysqli, "bamberad",23,"2012-02-15");
		$check = check_if_booked($this->mysqli,"bamberad",23,"2012-02-15");
		$this->assertFalse($check);
		
		
	}
	
	
	

	
	
	
	
	
	}
	
   ?>

