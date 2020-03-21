<?php

session_start();

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

$email = $_POST['email'];
echo $email;
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
$result = $conn->query($sql);
echo $sql;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Logged in as: " . $row["username"];
        $_SESSION['username'] = $row["username"];
        $_SESSION['login'] = true;
        $_SESSION['role'] = $row["role"];
    }
}

header( "Location: ../index.php" );

?>