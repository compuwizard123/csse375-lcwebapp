<?php
require_once("../tutor_controller.php");
if(isset($_GET['tutor_id']))
   $tutor = get_tutor_by_id(getDBCon(),$_GET['tutor_id']);
if(!isset($tutor)) die("<h3>Invalid Tutor Id</h3>");
?>

<div>
  <h3><?php echo($tutor->name) ?> (<?php echo($tutor->major); ?>)</h3>
  <hr>
  <div class="span-8 colborder append-1">
    <a href="mailto:<?php echo($tutor->TID . "@rose-hulman.edu"); ?>">
      <?php echo($tutor->TID . "@rose-hulman.edu"); ?></a>
    <br />
    <?php echo($tutor->Room_Number); ?><br /><br />
    
    <b>Tutoring Times:</b><br />	
	<?php
	$dayTimeslots = array();
	foreach(get_tutor_timeslots($mysqli, $tutor->TID) as $timeslot) {
		if(array_key_exists($timeslot->DAYOFWEEK, $dayTimeslots)) {
			array_push($dayTimeslots[$timeslot->DAYOFWEEK], $timeslot);
		} else {
			$dayTimeslots[$timeslot->DAYOFWEEK] = array($timeslot);
		}
    }
	echo("<dl>");
	foreach($dayTimeslots as $day => $timeslots) {
		echo("<dt>" . ucfirst(strtolower($day)) . "</dt>");
		foreach($timeslots as $timeslot) {
			if(!is_numeric($timeslot->Period)) {
				echo("<dd>" . strtolower(strftime("%I:%M pm", strtotime($timeslot->Time))) . "</dd>");
			} else {
				echo("<dd>" . $timeslot->Period . "th hour</dd>");
			}
		}
	}
	echo("</dl>");
	?>

    <b>What I can help you with:</b><br />
    <ul>
      <li>Any course in the list on the right</li>
      <li>Matlab</li>
      <li>Most Rose computer programs or issues (Maple, Ofice,
        etc.)</li>
    </ul>
  </div>
  <div class="span-8 last">
    <p>
      <img src="../tutor_pics/<?php echo($tutor->TID);?>.jpg" alt="<?php echo($tutor->name); ?> Pic" height="300" width="250" />
    </p>
    <b>Courses I Can Help With:</b><br />
    <?php
    $deptCourses = array();
	foreach(get_tutor_courses_tutored($mysqli,$tutor->TID) as $course) {
		if(array_key_exists($course->department, $deptCourses)) {
			array_push($deptCourses[$course->department], $course);
		} else {
			$deptCourses[$course->department] = array($course);
		}
    }

	foreach($deptCourses as $dept => $courses) {
		echo("<dl>");
		echo("<dt>" . $dept . "</dt>");
		foreach($courses as $course) {
			echo ("<dd>" . $course->course_number . ": " . $course->course_description . "</dt>");
		}
		echo("</dl>");
	}
    ?>
  </div>
</div>
