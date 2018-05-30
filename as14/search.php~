
<?php
$dbhost = 'localhost';
$dbuser = 'cmbaker';
$dbpass = 'T5AJCSHAmDyDSXWF';
$dbdatabase = 'cmbaker';

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
if (mysqli_connect_errno()){
  echo 'Connect failed: '. mysqli_connect_error();
}

if (isset($_POST['title'])) {
  // Perform the query
  $stmt = $db->prepare('SELECT Title, MovieID, Rating, Year FROM Movie WHERE TITLE LIKE CONCAT("%", ?, "%") ORDER BY Year DESC');
  $stmt->bind_param('s', $_POST['title']);
  $stmt->execute();
  $stmt->bind_result($title, $movieID, $rating, $year);
  // Put the results in one array of associative arrays
  $results = array();
  while ($row = $stmt->fetch())
    $results[] = array('Title'=>$title,'MovieID'=>$movieID, 'Rating'=>$rating, 'Year'=>$year);
  //Magically encode the array using JSON, and echo it out as a response
  echo json_encode($results);
}

?>

