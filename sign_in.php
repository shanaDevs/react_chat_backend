<?php

$mobile = $_POST['mobile'];
$password = $_POST['password'];

$connection = new mysqli("localhost", "root", "@Spk26611368", "chat_app", "3306");

$query = "SELECT * FROM user WHERE mobile = '$mobile' AND password = '$password'";
$result = $connection->query($query);

$phpResponseObject = new stdClass();

if ($result->num_rows == 0) {
    $phpResponseObject->status = "error";
    $phpResponseObject->message = "Invalid mobile or password.";
} else {
    $phpResponseObject->status = "success";
    $phpResponseObject->message = "Sign-in successful!";
    $row = $result->fetch_assoc();
    $phpResponseObject->user = $row;
}

echo json_encode($phpResponseObject);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$connection->close();
?>