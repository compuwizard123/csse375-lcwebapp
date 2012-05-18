<?php
require_once("../../tutor_controller.php");
require_once("display_admin.php");
if(isset($_GET['tutor_id']))
   $tutor = get_tutor_by_id(getDBCon(),$_GET['tutor_id']);
if(!isset($tutor)) die("<h3>Invalid Tutor Id</h3>");

if(isset($_GET['course']) && isset($_GET['type'])) {
	if($_GET['type'] == "add") {
		$result = add_course_for_tutor($mysqli, $tutor->TID,$_GET['course']);
	} else if($_GET['type'] == "remove") {
		$result = remove_course_for_tutor($mysqli, $tutor->TID,$_GET['course']);
	}
}

if(isset($_GET['timeslot']) && $_GET['timeslot'] != "" && isset($_GET['day']) && $_GET['day'] != "" && isset($_GET['type'])) {
	if($_GET['type'] == "add") {
		$result = add_timeslot_for_tutor_on_day($mysqli, $tutor->TID, $_GET['timeslot'], $_GET['day']);
	} else if($_GET['type'] == "remove") {
		$result = remove_timeslot_for_tutor_on_day($mysqli, $tutor->TID, $_GET['timeslot'], $_GET['day']);
	}
}
?>
<div>
<h3>Edit Tutor - <?php echo($tutor->TID); ?></h3>
<form method="post" action="index.php?page=save_tutor">
<input type="hidden" name="type" value="update" />
<input type="hidden" name="username" value="<?php echo($tutor->TID);?>" />
<table>
<?php display_edit_tutor($tutor); ?>
</table>
</form>
<h4>Courses</h4>
<?php
$all_courses = get_courses_by_crn($mysqli, "");
$courses = get_tutor_courses_tutored($mysqli, $tutor->TID);
?>

<form method="get" action="index.php">
<input type="hidden" name="page" value="edit_tutor" />
<input type="hidden" name="tutor_id" value="<?php echo($tutor->TID);?>" />
<input type="hidden" name="type" value="add" />
<select name="course">
<option value=""></option>
<?php
foreach(array_diff($all_courses,$courses) as $course) {
	echo("<option value=\"" . $course->CID . "\">" . $course->course_number . "</option>");
}
?>
</select>
<input type="submit" value="Add" />
</form>

<ul>
<?php
foreach($courses as $course) {
	echo("<li>" . $course->course_number . " <a href=\"index.php?page=edit_tutor&amp;tutor_id=" . $tutor->TID . "&amp;course=" . $course->CID . "&amp;type=remove\">(X)</a></li>");
}
?>
</ul>

<h4>Timeslots</h4>
<form method="get" action="index.php">
<input type="hidden" name="page" value="edit_tutor" />
<input type="hidden" name="tutor_id" value="<?php echo($tutor->TID);?>" />
<input type="hidden" name="type" value="add" />
<select name="day">
<option value=""></option>
<?php
$all_days = array("SUNDAY", "MONDAY", "TUESDAY", "WEDNESDAY", "THURSDAY");
foreach($all_days as $day) {
	echo("<option value=\"" . $day . "\">" . ucfirst(strtolower($day)) . "</option>");
}
?>
</select>
<select name="timeslot">
<option value=""></option>
<?php
$all_timeslots = get_timeslots($mysqli);
foreach($all_timeslots as $timeslot) {
	echo("<option value=\"" . $timeslot["TSID"] . "\">" . $timeslot["PERIOD"] . " " . $timeslot["TIME"] . "</option>");
}
?>
</select>
<input type="submit" value="Add" />
</form>

<table>
<tr><td>Day</td><td>Period</td><td>Time</td><td>Delete?</td></tr>
<?php
$timeslots = get_tutor_timeslots($mysqli, $tutor->TID);
foreach($timeslots as $timeslot) {
	echo("<tr><td>" . $timeslot->DAYOFWEEK . "</td><td>" . $timeslot->Period . "</td><td>" . $timeslot->Time . "</td><td><a href=\"index.php?page=edit_tutor&amp;tutor_id=" . $tutor->TID . "&amp;timeslot=" . $timeslot->TSID . "&amp;day=" . $timeslot->DAYOFWEEK . "&amp;type=remove\">(X)</a></td></tr>");
}
?>
</table>
</div>