<?php
	require_once("../tutor_controller.php");
	require_once("display_tutors.php");
?>
<div>
  <h3>Tutor Profiles</h3>
  <?php
     display_tutors(get_tutors_by_name($mysqli, ""));
  ?>
</div>
