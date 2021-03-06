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
  <title>CIS 33 AS14</title>
  </head>
  <body>
    <form action="#" method="POST" id="userauth">
      <input type="text" name="username" id="username" placeholder="Username">
      <input type="password" name="password" id="password" placeholder="Password">
      <button type="submit" id="login" value="login" >Login</button>
    </form>
    <form action="register.php" method="POST">
      <button type="submit" id="newuser">Create Account</button>
    </form>

    <table>
      <tr><th>Movie</th><th>Average Review</th><th>Total Reviews</th></tr>
      <?php
      $results = $db->query('SELECT Movie.Title as Movie, ROUND(AVG(Movie_Reviews.Review), 1) as Average, COUNT(Movie_Reviews.Review) as Number FROM Movie_Reviews JOIN Movie ON Movie_Reviews.MovieID = Movie.MovieID GROUP BY Movie.Title ORDER BY Average desc');
      while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
      ?>
      <tr><td><?=$row['Movie']?></td><td><?=$row['Average']?></td><td><?=$row['Number']?></td></tr>
     <?php
     }
     ?>
    </table>
  </body>


<?php
}

elseif ($_SESSION['loggedin']) {
    echo "Welcome ".$_SESSION['username'] . "!";
    echo '<script>';
      echo 'var uname = "'.$_SESSION['username'].'";';
    echo '</script>';
?>
    <form action="logout.php" method="POST" id="logout">
      <button type="submit" id="logout" value="logout">Logout</button>
    </form>

	Movie title search: <input type="search" id="searchquery" onkeyup="fetchResults()">
	<h2 id="totals"></h2>
	<table id="resultlist">
	</table>

	<script>
	function fetchResults() {
  	// Clear the result list table
  	let resultList = document.getElementById('resultlist');
  	while (resultList.firstChild)
    	resultList.removeChild(resultList.firstChild);
  	// Get 
  	let query = document.getElementById('searchquery').value;   // Get the query text
  	if (query.length < 3) {               // If it's too short, forget it
    	document.getElementById('totals').textContent = 'Enter three or more characters.';
    	return;
  	}
  	// Fetch results from the back-end running on the server, and update the resultlist table
  	let formData = new FormData();
  	formData.append('title', query);
  	window.fetch('/~cmbaker/cis33/as14/search.php', {
    	method: 'post',
    	body: formData
  	}).then(response =>
    	response.json() // Extract the response as a JSON object
  	).then(responseData => {
    	document.getElementById('totals').textContent = responseData.length + ' results';
    	let headerRow = document.createElement('tr');
    	['Title', 'Rating', 'Year', 'Review'].forEach(headerText => {
      	let th = document.createElement('th');
      	th.textContent = headerText;
      	headerRow.appendChild(th);
    	});
    	resultList.appendChild(headerRow);
    	responseData.forEach(resultObj => {
      	let row = document.createElement('tr');
      	['Title', 'Rating', 'Year'].forEach(key => {
        	let td = document.createElement('td');
        	td.textContent = resultObj[key];
        	row.appendChild(td);
      	});
       	let td2 = document.createElement('td');
        for (i = 1; i < 6; i++) {
          let sp = document.createElement('span');
          sp.textContent = ' '+i+' ';
          sp.addEventListener('click', post_review.bind(null, resultObj['MovieID'], i) );
          td2.appendChild(sp);
        }
        row.appendChild(td2);
     	 resultList.appendChild(row);
    	});
  	});
	}

  function post_review(id, rating) {
    //alert("rated movie: "+id+" "+rating+" stars");
    
		let formData = new FormData();
    formData.append('MovieID', id);
    formData.append('Review', rating);
    formData.append('Username', uname);
    window.fetch('/~cmbaker/cis33/as14/new_review.php', {
      method: 'post',
      body: formData
    }).then(
    	response => response.json() // Extract the response as a JSON object
    ).then(responseData => {
      //alert(JSON.stringify(responseData));
      alert('Review registered');
      location.reload();
    });
  }

	</script>
  
   <table>
      <tr><th>Movie</th><th>My Review</th><th>Average Reviews</th><th>Total Reviews</th><th>Edit Review</th></tr>
      <?php

      $stmt3 = $db->prepare('SELECT Movie.MovieID, Movie_Reviews.Review as Review1 FROM Movie_Reviews JOIN Movie ON Movie_Reviews.MovieID = Movie.MovieID JOIN AS14_USER ON AS14_USER.UserID = Movie_Reviews.UserID WHERE Username = ? ORDER BY Review1 desc');
      $stmt3->bind_param('s', $_SESSION['username']);
      $stmt3->execute();
      $stmt3->bind_result($movieID, $review);
      $user_results = array();
      while ($stmt3->fetch()) {
        $user_results[$movieID] = $review;
      }
      $stmt3->close();

      $stmt4= $db->prepare('SELECT Movie.Title as Movie, Movie.MovieID as ID, ROUND(AVG(Movie_Reviews.Review), 1) as Average, COUNT(Movie_Reviews.Review) as Number FROM Movie_Reviews JOIN Movie ON Movie_Reviews.MovieID = Movie.MovieID GROUP BY Movie.Title, Movie.MovieID ORDER BY Average desc');
      $stmt4->execute();
      $stmt4->bind_result($movie_title, $mID, $average, $count);
			while($stmt4->fetch()){
        $edit_rating = '';
        for ($x = 1; $x < 6; $x++) {
          $edit_rating .= "<span onclick=\"post_review($mID, $x)\"> $x </span>";
        }
        if (isset($user_results[$mID])) {
      ?>
       <tr><td><?=$movie_title?></td><td><?=$user_results[$mID]?></td><td><?=$average?></td><td><?=$count?></td><td><?=$edit_rating?></td></tr>
      <?php
        } else {
      ?>
       <tr><td><?=$movie_title?></td><td></td><td><?=$average?></td><td><?=$count?></td><td><?=$edit_rating?></td></tr>
			<?php
        }
      }
			 
     ?>

  </table>
  </html>



<?php
}

if (isset($_POST['username']) and isset($_POST['password'])) {
  $username= $_POST['username'];
  $password= $_POST['password'];

}
$stmt = $db->prepare('SELECT Password FROM AS14_USER WHERE Username=?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($hashed);
$stmt->fetch();
$stmt->close();

if (isset($hashed)){
  //$validpassword = password_verify($password, $hashed);
  if (password_verify($password, $hashed)){
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $username;
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

