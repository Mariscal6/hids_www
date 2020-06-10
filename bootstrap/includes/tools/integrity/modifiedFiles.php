<?php

if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL)) {
    if ($filters['md5'] == 'ERROR' || $filters['sha1'] == 'ERROR') {
        echo "
        The hash you've entered does not match any file's hash.<br />
        ";
    } else if ($filters['fileName'] == 'ERROR') {
        echo '
        No file containing "'.$fileName.'" within its name has been found.<br />
        ';
    } else {
        echo '
        No integrity checking information available.<br />
        Nothing reported as changed.
        ';
    }
} else {
    if(isset($syscheck_list{'global_list'}) && isset($syscheck_list{'global_list'}{'days'})) {
        $last_mod_date = "";
        $sk_count = 0;
        $idIt = 0;
        $print = true;

        foreach($syscheck_list{'global_list'}{'days'} as $day) {
            $last_mod_date = date('Y M d', $day[0]);
            echo "\n<b>Last Modification Date: $last_mod_date</b>\n";
            echo '<br><br>';
            foreach($day['file'] as $file) {
                if (sizeof($day['file']) != 0) {
                    $file_time = $file[0];
                    $file_agent = $file[1];
                    $file_name = $file[2];
                    echo '
                    <div class="card shadow mb-4">
                        <a href="#collapseCardExample'.$idIt.'" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample'.$idIt.'">
                        <h6 class="m-0 font-weight-bold text-primary">File: '.$file_name.'</h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse" id="collapseCardExample'.$idIt.'" style="">
                          <div class="card-body">
                            <b>File name: '.$file_name.'</b><br>';
                            echo '<b>Agent: '.$file_agent.'</b><br>';
                            echo '<b>Modification time: '.date('Y M d H:i:s', $file_time).'</b><br><br>';
                            echo '<button type="button" fileName="'.$file_name.'" onclick="loadSpecificChecksum(this);" class="btn btn-primary custom-btn" data-toggle="modal" data-target="#myModal">
                            Verify Checksum
                          </button>';
                    echo '</div>
                        </div>
                    </div>
                    
                    ';
                    $idIt += 1;
                    echo '<br/>';
                }
            }
        }
    } else if ($filters['fileName'] != "") {
        // print_r($syscheck_list{'global_list'});
        if (sizeof($syscheck_list) != 0) {
            $i = 0;
            foreach($syscheck_list{'global_list'} as $file) {
                $file_time = $file[0];
                $file_agent = $file[1];
                $file_name = $file[2];
                echo "\n<b>Last Modification Date: ".date('Y M d', $file_time)."</b>\n";
                echo '<br><br>';
                echo '
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample'.$i.'" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardExample'.$i.'">
                    <h6 class="m-0 font-weight-bold text-primary">File: '.$file_name.'</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse" id="collapseCardExample'.$i.'" style="">
                      <div class="card-body">
                        <b>File name: '.$file_name.'</b><br>';
                        echo '<b>Agent: '.$file_agent.'</b><br>';
                        echo '<b>Modification time: '.date('Y M d H:i:s', $file_time).'</b><br><br>';
                        echo '<button type="button" fileName="'.$file_name.'" onclick="loadSpecificChecksum(this);" class="btn btn-primary custom-btn" data-toggle="modal" data-target="#myModal">
                        Verify Checksum
                        </button>';
                echo '</div>
                    </div>
                </div>
                
                ';
                echo '<br/>';
                $i += 1;
            }
        }        
    } else if ($filters['fileName'] != "") {
        
    }
}
?>