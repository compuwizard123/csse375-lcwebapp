<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Rose-Hulman Learning Center</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

<!-- Framework CSS -->
<link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
<!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->

<!-- Import fancy-type plugin -->
<link rel="stylesheet" href="css/blueprint/plugins/fancy-type/screen.css" type="text/css" media="screen, projection">
</head>

<body>
  <div class="container">
    <div class="header">
      <img src="img/rh.png" alt="Rose-Hulman Logo" style="height:75px;" />
      <h1 style="display:inline-block; vertical-align:top; margin-top:20px">Rose-Hulman Learning Center</h1>
    </div>
    <hr>
    <div class="span-4 colborder">
      <a href="index.php">Home</a><br />
      <a href="index.php?page=test">Submit Preferred Schedule</a><br />
      <a href="index.php?page=tutor_search">Search Tutors</a><br />
      <a href="index.php?page=tutor_profiles">Tutor Profiles</a><br />
      <a href="index.php?page=upload_document">Upload Document(s)</a>
    </div>
    <div class="span-18 last">
      <?php
         if(!isset($_GET['page'])) {
             require_once("pages/main.php");
         } else {
             if(file_exists("pages/" . $_GET['page'] . ".php")) {
                 require_once("pages/" . $_GET['page'] . ".php");
             } else {
                 require_once("pages/invalid_page.php");
             }
         }
      ?>
    </div>
    <hr>
  </div>
</body>
</html>
