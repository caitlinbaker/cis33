<?php
session_start();

$username = $_SESSION['username'];

$dbhost = 'localhost';
$dbuser = 'cmbaker';
$dbpass = 'T5AJCSHAmDyDSXWF';
$dbdatabase = 'cmbaker';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
if (mysqli_connect_errno()){
  echo 'Connect failed: '. mysqli_connect_error();
}

$log_status = 'logout';

$stmt3 = $db->prepare('SELECT UserID FROM USER WHERE Username=?');
$stmt3->bind_param('s', $username);
$stmt3->execute();
$stmt3->bind_result($userid);
$stmt3->fetch();
$stmt3->close();

$ip = $_SERVER['REMOTE_ADDR'];
$stmt2 = $db->prepare('INSERT INTO AuthLogEntry (UserID, IP, EventType) VALUES (?, INET6_ATON(?), ?)');
$stmt2->bind_param('sss', $userid, $ip, $log_status);
$stmt2->execute(); // Returns TRUE on success or FALSE on failure.
$stmt2->close();

session_destroy();
header('Location: index.php');
?>
