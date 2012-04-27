<?php
function display_tutors($tutors) {
  if($tutors) {
    echo("<table>");
    foreach($tutors as $tutor) {
      echo("<tr>");
      echo("<td><a href=\"index.php?page=tutor_profile&amp;tutor_id=" . $tutor->TID . "\">" . $tutor->name . "</a></td>");
      echo("<td>" . $tutor->major . "</td>");
      echo("<td>" . $tutor->TID . "@rose-hulman.edu</td>");
      echo("</tr>");
    }
    echo("</table>");
  } else {
    echo("No results found.");
  }
}
?>