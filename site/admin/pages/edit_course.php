<?php
require_once("../../course_controller.php");
require_once("display_admin.php");
if(isset($_GET['course_id']))
   $course = get_course_by_cid(getDBCon(),$_GET['course_id']);
if(!isset($course)) die("<h3>Invalid Course Id</h3>");
?>
<div>
<h3>Edit Course - <?php echo($course->course_number); ?></h3>
<form method="post" action="index.php?page=save_course">
<input type="hidden" name="type" value="update" />
<input type="hidden" name="course_id" value="<?php echo($course->CID);?>" />
<table>
<?php display_edit_course($course); ?>
</table>
</form>
</div>