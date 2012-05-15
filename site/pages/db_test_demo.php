<?php
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
	
	
	function test()
	{
		//add_tutor($this->mysqli, "test",2003,"hmm","CSSE","O159","HI");
		$result = delete_tutor($this->mysqli, "bamberad");
		var_dump($result);
		
	}

	
   ?>

