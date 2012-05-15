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
    <a href="mailto:<?php echo($tutor->email); ?>">
      <?php echo($tutor->TID . "@rose-hulman.edu"); ?></a>
    <br />
    <?php echo($tutor->Room_Number); ?><br /><br />
    
    <b>Tutoring Times:</b><br />
    <b>Classroom:</b><br />
    Sunday: 8-11pm<br />
    Thursday: 8-11pm<br />
    
    <b>Learning Center:</b><br />
    Monday: 4th hour<br />
    Tuesday: 4th hour<br />
    
    <b>Office Hours:</b><br />
    <p>You're welcome to come on in and ask a question or just sit and
      visit.</p>
    
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
		echo("<b>" . $dept . "</b>");
		echo("<ul>");
		foreach($courses as $course) {
			echo ("<li>" . $course->course_number . ": " . $course->course_description . "</li>");
		}
		echo("</ul>");
	}
    ?>
  </div>
</div>
