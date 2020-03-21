<?php


if (isset($_SESSION["username"])) {
    if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin") {
        // Load Reports
    } else {
        header("Location: 404.php");
    }
} else {
    header("Location: login.php");
}

$username = $_SESSION["username"];

$sql = "SELECT * FROM users WHERE username != '$username'";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    $users = $result;
}

?>