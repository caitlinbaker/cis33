<?php
session_start();

?>

<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>CIS 33 AS14</title>
  </head>
  <form action='#' method='POST' id='newuser'>
  Username (64 character maximum):<br>
  <input type='text' name='username'><br>
  Password (12 character minimum):<br>
  <input type='password' name='password'><br>
  Password (again):<br>
  <input type='password' name='password_repeat'><br>
  <button type='submit'>Register</button>
  </form>

  <form action='index.php' method='POST'>
   <button type='submit'>Home</button>
  </form>

</html>
<?php
  $username_attempt= $_POST['username'];
  $password_attempt= $_POST['password'];
  $password2_attempt= $_POST['password_repeat'];

  $dbhost = 'localhost';
  $dbuser = 'cmbaker';
  $dbpass = 'T5AJCSHAmDyDSXWF';
  $dbdatabase = 'cmbaker';

  $db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
  if (mysqli_connect_errno()){
    echo 'Connect failed: '. mysqli_connect_error();
  }
  //else{
    //echo 'Sucess';
 // }
 $create_account = false;
 if(strlen($username_attempt) < 64 and strlen($username_attempt) > 0){
      if(strlen($password_attempt) >= 12){
        if($password_attempt == $password2_attempt){
          $stmt1 = $db->prepare('SELECT * FROM AS14_USER WHERE Username = ?');
          $stmt1->bind_param('s', $username_attempt);
          $stmt1->execute();
          $rows = $stmt1->fetch();
          $num_rows = count($rows);
          $stmt1->close();
          if($num_rows > 0){
            echo 'User already exists';
          }
          else{
            $create_account = true;
          }
        }
        else{
          echo 'Passwords did not match';
        }
      }
      else{
        echo 'Password must be at least 12 characters long';
      }
    }
    elseif(isset($username_attempt)){
      echo 'Username must be between 1 and 64 characters';
    }
    //echo $create_account;
    //echo $username_attempt;
    if ($create_account){
     // echo $password_attempt;
      $hashed = password_hash($password_attempt, PASSWORD_DEFAULT, ['cost' => 12]);
      $stmt = $db->prepare('INSERT INTO AS14_USER (Username, Password) VALUES (?, ?)');
      $stmt->bind_param('ss', $username_attempt, $hashed);
      $test = $stmt->execute();
      //echo '<br>';
      //echo $test;
      $stmt->close();
      echo 'Account created';
      }

?>

