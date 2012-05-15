<?php
require_once("../../tutor_controller.php");
require_once("display_admin.php");
$tutor = new Tutor();
?>
<div>
<h3>Add Tutor</h3>
<form method="post" action="index.php?page=save_tutor">
<input type="hidden" name="type" value="add" />
<table>
<tr><td>Username:</td><td><input type="text" name="username" value="<?php echo($tutor->TID);?>" /></td></tr>
<?php display_edit_tutor($tutor); ?>
</table>
</form>
</div>