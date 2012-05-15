<?
require_once("../../course_controller.php");
require_once("display_admin.php");
?>
<div>
<h3>Courses - <a href="index.php?page=add_course">Add Course</a></h3>
<?php display_courses_admin(get_courses_by_crn($mysqli,"","")); ?>
</div>