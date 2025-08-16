<?php

$connection = new mysqli("localhost", "root", "@Spk26611368", "chat_app", "3306");

$mobile = $_POST['mobile'];
$userName = $_POST['user_name'];
$profile_pic_Url = $_FILES['profile_img']["tmp_name"];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$country = $_POST['country'];
$profile_pic_uri = "C:/xampp/htdocs/react_chat/uploads/".$mobile.".jpg";
if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

$connection->query("INSERT INTO user (mobile, name,password, profile_url, country_id) VALUES 
('$mobile', '$userName', '$password', '$profile_pic_uri', '$country')");
echo ("success");
move_uploaded_file($profile_pic_Url, $profile_pic_uri);