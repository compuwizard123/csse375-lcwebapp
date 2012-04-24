<?php
	class TutorList extends JSONEncodableObject
	{
		private $tutors;
		
		public function __construct()
		{
			$this->tutors = array();
		}
		
		public function add_tutor($tutor)
		{
			array_push($this->tutors, $tutor);
		}
		
		public function encodeJSON() 
		{
			$json_temp = new stdClass();
			foreach ($this->tutors as $key => $value) 
			{ 
				$json_temp->$key = $value->encodeJSON();
			} 
			return json_encode($json_temp);
		}
	}
?>