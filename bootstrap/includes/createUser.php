<?php

session_start();

if ($_SESSION['role'] != "admin") {
    header('Location: ../404.php');
}
 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ossec";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordRepeat = $_POST['passwordRepeat'];
$role = $_POST['role'];

if ($password != $passwordRepeat) {
    header('Location: ../manageUsers.php');
}

$sql = "INSERT INTO users (username, password, email, role) VALUES ('".$username."', '".$password."', '".$email."','".$role."')";

echo $sql;
$result = $conn->query($sql);

header('Location: ../manageUsers.php');

?>