<?php
$array_lib = array(
"../ossec_conf.php",
"../lib/ossec_categories.php",
"../lib/ossec_formats.php",  
"../lib/os_lib_handle.php",
"../lib/os_lib_agent.php",
"../lib/os_lib_mapping.php",
"../lib/os_lib_stats.php",
"../lib/os_lib_syscheck.php",
"../lib/os_lib_firewall.php",
"../lib/os_lib_alerts.php");

$int_error = "Internal error. Try again later.\n <br />";
$include_error = "Unable to include file:";

foreach ($array_lib as $mylib) {
    if (!(include($mylib))) {
        echo "$include_error '$mylib'.\n<br />";
        echo "$int_error";
        return(1);
    }
}

/* Initializing variables */
$u_agent = "ossec-server";
$u_file = "";
$USER_agent = NULL;
$USER_file = NULL;

/* Getting user patterns */
$strpattern = "/^[0-9a-zA-Z.:_^ -]{1,128}$/";
if(isset($_POST['agentpattern']))
{
    if(preg_match($strpattern, $_POST['agentpattern']) == true)
    {
        $USER_agent = $_POST['agentpattern'];
        $u_agent = $USER_agent;
    }
}
if(isset($_POST['filepattern']))
{
    if(preg_match($strpattern, $_POST['filepattern']) == true)
    {
        $USER_file = $_POST['filepattern'];
        $u_file = $USER_file;
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


/* Getting syscheck information */
$syscheck_list = os_getsyscheck($ossec_handle);

?>