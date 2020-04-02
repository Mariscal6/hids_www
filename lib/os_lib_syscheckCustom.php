<?php

//echo 'Syscheck ';

/* @(#) $Id: os_lib_syscheck.php,v 1.9 2008/03/03 19:37:25 dcid Exp $ */

/* Copyright (C) 2006-2008 Daniel B. Cid <dcid@ossec.net>
 * All rights reserved.
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */

/* Modification made by Adrián Ruiz Householder 2019-2020 <adruiz01@ucm.es>
 * All modifications are done for investigation purposes. 
 * 
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */
       
function __os_getdb($file, $_name) {
    $db_list = NULL;
    $mod_list = NULL;
    $db_count = 1;
    $set_size = 1;

    $fp = fopen($file, "r");

    if ($fp === FALSE) {
        return(NULL);
    }

    /* No size for windows registry */
    if(strstr($_name, "registry") !== FALSE) {
        $set_size = 0;
    }

    /* Database pattern */
    $skpattern = "/^\S\S\S(\d+):(\d+):(\d+:\d+):(\S+):(\S+) \!(\d+) (.+)$/";
    
    while(!feof($fp)) {
        $buffer = fgets($fp, 4096);
        $buffer = rtrim($buffer);


        /* Sanitizing input */
        $buffer = preg_replace("/</", "&lt;", $buffer);
        $buffer = preg_replace("/>/", "&gt;", $buffer);


        if(preg_match($skpattern, $buffer, $regs)) {
            $sk_file_size = $regs[1];
            $sk_file_perm = $regs[2];
            $sk_file_owner = $regs[3];
            $sk_file_md5 = $regs[4];
            $sk_file_sha1 = $regs[5];
            $time_stamp = $regs[6];
            $sk_file_name = $regs[7];
            
            if(strlen($sk_file_name) > 45) {
                $sk_file_name = chunk_split($sk_file_name, 45, " ");
            }
                 
            if(isset($db_list{$sk_file_name})) {
                $mod_list{$time_stamp} = array($db_count, $regs[7]);

                $db_list{$sk_file_name}{'ct'} = $db_count;
                $db_list{$sk_file_name}{'time'} = $time_stamp;
                
                $db_list{$sk_file_name}{'size'} = 
                        $db_list{$sk_file_name}{'size'} . 
                        "<br />&nbsp;&nbsp; -> &nbsp;&nbsp;<br /> ".
                        $sk_file_size;
                $db_list{$sk_file_name}{'sum'} = 
                        $db_list{$sk_file_name}{'sum'} . 
                        "<br />&nbsp;&nbsp; -> &nbsp;&nbsp;<br /> ".
                        "md5 $sk_file_md5 <br />" . "sha1 $sk_file_sha1";
            }
            else
            {
                $db_list{$sk_file_name}{'time'} = $time_stamp;
                $db_list{$sk_file_name}{'size'} = $sk_file_size;
                $db_list{$sk_file_name}{'sum'} = "md5 $sk_file_md5 <br />" .
                                                 "sha1 $sk_file_sha1";
            }
            
            $db_count++;
        }
    }
    fclose($fp);
    
    /* Printing latest files */
    echo '
         <br /><br />
         <h2>Latest modified files:</h2><br />
         ';
    if (isset($mod_list)) {
        arsort($mod_list);
        foreach ($mod_list as $mod_date => $val) {
            echo "<b>".date('Y M d', $mod_date)."</b>&nbsp; &nbsp;";
            echo '<a class="bluez" href="#id_'.$val[0].'">'.$val[1].'</a>
                  <br />
                 ';   
        }
    }
    
    echo "\n<br /><h2>Integrity Checking database: $_name</h2>\n";
    

    /* Printing db */
    echo '<br /><br /><table width="100%">';
    echo '
         <tr>
           <th>File name</th>
           <th>Checksum</th>
         ';
    if($set_size == 1) {
        echo '<th>Size</th>';
    }
    echo '
         </tr>
         ';
    
    /* Dumping for each entry */
    $db_count = 0;
    foreach($db_list as $list_name => $list_val) {
        $sk_class = ">";
        $sk_point = "";

        if(($db_count % 2) == 0) {
            $sk_class = 'class="odd">';
        }

        if(isset($list_val{'ct'})) {
            $sk_point = '<a id="id_'.$list_val{'ct'}.'" />';
        }
        
        echo '<tr '.$sk_class.'<td width="45%" valign="top">'.
            $sk_point.
            $list_name.'</td><td width="53%" valign="top">'.
            $list_val{'sum'}.'</td>';
        
        if($set_size == 1) {
            echo '    
            <td width="2%" valign="top">'.$list_val{'size'}.'</td>';
        }
        echo '</tr>
             ';
            
        $db_count++;            
    }
    
    echo '</table>';
    return($db_list);
}

