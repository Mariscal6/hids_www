<?php

$int_error="Internal error. Try again later.\n <br />";
$include_error="Unable to include file:";

$array_lib = array("../ossec_conf.php", "../lib/ossec_categories.php",
"../lib/ossec_formats.php", 
"../lib/os_lib_util.php",
"../lib/os_lib_handle.php",
"../lib/os_lib_agent.php",
"../lib/os_lib_mapping.php",
"../lib/os_lib_stats.php",
"../lib/os_lib_syscheck.php",
"../lib/os_lib_firewall.php",
"../lib/os_lib_alerts.php");

foreach ($array_lib as $mylib)
{
  if(!(include($mylib)))
  {
    echo "error";
    echo "$include_error '$mylib'.\n<br />";
    echo "$int_error";
    return(1);
  }
}
 
/* OS PHP init */
if (!function_exists('os_handle_start'))
{
    echo "<b class='red'>You are not allowed direct access.</b><br />\n";
    return(1);
}

/* Starting handle */
$ossec_handle = os_handle_start($ossec_dir);
if($ossec_handle == NULL)
{
    echo "Unable to access ossec directory.\n";
    return(1);
}

