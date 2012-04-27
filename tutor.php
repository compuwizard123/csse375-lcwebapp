<?php
	include_once("JSONEncodableObject.php");
	class Tutor extends JSONEncodableObject
	{
		public $TID;
		public $name;
		public $year;
		public $major;
		public $Room_Number;
		public $about_tutor;
		
		function set_tutor_image($image_url)
		{
			$this->image_url = $image_url;
		}
	}
?>