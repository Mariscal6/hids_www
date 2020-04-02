<?php

if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL)) {
    echo '
        No integrity checking information available.<br />
        Nothing reported as changed.
        ';
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
                            echo '<b>Modification time: '.date('Y M d H:i:s', $file_time).'</b>';
                    echo '</div>
                        </div>
                    </div>
                    
                    ';
                    $idIt += 1;
                    echo '<br/>';
                }
            }
        }
    }
}
?>