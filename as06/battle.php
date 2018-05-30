<!DOCTYPE html>
<html>
 <head>
   <title>CIS 33 AS06</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 </head>
 <body>
  <?php
    class Player {
      static $characters = array('Cecil', 'Edge', 'Kain', 'Rosa', 'Rydia');
      protected $name, $char, $hp, $status;
      /**
      * Creates a new Player object with the given name
      * and random HP in the range [maxhp/2, maxhp]
      */
      function Player($name) {
        $this->char = Player::$characters[rand(0, count(Player::$characters)-1)];
        $this->name = $name;
        $this->hp = rand($_GET['maxhp']/2, $_GET['maxhp']);
        $this->status='normal';
      }
                                      
      /**
      * Attacks the other character, updating the respective HP and status.
      */
      function attack($other) {
        if ($other->hp < $_GET['maxattack']){
          $other->hp = $other->hp - rand(1,$other->hp);
          }
        else{
          $other->hp = $other->hp - rand(1,$_GET['maxattack']);
        }
        if ($other->hp <= 0){
          $other->status = 'dead';
          $this->status = 'victory';
          }
        elseif ($other->hp <= 5){
          $other->status = 'weak';
          $this->status = 'attack';
          }
        else{
          $other->status = 'defend';
          $this->status = 'attack';
          }

      }
                                                         
      /** Returns this player's current HP */
      function getHP() {
        return $this->hp;
      }
                                                                      
      /** Returns this player's given name */
      function getName() {
        return $this->name;
      }
      function getStatus(){
        return $this->status;
        }
                                                                                   
      /** Returns an img tag representing the current state of this player */
      function getImg() {
        return "<img src='http://jeff.cis.cabrillo.edu/datasets/ff/$this->char-$this->status.gif' alt='$this->name: $this->status'>";
      }
    }
     $player1= new Player($_GET['p1']);
     $player2= new Player($_GET['p2']);
     $rand = rand(1,2);
     echo $player1->getImg();
     echo $player1->getName();
     echo $player1->getHP();

     echo $player2->getImg();
     echo $player2->getName();
     echo $player2->getHP();

     $counter = 1;
     //echo $player1->getStatus();

     if ($rand == 1){

       while($player1->getStatus() != 'dead' and $player2->getStatus() != 'dead'){
         $player1->attack($player2);
         echo 'Player 1 HP: <span id="round'.$counter.'p1hp">'.$player1->getHP().'</span>';
         echo 'Player 2 HP: <span id="round'.$counter.'p2hp">'.$player2->getHP().'</span>';
         echo $player1->getImg();
         echo $player2->getImg();
         $counter++;
         if ($player2->getStatus() == 'dead'){
           break;
         }
         $player2->attack($player1);
         echo 'Player 1 HP: <span id="round'.$counter.'p1hp">'.$player1->getHP().'</span>';
         echo 'Player 2 HP: <span id="round'.$counter.'p2hp">'.$player2->getHP().'</span>';
         echo $player1->getImg();
         echo $player2->getImg();
         $counter++;
         }
       }
      elseif ($rand == 2){
        while ($player1->getStatus() != 'dead' and $player2->getStatus() != 'dead' ){
        $player2->attack($player1);
        echo 'Player 1 HP: <span id="round'.$counter.'p1hp">'.$player1->getHP().'</span>';
        echo 'Player 2 HP: <span id="round'.$counter.'p2hp">'.$player2->getHP().'</span>';
        echo $player1->getImg();
        echo $player2->getImg();
        $counter++;
         if ($player2->getStatus() == 'dead'){
          break;
         }
        $player1->attack($player2);
        echo 'Player 1 HP: <span id="round'.$counter.'p1hp">'.$player1->getHP().'</span>';
        echo 'Player 2 HP: <span id="round'.$counter.'p2hp">'.$player2->getHP().'</span>';
        echo $player1->getImg();
        echo $player2->getImg();
        $counter++;
        }
      }
       if ($player1->getStatus() == 'victory'){
        echo 'Victory for '.$player1->getName().'';
       }
       elseif ($player2->getStatus() == 'victory'){
         echo 'Victory for '.$player2->getName().'';
       }
     //echo $player1->getImg();
     //echo $player1->getName();
     //echo $player1->getHP();
     //echo cats;

   ?>
 </body>
</html>
