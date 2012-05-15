<?php
require_once("../../course_controller.php");
require_once("display_admin.php");
$course = new Course();
?>
<div>
<h3>Add Course</h3>
<form method="post" action="index.php?page=save_course">
<input type="hidden" name="type" value="add" />
<table>
<?php display_edit_course($course); ?>
</table>
</form>
</div>