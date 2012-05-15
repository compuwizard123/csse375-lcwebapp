<?
require_once("../../tutor_controller.php");
require_once("display_tutors_admin.php");
?>
<div>
<h3>List Tutors</h3>
<?php display_tutors_admin(get_tutors_by_name($mysqli,"","")); ?>
</div>