//echo '<br> Syscheck function __os_getdb($file, $_name)';

function __os_getchanges($file, &$g_last_changes, $_name, $filters) {

    if ($filters == "") {
        // Nothing to apply
    } else {
        /* Possible format:

            array(
                days => 2,
                filesPerDay => 4,
                sortingOrder => asc
            )

        */
    }

    $change_list = array(); // TODO: Is this even used?
    $fp = fopen($file, "r");
    $list_size = 0;
    
    if($fp === FALSE) {
        return(NULL);
    }
    fseek($fp, -12000, SEEK_END);

    /* Cleaning up first entry */
    $time_stamp = 0;
    $buffer = fgets($fp, 4096);
    while(!feof($fp)) {
        $buffer = fgets($fp, 4096);
        $buffer = rtrim($buffer);

        if( preg_match( '/^(\+|#)/', $buffer ) ) {
            continue;
        }

        $new_buffer = strstr($buffer, ':');
        $new_buffer = strstr($new_buffer, '!');
        
        $skpattern = "/^\!(\d+) (.+)$/";
        if(preg_match($skpattern, $new_buffer, $regs)) {
            /*
            
            Regs -> Time + File
            Regs[0] => All
            Regs[1] => Time
            Regs[2] => File
            
            */
            $list_size++;

            $time_stamp = $regs[1]; // Seconds without format
            $sk_file_name = $regs[2]; // File Name

            /* If the list is small */
            if($list_size < 20) {
                $change_list{$sk_file_name} = $time_stamp;        
            }
            else
            {
                arsort($change_list);
                array_pop($change_list);
                $change_list{$sk_file_name} = $time_stamp;
            }

            /* Add arrays by date */

            /* Global list */

            $max = 100;

            if ($filters != "") {
                $max = $filters{'totalMax'};
            }

            if(sizeof($g_last_changes{'files'}) < $max) { // 100 = Total number of files shown
                $g_last_changes{'files'}[] = array($time_stamp, $_name, $sk_file_name);

                /*

                (
                    [0] => 1585150286
                    [1] => ossec-server
                    [2] => /usr/bin/gresource
                )

                */  
                //print_r(date('Y M d', $time_stamp));
                

                if(!isset($g_last_changes{'lowest'})) {
                    $g_last_changes{'lowest'} = $time_stamp;
                }
                if($time_stamp < $g_last_changes{'lowest'}) {
                    $g_last_changes{'lowest'} = $time_stamp;
                }

                if ($filters != "") {
                    if ($filters{'sort'} == "desc") {
                        rsort($g_last_changes{'files'});
                    } else if ($filters{'sort'} == "asc") {
                        sort($g_last_changes{'files'});
                    }
                } else {
                    rsort($g_last_changes{'files'});
                }
                
            }
            else if($time_stamp > $g_last_changes{'lowest'}) {
                if ($filters != "") {
                    if ($filters{'sort'} == "desc") {
                        rsort($g_last_changes{'files'});
                    } else if ($filters{'sort'} == "asc") {
                        sort($g_last_changes{'files'});
                    }
                } else {
                    rsort($g_last_changes{'files'});
                }
                array_pop($g_last_changes{'files'});
                $g_last_changes{'files'}[] = array($time_stamp, $_name, $sk_file_name);
            }
        }
    }
    
    fclose($fp);

}

/* Dump syscheck db */
function os_syscheck_dumpdb($ossec_handle, $agent_name) {
    $dh = NULL;
    $file = NULL;
    $syscheck_list = NULL;
    $syscheck_count = 0;

    $sk_dir = $ossec_handle{'dir'}."/queue/syscheck";

    /* Getting all agent files */
    @$dh = opendir($sk_dir);
    if($dh !== FALSE) {
        while(($file = readdir($dh)) !== false) {
            $_name = NULL;
            
            if($file[0] == '.') {
                continue;
            }

            $filepattern = "/^\(([\.a-zA-Z0-9_-]+)\) ".
                           "([0-9\.:a-fA-F_]+|any)->([a-zA-Z_-]+)$/";
            if(preg_match($filepattern, $file, $regs)) {
                if($regs[2] == "syscheck-registry") {
                    $_name = $regs[1]." Windows registry";
                }
                else
                {
                    $_name = $regs[1];
                }
            }
            else
            {
                if($file == "syscheck") {
                    $_name = "ossec-server";
                }
                else
                {
                    continue;
                }
            }

            /* Looking for agent name */
            if($_name != $agent_name) {
                continue;
            }
            
            $syscheck_list = __os_getdb($sk_dir."/".$file, $_name);
            closedir($dh);
            return($syscheck_list);        
        }

        closedir($dh);
    }
}

