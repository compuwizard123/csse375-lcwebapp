<?php
require_once("../../tutor_controller.php");
require_once("display_tutors_admin.php");
if(isset($_GET['tutor_id']))
   $tutor = get_tutor_by_id(getDBCon(),$_GET['tutor_id']);
if(!isset($tutor)) die("<h3>Invalid Tutor Id</h3>");
?>
<div>
<h3>Edit Tutor - <?php echo($tutor->TID); ?></h3>
<form method="post" action="index.php?page=save_tutor">
<input type="hidden" name="type" value="update" />
<input type="hidden" name="username" value="<?php echo($tutor->TID);?>" />
<table>
<tr><td>Username:</td><td><?php echo($tutor->TID);?></td></tr>
<?php display_edit_tutor($tutor); ?>
</table>
</form>
</div>