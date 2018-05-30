<?php
  //session_start();
	//$username = $_SESSION['username'];

  $dbhost = 'localhost';
  $dbuser = 'cmbaker';
  $dbpass = 'T5AJCSHAmDyDSXWF';
  $dbdatabase = 'cmbaker';

  $db = new mysqli($dbhost, $dbuser, $dbpass, $dbdatabase);
  if (mysqli_connect_errno()){
    echo 'Connect failed: '. mysqli_connect_error();
  }

	$movieID= $_POST['MovieID'];
	$review= $_POST['Review'];
	$username = $_POST['Username'];

	$stmt1 = $db->prepare('SELECT UserID FROM AS14_USER WHERE Username = ?');
  $stmt1->bind_param('s', $username);
  $stmt1->execute();
	$stmt1->bind_result($userID);
  $stmt1->fetch();
  $stmt1->close();
  
  $stmt2 = $db->prepare('SELECT ReviewID FROM Movie_Reviews WHERE UserID = ? and MovieID = ?');
  $stmt2->bind_param('ii', $userID, $movieID);
  $stmt2->execute();
	$stmt2->bind_result($reviewID);
  $stmt2->fetch();
  //$rows = $stmt1->fetch();
  //$num_rows = count($rows);
  $stmt2->close();


//  echo $userID;
  echo json_encode(array('movieID' => $movieID, 'review' => $review, 'user' => $username, 'userid' => $userID));
  
  if(!isset($reviewID)){
	  $stmt = $db->prepare('INSERT INTO Movie_Reviews (UserID, MovieID, Review) VALUES (?, ?, ?)');
    $stmt->bind_param('iii', $userID, $movieID, $review);
    $test = $stmt->execute();
    $stmt->close();
  }
  elseif(isset($reviewID)){
    $stmt3 = $db->prepare('UPDATE Movie_Reviews SET Review = ? WHERE ReviewID = ?');
    $stmt3->bind_param('ii', $review, $reviewID);
    $test = $stmt3->execute();
    $stmt3->close();
	}


?>
