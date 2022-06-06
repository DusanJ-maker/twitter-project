<?php
include("./connection.php");

$userName = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['psw'];
$password_confirm = $_POST['psw-repeat'];

// password_hash($password, PASSWORD_BCRYPT);
// password_hash($password_confirm, PASSWORD_BCRYPT);

$hashed_password1 = password_hash($password, PASSWORD_BCRYPT);
$hashed_password2 = password_hash($password_confirm, PASSWORD_BCRYPT);



try {

    $sql = "INSERT INTO Users(username, email, password, password_confirm)
    VALUES ('$userName', '$email', '$hashed_password1', '$hashed_password2')";

    $conn->exec($sql);
}   catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}




$conn = null;

?>