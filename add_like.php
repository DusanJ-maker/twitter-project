<?php
include("./connection.php");

$tweet = $_POST['tweet'];
$id = $_POST["user_id"];

try {

    $sql = "INSERT INTO likes(tweets_id, users_id)
    VALUES ('$tweet', '$id')";

    $conn->exec($sql);
}   catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}




$conn = null;

?>