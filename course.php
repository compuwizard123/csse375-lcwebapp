<?php
	include_once("JSONEncodableObject.php");
	class Course extends JSONEncodableObject
	{
		public $CID;
		public $department;
		public $course_number;
		public $course_description;
	}
?>