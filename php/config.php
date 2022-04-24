<?php 
$servername = "localhost";
$username = "root";
$password = "root";
$db = "chat_app";

// $conn = mysqli_connect("localhost", "admin", "9812", "chat_app");
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>