function os_getsyscheck($ossec_handle, $filters) {

    // Adding the parameter $filters allows us to recover data without having to bring back the whole history of files.

    if ($filters == "") {
        // Nothing to apply
    } else {
        /* Possible format:

            array(
                days => 2,
                filesPerDay => 4,
                sortingOrder => asc
            )

        */
    }

    $dh = NULL;
    $file = NULL;
    $syscheck_list = NULL;
    $syscheck_count = 0;

    $sk_dir = $ossec_handle{'dir'}."/queue/syscheck";
    
    /* Getting all agent files */
    $dh = opendir($sk_dir);
    if($dh !== FALSE) {
        $i = 0;
        while(($file = readdir($dh)) !== false) {
            $i += 1;
            $_name = NULL;
            
            if($file[0] == '.') {
                continue;
            }

            $filepattern = "/^\(([\.a-zA-Z0-9_-]+)\) "."([0-9\.:a-fA-F_]+|any)->([a-zA-Z_-]+)$/";

            if(preg_match($filepattern, $file, $regs)) {
                if($regs[2] == "syscheck-registry") {
                    $_name = $regs[1]." Windows registry";
                }
                else {
                    $_name = $regs[1];
                }
            }
            else {
                if($file == "syscheck") {
                    $_name = "ossec-server";
                }
                else
                {
                    continue;
                }
            }
            $syscheck_list{$_name}{'list'} = __os_getchanges_adrian($sk_dir."/".$file, $g_last_changes, $_name, $filters);
            $syscheck_count++;
        }
        closedir($dh);
        $syscheck_list{'global_list'} = $g_last_changes;
        // print_r($syscheck_list{'global_list'}{'days'}[0][0]);
        return($syscheck_list);
    }

    return(NULL);
}

function __os_getchanges_adrian($file, &$g_last_changes, $_name, $filters) {

    $g_last_changes = [];

    $change_list = array(); // TODO: Is this even used?
    $fp = fopen($file, "r");
    $list_size = 0;
    
    if($fp === FALSE) {
        return(NULL);
    }
    fseek($fp, -12000, SEEK_END);

    /* Cleaning up first entry */
    $time_stamp = date('Y M d');
    $current_time = date('Y M d');
    $buffer = fgets($fp, 4096);

    $new_time_formatted = date('Y M d');
    $current_time_formatted = date('Y M d');

    $previous_file_time = "";
    $dayCounter = 0;

    // /* Debug

    $filePerDay = 0;
    $i = 0;

    // */

    while(!feof($fp)) {
        $buffer = fgets($fp, 4096);
        $buffer = rtrim($buffer);

        if( preg_match( '/^(\+|#)/', $buffer ) ) {
            continue;
        }

        $new_buffer = strstr($buffer, ':');
        $new_buffer = strstr($new_buffer, '!');
        
        $skpattern = "/^\!(\d+) (.+)$/";
        if(preg_match($skpattern, $new_buffer, $regs)) {
            $current_time_formatted = date('Y M d', $regs[1]); // Current File

            if ($previous_file_time == "") {
                $g_last_changes{'days'}[$dayCounter] = array($regs[1]); // Add new timestamp
                $previous_file_time = $current_time_formatted;
            } else if ($previous_file_time < $current_time_formatted) {
                $dayCounter += 1;
                if ($dayCounter == $filters{'maxDays'}) {
                    break;
                }
                $g_last_changes{'days'}[$dayCounter] = array($regs[1]); // Add new timestamp
                $previous_file_time = $current_time_formatted;
                $filePerDay = 0;
            }

            if ($filePerDay < $filters{'maxFiles'}) {
                $time_stamp = $regs[1]; // Seconds without format
                $sk_file_name = $regs[2]; // File Name

                // Fill in the day
                $g_last_changes{'days'}[$dayCounter]{'file'}[] = array($time_stamp, $_name, $sk_file_name);
                $filePerDay += 1;
            }

            if ($filters['fileSort'] == 'desc') {
                rsort($g_last_changes{'days'}[$dayCounter]{'file'});
            }
        }

        
    }

    if ($filters['daySort'] == 'desc') {
        rsort($g_last_changes{'days'});
    }
    
    fclose($fp);

}

?>
