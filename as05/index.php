<!DOCTYPE html>
<html>
<head>
<title>CS 33 as05</title>
</head>
<body>
<?php
/** Class SixSidedDie represents a simple, rollable 6-sided die */
class SixSidedDie {
   // Variables:
  /** The current roll value for this die */
  protected $currentValue = -1;
  // Functions:
  /** "Rolls" the die (generates a new, random, current roll value) */
  function roll() {
    // Choose a new value for $currentValue (random between 1 and 6)
    $this->currentValue = rand(1, 6);
    }
  function getValue(){
    return $this->currentValue;
    }
  /** Returns the image URL that represents the current roll */
  function getImageURL() {
  // Return the URL for the image representing the current roll
    return 'http://jeff.cis.cabrillo.edu/datasets/dice/die_0'.$this->currentValue.'.png';
                                               }
}

class DicePair {
  protected $die1;
  protected $die2;
  
  function DicePair() {
    $this->die1 = new SixSidedDie();
    $this->die2 = new SixSidedDie();
    }
  
  function roll() {
    $this->die1->roll();
    $this->die2->roll();
    echo '<img src="'.$this->die1->getImageURL().'" alt="A die roll"><img src="'.$this->die2->getImageURL().'" alt="A die roll">';
    }

  function isSnakeEyes() {
    if($this->die1->getValue() + $this->die2->getValue() == 2){
      return True;
      }
    else {
      return False;
      }
    }
                                             
}
$dice = new DicePair();
$counter = 1; 
do {
  echo '<section id="round'.$counter.'"><h2>Roll '.$counter.'</h2>';
  $dice->roll();
  echo '</section>';
  $snakeEyes = $dice->isSnakeEyes();
  $counter++;
  
  } while($snakeEyes != True);

echo '<h1 id="total">'.($counter-1).' rolls total</h1>';

?>
</body>
</html>
