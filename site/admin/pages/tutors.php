<?
require_once("../../tutor_controller.php");
require_once("display_admin.php");
?>
<div>
<h3>Tutors - <a href="index.php?page=add_tutor">Add Tutor</a></h3>
<?php display_tutors_admin(get_tutors_by_name($mysqli,"","")); ?>
</div>