<?php
function display_tutors_admin($tutors) {
  if($tutors) {
    echo("<table>");
    foreach($tutors as $tutor) {
	  echo("<form method=\"POST\" action=\"index.php?page=save_tutor\"");
      echo("<tr>");
	  echo("<td><a href=\"index.php?page=edit_tutor&amp;tutor_id=" . $tutor->TID . "\">Edit</a></td>");
      echo("<td>" . $tutor->name . "</td>");
      echo("<td>" . $tutor->major . "</td>");
      echo("<td>" . $tutor->TID . "@rose-hulman.edu</td>");
	  echo("<input type=\"hidden\" name=\"username\" value=\"" . $tutor->TID . "\" />");
	  echo("<input type=\"hidden\" name=\"type\" value=\"delete\" />");
	  echo("<td><input type=\"submit\" value=\"Delete\" /></td>");
      echo("</tr>");
	  echo("</form>");
    }
    echo("</table>");
  } else {
    echo("No results found.");
  }
}

function display_edit_tutor($tutor) {
	echo("
	<tr><td>Name:</td><td><input type=\"text\" name=\"name\" value=\"" . $tutor->name . "\" /></td></tr>
	<tr><td>Year:</td><td><input type=\"text\" name=\"year\" value=\"" . $tutor->year . "\" /></td></tr>
	<tr><td>Major:</td><td><input type=\"text\" name=\"major\" value=\"" . $tutor->major . "\" /></td></tr>
	<tr><td>Room #:</td><td><input type=\"text\" name=\"room_number\" value=\"" . $tutor->Room_Number . "\" /></td></tr>
	<tr><td>About:</td><td><input type=\"text\" name=\"about\" value=\"" . $tutor->about_tutor . "\" /></td></tr>
	<tr><td colspan=\"2\" style=\"text-align:center\"><input type=\"submit\" value=\"Save\" /></td></tr>
	");
}

function display_courses_admin($courses) {
	if($courses) {
		echo("<table>");
		foreach($courses as $course) {
			echo("<form method=\"POST\" action=\"index.php?page=save_course\"");
			echo("<tr>");
			echo("<td><a href=\"index.php?page=edit_course&amp;course_id=" . $course->CID . "\">Edit</a></td>");
			echo("<td>" . $course->course_number . "</td>");
			echo("<td>" . $course->course_description . "</td>");
			echo("<input type=\"hidden\" name=\"course_id\" value=\"" . $course->CID . "\" />");
			echo("<input type=\"hidden\" name=\"type\" value=\"delete\" />");
			echo("<td><input type=\"submit\" value=\"Delete\" /></td>");
			echo("</tr>");
			echo("</form>");
		}
		echo("</table>");
	} else {
		echo("No results found.");
	}
}

function display_edit_course($course) {
	echo("
	<input type=\"hidden\" name=\"course_id\" value=\"" . $course->CID . "\" />
	<tr><td>Course Number:</td><td><input type=\"text\" name=\"course_number\" value=\"" . $course->course_number . "\" /></td></tr>
	<tr><td>Course Description:</td><td><input type=\"text\" name=\"description\" value=\"" . $course->course_description . "\" /></td></tr>
	<tr><td>Department:</td><td><input type=\"text\" name=\"department\" value=\"" . $course->department . "\" /></td></tr>
	<tr><td colspan=\"2\" style=\"text-align:center\"><input type=\"submit\" value=\"Save\" /></td></tr>
	");
}
?>