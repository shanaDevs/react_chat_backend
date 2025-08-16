<?php 
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$currentUserId = $_POST['currentUserId'];
$otherUserId = $_POST['otherUserId'];

$user1 = $currentUserId;
$user2 = $otherUserId;


$connection = mysqli_connect("localhost", "root", "@Spk26611368", "chat_app","3306");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM chat WHERE (user_from_id = '$user1' AND user_to_id = '$user2') OR (user_from_id = '$user2' AND user_to_id = '$user1') ORDER BY date_time ASC";
$table = $connection->query($query);

$chatArray = array();

for($x=0; $x < $table->num_rows; $x++) {
    $row = $table->fetch_assoc();
    $chatObject = new stdClass();
    $chatObject->id = $row['id'];
    $chatObject->msg = $row['message'];
    $chatObject->user_from_id = $row['user_from_id'];
    $chatObject->user_to_id = $row['user_to_id'];
    $phpDateTimeObj = strtotime($row['date_time']);
    $timeStr= date("h i A", $phpDateTimeObj);
    $chatObject->time = $timeStr;
    if($row['user_from_id'] == $user1) {
        $chatObject->side = 'right';
    } else {
        $chatObject->side = 'left';
    }
    $chatObject->status = $row["status_id"];
    $chatArray[$x] = $chatObject;

}

$responseJson= json_encode($chatArray);
echo $responseJson;

?>