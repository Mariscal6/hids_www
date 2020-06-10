<?php

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
} else {
    $USER_agent = 'ossec-server';
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

/*

Send filters:

array(
    days => 2,
    filesPerDay => 4,
    sortingOrder => asc
)

*/

// Filters fetch

$maxFiles = 100;
$maxDays = 100;
$dayOrder = 'desc';
$fileOrder = 'desc';
$fileName = "";
$md5 = "";
$sha1 = "";

if (isset($_POST['fileName'])) {
    $fileName = $_POST['fileName'];
}

if (isset($_POST['md5'])) {
    $md5 = $_POST['md5'];
}

if (isset($_POST['sha1'])) {
    $sha1 = $_POST['sha1'];
}

if (isset($_POST['maxFiles'])) {
    $maxFiles = $_POST['maxFiles'];
}

if (isset($_POST['maxDays'])) {
    $maxDays = $_POST['maxDays'];
}

if (isset($_POST['dayOrder'])) {
    $dayOrder = $_POST['dayOrder'];
}

if (isset($_POST['fileOrder'])) {
    $fileOrder = $_POST['fileOrder'];
}

// Load Database for Integrity Checking

/* Dumping database */

$filters = [
    "maxDays" => $maxDays,
    "maxFiles" => $maxFiles,
    "daySort" => $dayOrder,
    "fileSort" => $fileOrder,
    "fileName" => $fileName,
    "md5" => $md5,
    "sha1" => $sha1
];

$db_changes = os_syscheck_dumpdb_custom($ossec_handle, $USER_agent, $filters);
// $toPrint = array_search('/etc/libreoffice/psprint.conf', array_column($agentInfo, 'name'));
$i = 0;
foreach ($db_changes as $name) {
    if ($name[$i]['changed'] == 0) {
        unset($name[$i]);
    } else {
        // print_r($name);
    }
    $i++;
}

if ($filters['md5'] == 'ERROR' || $filters['sha1'] == 'ERROR') {
    $syscheck_list = NULL;
} else {
    $syscheck_list = os_getsyscheck_custom($ossec_handle, $filters);
}

?>