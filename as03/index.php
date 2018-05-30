<!DOCTYPE html>
<html>
  <head>
    <title>CIS 33 as03</title>
  </head>
  <body>
    <?php

    $randnum=rand(0,999);
    echo "<div id='number'>$randnum</div>";
    if ($randnum < 10){
      $arr1 = str_split($randnum);
      echo "<figure id='ones' title='$arr1[0] ones'><img src='/datasets/asl-0-10/us-0$arr1[0]_sm.png' alt='$arr1[0] ones'><figcaption>$arr1[0] ones</figcaption></figure>";
      }
    elseif ($randnum > 9 && $randnum < 100){
      $arr2 = str_split($randnum);
      echo "<figure id='tens' title='$arr2[0] tens'><img src='/datasets/asl-0-10/us-0$arr2[0]_sm.png' alt='$arr2[0] ones'><figcaption>$arr2[0] tens</figcaption></figure>";
      echo "<figure id='ones' title='$arr2[1] ones'><img src='/datasets/asl-0-10/us-0$arr2[1]_sm.png' alt='$arr2[1] tens'><figcaption>$arr2[1] ones</figcaption></figure>";
     } 
    elseif ($randnum >= 100){
      $arr3 = str_split($randnum);
      echo "<figure id='hundreds' title='$arr3[0] hundreds'><img src='/datasets/asl-0-10/us-0$arr3[0]_sm.png' alt='$arr3[0] hundreds'><figcaption>$arr3[0] hundreds</figcaption></figure>";
      echo "<figure id='tens' title='$arr3[1] tens'><img src='/datasets/asl-0-10/us-0$arr3[1]_sm.png' alt='$arr3[1] tens'><figcaption>$arr3[1] tens</figcaption></figure>";
      echo "<figure id='ones' title='$arr3[2] ones'><img src='/datasets/asl-0-10/us-0$arr3[2]_sm.png' alt='$arr3[2] ones'><figcaption>$arr3[2] ones</figcaption></figure>";
      }
    ?>
  </body>
</html>
