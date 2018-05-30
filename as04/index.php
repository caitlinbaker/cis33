<!DOCTYPE html>
<html>
  <head>
    <title>CIS 33 Assignment 04</title>
  </head>
  <body>
    <?php 
    $counter=1;
    do {
     $roll1=rand(1,6);
     $roll2=rand(1,6);
     echo "<section id='round$counter'><h2>Roll $counter</h2><img src='/datasets/dice/die_0$roll1.png' alt='Die $roll1'> <img src='/datasets/dice/die_0$roll2.png' alt='Die $roll2'> </section>";
    $counter++;
     } while($roll1+$roll2 != 2);
     $counter--;
     echo "<h1 id='total'>$counter rolls total</h1>";
    ?>
  </body>
</html>
