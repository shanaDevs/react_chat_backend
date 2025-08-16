<?php 

$requestJson = $_POST['requestJSON'];
$request_object = json_decode($requestJson);

$from_id = $request_object->from_user_id;
$to = $request_object->to_user_id;
$message = $request_object->msg;
$dateTime = date("Y-m-d H:i:s");
$status = 1;

$connection = mysqli_connect("localhost", "root", "@Spk26611368", "chat_app", 3306);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$connection->query("INSERT INTO chat (user_from_id, user_to_id, message, date_time, status_id) VALUES ('$from_id', '$to', '$message', '$dateTime', '$status')");

echo "Message saved successfully.";
