<?php
	include_once("JSONEncodableObject.php");
	class Tutor extends JSONEncodableObject
	{
		public $TID;
		public $name;
		public $year;
		public $email;
		public $major;
		public $schedule_sid;
		public $image_url;
		
		function set_tutor_image($image_url)
		{
			$this->image_url = $image_url;
		}
	}
?>