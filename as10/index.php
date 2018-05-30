<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'cmbaker';
$dbpass = 'T5AJCSHAmDyDSXWF';
$dbdatabase = 'cmbaker';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
if (mysqli_connect_errno()){
  echo 'Connect failed: '. mysqli_connect_error();
}


if(!$_SESSION['loggedin']) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>CIS 33 AS10</title>
</head>

  <form action="#" method="POST" id="userauth">
    <input type="text" name="username" id="username" placeholder="Username">
    <input type="password" name="password" id="password" placeholder="Password">
    <button type="submit" id="login" value="login" >Login</button>
  </form>
  <form action="register.php" method="POST">
    <button type="submit" id="newuser">Create Account</button>
  </form>


<?php
}

elseif ($_SESSION['loggedin']) {
    echo "Welcome, ".$_SESSION['username'] . "!";
?>
    
      <form action="logout.php" method="POST" id="logout">
        <button type="submit" id="logout" value="logout">Logout</button>
      </form>
    

<?php
  
}

if (isset($_POST['username']) and isset($_POST['password'])) {
  $username= $_POST['username'];
  $password= $_POST['password'];
  //echo $username;
  //echo $password;
}
$stmt = $db->prepare('SELECT UserID, Password FROM USER WHERE Username=?');
//echo 'ok';
$stmt->bind_param('s', $username);
//echo 'ok1';
$stmt->execute();
//echo 'ok2';
$stmt->bind_result($userid, $hashed);
$stmt->fetch();
//echo 'ok3';
//echo '<br>';
//echo '<br>';
$stmt->close();

if (isset($hashed)){
  //$validpassword = password_verify($password, $hashed);
  if (password_verify($password, $hashed)){
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
    $log_status = 'login';
		$ip = $_SERVER['REMOTE_ADDR'];

		$stmt2 = $db->prepare('INSERT INTO AuthLogEntry (UserID, IP, EventType) VALUES (?, INET6_ATON(?), ?)');
		$stmt2->bind_param('sss', $userid, $ip, $log_status);
		//echo 'table yes';
		$stmt2->execute(); // Returns TRUE on success or FALSE on failure.
		$stmt2->close();
   
    header('Location: index.php');
  }

  else{
    echo 'Invalid username/password. Please try again.';
  }
}

elseif(isset($_POST['username']) and isset($_POST['password'])) {
  echo 'Invalid username/password. Please try again.';
}


?>

  <h1>Event Log</h1>
  <table id="logentries">
    <tr><th>Date/Time</th><th>Event</th></tr>
    <?php
    $results = $db->query('SELECT Username, INET6_NTOA(IP) as IP, DateTime, EventType FROM AuthLogEntry JOIN USER ON AuthLogEntry.UserID = USER.UserID ORDER BY DateTime desc');

    while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
      if($row['EventType'] == 'login'){
        $table_string = 'logged in from';
        }
      elseif($row['EventType'] == 'create'){
        $table_string = 'created an account from';
        }
      elseif($row['EventType'] == 'logout'){
        $table_string = 'logged out from';
        }
    ?>
      <tr><td><?=$row['DateTime']?></td><td><?=$row['Username'].' '.$table_string.' '.$row['IP']?></td></tr>
    <?php
    }
    ?>
  </table>
</html>


