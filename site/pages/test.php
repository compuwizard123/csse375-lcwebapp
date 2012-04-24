<?php
require_once("../tutor_controller.php");
$TID = 1;
$timestamp = strtotime("now");
$timeslots = get_tutor_schedule($TID, $timestamp);

var_dump($timeslots);
echo("<br /><br />");

foreach($timeslots as $timeslot) {
  var_dump($timeslot);
  echo("<br /><br />");
}
?>