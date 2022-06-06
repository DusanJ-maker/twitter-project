<?php
include("./connection.php");

$tweet = $_POST['tweet'];
$id = $_POST["user_id"];

try {

    $sql = "INSERT INTO tweets(user_id, tweet)
    VALUES ('$id', '$tweet')";

    $conn->exec($sql);
}   catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}




$conn = null;

?>