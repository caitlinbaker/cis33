<?php 
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>CIS 33 Assignment 02</title>  
  </head>
  <body>
    <h1>Welcome to CIS 33!</h1>
    The time is now: <?php echo date('Y-m-d G:i:s'); ?>
    <br>
    You are visiting from: <?php echo $_SERVER['REMOTE_ADDR'];?>
  </body>
</html>

