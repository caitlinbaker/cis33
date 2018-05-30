<!DOCTYPE HTML>
<html>
<h1> CIS 33 Assignment 08: Visitor Log</h1>
<h2>Add Log Entry</h2>
<form method="POST" action="#">
  <label for="comment">Comment:</label>
    <input type="text" name="comment" id="comment">
  <button type="submit">Add Entry</button>
  <button type="reset">Reset</button>
</form>
<?php
//echo 'yes';
$dbhost = 'localhost';
$dbuser = 'cmbaker';
$dbpass = 'T5AJCSHAmDyDSXWF';
$dbdatabase = 'cmbaker';
 
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
if (mysqli_connect_errno())
  echo 'Connect failed: '. mysqli_connect_error();
//else
  //echo 'success';
?>

<?php
// Only do this if we have received a GET form item named "q"
if (isset($_POST['comment'])) {
  $comment = strip_tags($_POST['comment']);
	$comment =htmlspecialchars($comment);
  //echo $comment;
}
 
$ip = $_SERVER['REMOTE_ADDR'];
//$host = gethostbyaddr($ip);
//echo 'add sql';
$stmt = $db->prepare('INSERT INTO as08_Log (Comment, IP) VALUES (?, INET6_ATON(?))');
$stmt->bind_param('ss', $comment, $ip);
$stmt->execute(); // Returns TRUE on success or FALSE on failure.
$stmt->close(); 
?>
<h2>Previous Entries</h2>
<table>
<tr><th>Comment ID</th><th>Comment</th><th>IP Address</th><th>Host Name</th><th>Date/Time</th></tr>
<?php
$results = $db->query('SELECT CommentID, Comment, INET6_NTOA(IP) as IP, TS FROM as08_Log ORDER BY TS desc');
while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
?>
  <tr><td><?=$row['CommentID']?></td><td><?=$row['Comment']?></td><td><?=$row['IP']?></td><td><?=gethostbyaddr($row['IP'])?></td><td><?=$row['TS']?></td></tr>
<?php
}
?>
</table>

</html>
