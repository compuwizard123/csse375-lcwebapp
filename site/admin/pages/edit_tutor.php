<?php
require_once("../../tutor_controller.php");
require_once("display_admin.php");
if(isset($_GET['tutor_id']))
   $tutor = get_tutor_by_id(getDBCon(),$_GET['tutor_id']);
if(!isset($tutor)) die("<h3>Invalid Tutor Id</h3>");
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
<ul>
<?php
foreach($courses as $course) {
	echo("<li>" . $course->course_number . " <a href=\"\">(X)</a></li>");
}
?>
<select name="courses">
<option value=""></option>
<?php
foreach(array_diff($all_courses,$courses) as $course) {
	echo("<option value=\"" . $course->CID . "\">" . $course->course_number . "</option>");
}
?>
</select>
<input type="button" name="add" value="Add" />
</ul>

<h4>Timeslots</h4>
<table>
<tr><td>Time</td><td>Period</td><td>Day</td></tr>
<?php
$timeslots = get_tutor_timeslots($mysqli, $tutor->TID);
foreach($timeslots as $timeslot) {
	echo("<tr><td>" . $timeslot->Time . "</td><td>" . $timeslot->Period . "</td><td>" . $timeslot->DAYOFWEEK . "</td></tr>");
}
?>
</table>
</div>