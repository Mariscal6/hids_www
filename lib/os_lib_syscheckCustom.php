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
       
function os_getsyscheck_custom($ossec_handle, $filters) {
    // Adding the parameter $filters allows us to recover data without having to bring back the whole history of files.

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
            $syscheck_list{$_name}{'list'} = __os_getchanges_custom($sk_dir."/".$file, $g_last_changes, $_name, $filters);
            $syscheck_count++;
        }
        closedir($dh);
        $syscheck_list{'global_list'} = $g_last_changes;
        // print_r($syscheck_list{'global_list'}{'days'}[0][0]);
        return($syscheck_list);
    }

    return(NULL);
}

function __os_getchanges_custom($file, &$g_last_changes, $_name, $filters) {

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

    $files = 0;

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
                $g_last_changes{'days'}[$dayCounter] = array($regs[1]); // Add new timestamp
                $previous_file_time = $current_time_formatted;
                $filePerDay = 0;
            }

            
            $time_stamp = $regs[1]; // Seconds without format
            $sk_file_name = $regs[2]; // File Name

            // Fill in the day
            $g_last_changes{'days'}[$dayCounter]{'file'}[] = array($time_stamp, $_name, $sk_file_name);
            $filePerDay += 1;
            
        }

        $files++;
    }

    fclose($fp);
    applyFilters($g_last_changes, $filters, $dayCounter);

}

function applyFilters(&$array, $filters, $dayCounter) {
    /* $filters = [
        "maxDays" => $maxDays,
        "maxFiles" => $maxFiles,
        "daySort" => $dayOrder,
        "fileSort" => $fileOrder,
    ]; */

    if ($filters['daySort'] == 'desc') {
        rsort($array{'days'});
    }

    if ($filters['fileSort'] == 'desc') {
        for ($i = 0; $i < sizeof($array{'days'}); $i+=1) {
            rsort($array{'days'}[$i]{'file'});
        }
    }

    if ($filters['maxDays'] < $dayCounter + 1) {
        $array{'days'} = array_slice($array{'days'}, 0, $filters['maxDays']);
    }

    for ($i = 0; $i < sizeof($array{'days'}); $i+=1) {
        $array{'days'}[$i]{'file'} = array_slice($array{'days'}[$i]{'file'}, 0, $filters['maxFiles']);
    }

}

?>
