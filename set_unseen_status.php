<?php
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$connection = mysqli_connect("localhost", "root", "@Spk26611368", "chat_app", 3306);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$chatId = $_POST['other_user_id'];
$updateQuery = "UPDATE chat SET status_id = 2 WHERE user_from_id = '$chatId'";
$connection->query($updateQuery);

echo json_encode(["status" => "success"]);