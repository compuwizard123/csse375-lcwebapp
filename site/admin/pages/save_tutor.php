<?php
   require_once("../../tutor_controller.php");
?>
<div>
<?php
if(isset($_POST['username'])
	&& isset($_POST['name'])
	&& isset($_POST['year'])
	&& isset($_POST['major'])
	&& isset($_POST['room_number'])
	&& isset($_POST['about'])) {
		if($_POST['type'] == "add") {
			$result = add_tutor($mysqli, $_POST['name'],$_POST['year'],$_POST['username'],$_POST['major'],$_POST['room_number'],$_POST['about']);
		} else if($_POST['type'] == "update") {
			$result = update_tutor($mysqli, $_POST['name'],$_POST['year'],$_POST['username'],$_POST['major'],$_POST['room_number'],$_POST['about']);
		} else {
			$result = null;
		}
		if($result) {
			echo("<h3>Tutor Saved</h3>");
		} else {
			echo("<h3>Tutor Save Failed</h3>");
		}
} else {
	if($_POST['type'] == "delete") {
		if(delete_tutor($mysqli, $_POST['username'])) {
			echo("<h3>Tutor Deleted</h3>");
		} else {
			echo("<h3>Tutor Delete Failed</h3>");
		}
	} else {
		echo("Invalid Data");
	}
}
?>
</div>
