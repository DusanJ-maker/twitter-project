<?php
include("./connection.php");

$tweetID = $_POST['id'];

try {

    $sql = "DELETE FROM tweets WHERE id = $tweetID";

    $conn->exec($sql);
}   catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}




$conn = null;

?>