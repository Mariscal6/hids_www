<?php

session_start();
$ossec_root="/var/www/html/ossec/";
/*
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

/*$sql = "SELECT id, firstname, lastname FROM MyGuests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();*/

if (isset($_SESSION['username'])) {

} else {
    // header('Location: login.php');
}

$int_error="Internal error. Try again later.\n <br />";
$include_error="Unable to include file:";

$array_lib = array("../ossec_conf.php", "../lib/ossec_categories.php",
"../lib/ossec_formats.php",  
"../lib/os_lib_handle.php",
"../lib/os_lib_agent.php",
"../lib/os_lib_mapping.php",
"../lib/os_lib_stats.php",
"../lib/os_lib_syscheck.php",
"../lib/os_lib_syscheckCustom.php",
"../lib/os_lib_firewall.php",
"../lib/os_lib_alerts.php");

foreach ($array_lib as $mylib)
{
  if(!(include($mylib)))
  {
    echo "$include_error '$mylib'.\n<br />";
    echo "$int_error";
    
  }
}

?>