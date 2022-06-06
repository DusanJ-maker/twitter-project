<?php 
	// connect to the database
	$con = mysqli_connect('localhost', 'root', '', 'twitter');

	if (isset($_POST['liked'])) {
		$postid = $_POST['postid'];
		$result = mysqli_query($con, "SELECT * FROM tweets WHERE id=$postid");
		$row = mysqli_fetch_array($result);
		$n = $row['likes'];

		mysqli_query($con, "INSERT INTO likes (users_id, tweets_id) VALUES (1, $postid)");
		mysqli_query($con, "UPDATE tweets SET likes=$n+1 WHERE id=$postid");

		echo $n+1;
		exit();
	}
	if (isset($_POST['unliked'])) {
		$postid = $_POST['postid'];
		$result = mysqli_query($con, "SELECT * FROM tweets WHERE id=$postid");
		$row = mysqli_fetch_array($result);
		$n = $row['likes'];

		mysqli_query($con, "DELETE FROM likes WHERE users_id=$postid AND users_id=1");
		mysqli_query($con, "UPDATE tweets SET likes=$n-1 WHERE id=$postid");
		
		echo $n-1;
		exit();
	}

	// Retrieve posts from the database
	$posts = mysqli_query($con, "SELECT * FROM tweets");
?>