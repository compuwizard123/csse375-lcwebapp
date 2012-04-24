<?php
	class TutorTimeslot
	{
		public $tutor_name;
		public $Day;
		public $TID;
		public $TSID;
		public $Time;
		public $booked_date = null;
		public $tutee_name = null;
		public $status = 'Not Booked';
		
		public function __construct()
		{
			$this->tutor_name = $this->Name;
			unset($this->Name);
		}
		
		public function book($tutee_name, $date)
		{
			$this->tutee_name = $tutee_name;
			$this->booked_date = $date;
			$this->status = 'Booked';
		}
		
		public function get_tsid()
		{
			return $this->TSID;
		}
	}
?>