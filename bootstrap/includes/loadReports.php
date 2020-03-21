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

?>