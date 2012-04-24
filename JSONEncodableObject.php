<?php
	abstract class JSONEncodableObject
	{
		public function encodeJSON() 
		{
			$json_temp = new stdClass();
			foreach ($this as $key => $value) 
			{ 
				$json_temp->$key = $value;
			} 
			return json_encode($json_temp); 
		}
		
		public function decodeJSON($json_str) 
		{ 
			$json = json_decode($json_str, 1); 
			foreach ($json as $key => $value) 
			{ 
				$this->$key = $value; 
			} 
		}
	}
?>