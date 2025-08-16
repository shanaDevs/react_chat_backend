<?php
header("Access-Control-Allow-Origin: http://localhost:8081");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Accept both POST and GET for userJsonText
$userJSonText = $_POST['userJsonText'];
$userPhpObject = json_decode($userJSonText);

$connection = mysqli_connect("localhost", "root", "@Spk26611368", "chat_app", 3306);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$table = $connection->query("SELECT * FROM user WHERE id != '" . $userPhpObject->id . "'");

$phpResponseArray = array();

while ($user = $table->fetch_assoc()) {
    $phpArrayItemObject = new stdClass();
    $phpArrayItemObject->img = $user["profile_url"];
    $phpArrayItemObject->name = $user["name"];
    $phpArrayItemObject->user_to_id = $user["id"];

    $table2 = $connection->query("SELECT * FROM chat WHERE (user_from_id = '" . $userPhpObject->id . "'
     AND user_to_id = '" . $user['id'] . "') OR (user_from_id = '" . $user['id'] . "' AND user_to_id = '" . $userPhpObject->id . "')
      ORDER BY `date_time` DESC");

    if ($table2->num_rows == 0) {        
        $phpArrayItemObject->msg = "";
        $phpArrayItemObject->time = "";
        $phpArrayItemObject->count = 0;
    } else {
        $unseenChatCount = 0;
        $lastChatRow = $table2->fetch_assoc();
        
        $phpArrayItemObject->msg = $lastChatRow['message'];
        $phpDateTimeObj = strtotime($lastChatRow['date_time']);
        $timeStr = date("h:i A", $phpDateTimeObj);
        $phpArrayItemObject->time = $timeStr;

        // Count unseen messages sent TO the current user (not sent BY the current user)
        $table2->data_seek(0); // Reset the result pointer to beginning
        while ($chatRow = $table2->fetch_assoc()) {
            if ($chatRow['status_id'] == 1 && $chatRow['user_to_id'] == $userPhpObject->id) {
                $unseenChatCount++;
            }
        }
        
        $phpArrayItemObject->count = $unseenChatCount;
    }
    array_push($phpResponseArray, $phpArrayItemObject);
}
$jsonResponseText = json_encode($phpResponseArray);
echo $jsonResponseText;
?>