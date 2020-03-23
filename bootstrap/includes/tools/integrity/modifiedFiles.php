<?php

if (isset($_GET['refresh'])) {
    // echo 'Hola';
    /* Initializing variables */
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

$filterNum = 1;
    return "Aviso";
}

if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL)) {
    echo '
        No integrity checking information available.<br />
        Nothing reported as changed.
        ';
    } else {
        if(isset($syscheck_list{'global_list'}) && isset($syscheck_list{'global_list'}{'files'})) {
        $last_mod_date = "";
        $sk_count = 0;
        $idIt = 0;
        $i = 0;
        $print = true;
        foreach($syscheck_list{'global_list'}{'files'} as $syscheck) {
            $sk_count++;
            # Initing file name
            $ffile_name = "";
            $ffile_name2 = "";

            if(strlen($syscheck[2]) > 90) {
                $ffile_name = substr($syscheck[2], 0, 95)."..";
                $ffile_name2 = substr($syscheck[2], 96, 160);
            } else {
                $ffile_name = $syscheck[2];
            }
            /* Setting the date */
            
            if($last_mod_date != date('Y M d', $syscheck[0])) {
                $last_mod_date = date('Y M d', $syscheck[0]);
                echo "\n<b>Last Modification Date: $last_mod_date</b>\n";
                echo '<br><br>';
                $print = true;
                $i = 0;
            }

            if ($print) {
                echo '
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample'.$idIt.'" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample'.$idIt.'">
                    <h6 class="m-0 font-weight-bold text-primary">File: '.$ffile_name.'</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse" id="collapseCardExample'.$idIt.'" style="">
                    <div class="card-body">
                        <b>File name: '.$ffile_name.'</b><br>';
                        if($ffile_name2 != "") {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ffile_name2.'<br />';
                        }
                        echo '<b>Agent: '.$syscheck[1].'</b><br>';
                        echo '<b>Modification time: '.date('Y M d H:i:s', $syscheck[0]).'</b>';
                echo '</div>
                    </div>
                </div>
                
                ';
            }
            $idIt += 1;
            $i += 1;
            if ($filterNum > 0) {
                if ($i == $filterNum) {
                    $print = false;
                }
            }
        }
    }
}
?>