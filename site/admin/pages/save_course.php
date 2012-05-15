<?php
   require_once("../../course_controller.php");
?>
<div>
<?php
if(isset($_POST['course_number'])
	&& isset($_POST['description'])
	&& isset($_POST['department'])
	&& isset($_POST['course_id'])) {
		if($_POST['type'] == "add") {
			$result = add_course($mysqli, $_POST['department'],$_POST['course_number'],$_POST['description']);
		} else if($_POST['type'] == "update") {
			$result = update_course($mysqli,$_POST['course_id'],$_POST['department'],$_POST['course_number'], $_POST['description']);
		} else {
			$result = null;
		}
		if($result) {
			echo("<h3>Course Saved</h3>");
		} else {
			echo("<h3>Course Save Failed</h3>");
		}
} else {
	if($_POST['type'] == "delete") {
		if(delete_course($mysqli, $_POST['course_id'])) {
			echo("<h3>Course Deleted</h3>");
		} else {
			echo("<h3>Course Delete Failed</h3>");
		}
	} else {
		echo("Invalid Data");
	}
}
?>
</div>
