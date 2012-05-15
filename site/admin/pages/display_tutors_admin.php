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
?>