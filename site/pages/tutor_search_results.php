<?php
   require_once("../tutor_controller.php");
   require_once("display_tutors.php");
?>
<div>
<?php
   if(!isset($_GET['type']) || !isset($_GET['search'])) {
       var_dump($_GET);
   } else {
       echo("<h3>Tutor Search Results ");
       switch($_GET['type']) {
           case "name":
               echo("By Name For \"" . $_GET['search'] . "\"</h3>");
               display_tutors(get_tutors_by_name($_GET['search'],""));
               break;
           case "course":
               echo("By Course For \"" . $_GET['search'] . "\"</h3>");
               display_tutors(get_tutors_by_course($_GET['search'],""));
               break;
           default:
               echo("<h3>Invalid Search Type</h3>");
       }
   }
?>
</div>
