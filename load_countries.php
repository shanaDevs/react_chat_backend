<?php 
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$connection = mysqli_connect("localhost", "root", "@Spk26611368", "chat_app", 3306);

if (!$connection) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

$stmt = $connection->prepare("SELECT * FROM country");
$stmt->execute();
$table = $stmt->get_result();

$phpResponseArray = array();

while ($country = $table->fetch_assoc()) {
    $phpArrayItemObject = new stdClass();
    $phpArrayItemObject->value = $country["id"];
    $phpArrayItemObject->label = $country["name"];
    array_push($phpResponseArray, $phpArrayItemObject);
}

echo json_encode($phpResponseArray);
?>
