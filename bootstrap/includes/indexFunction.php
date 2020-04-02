<?php

$array_lib = array(
"../../lib/os_lib_agent.php",
"../../lib/os_lib_syscheck.php",
"../../lib/os_lib_alerts.php");

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

function showAgents($ossec_handle){

        /* Getting all agents */
        if(($agent_list = os_getagents($ossec_handle)) == NULL)
        {
            echo "No agent available.\n";
            return(1);
        }

        /* Getting syscheck information */
        $syscheck_list = os_getsyscheck($ossec_handle);

        /* Agent count for java script */
        $agent_count = 0;

        /* Looping all agents */
        foreach ($agent_list as $agent) 
        {
            $atitle = "";
            $aclass = "";
            $amsg = "";

            /* If agent is connected */
            if($agent{'connected'})
            {
                $atitle = "Agent active";
                $aclass = 'class="bluez"';
            }
            else
            {
                $atitle = "Agent Inactive";
                $aclass = 'class="red"';
                $amsg = " - Inactive";
            }
            echo '
                <span id="toggleagt'.$agent_count.'">
                <a href="#" '.$aclass.' title="'.$atitle.'" onclick="ShowSection(\'agt'.$agent_count.'\');return false;">+'.
                $agent{'name'}." (".$agent{'ip'}.')'.$amsg.'</a><br /> 
                </span>

                <div id="contentagt'.$agent_count.'" style="display: none">

                <a  href="#" '.$aclass.' title="'.$atitle.'" 
                onclick="HideSection(\'agt'.
                $agent_count.'\');return false;">-'.$agent{'name'}.
                " (".$agent{'ip'}.')'.$amsg.'</a>
                <br />
                <div class="smaller">
                &nbsp;&nbsp;<b>Name:</b> '.$agent{'name'}.'<br />
                &nbsp;&nbsp;<b>IP:</b> '.$agent{'ip'}.'<br />
                &nbsp;&nbsp;<b>Last keep alive:</b> '.
                date('Y M d H:i:s', $agent{'change_time'}).'<br />
                &nbsp;&nbsp;<b>OS:</b> '.$agent{'os'}.'<br />
                </div>
                </div>
                ';
            echo "\n";
            $agent_count++;
        }
        echo '</td>';
}

function showLastModified($ossec_handle){
/* Last modified files */
$syscheck_list = os_getsyscheck($ossec_handle);
if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL))
{
    echo '
        No integrity checking information available.<br />
        Nothing reported as changed.
      ';
}
else
{
  if(isset($syscheck_list{'global_list'}) && 
      isset($syscheck_list{'global_list'}{'files'}))
  {
      $sk_count = 0;
      
      foreach($syscheck_list{'global_list'}{'files'} as $syscheck)
      {
          $sk_count++;
          if($sk_count > ($agent_count +4))
          {
              break;
          }
          
          # Initing file name
          $ffile_name = "";
          $ffile_name2 = "";
          
          if(strlen($syscheck[2]) > 40)
          {
              $ffile_name = substr($syscheck[2], 0, 45)."..";
              $ffile_name2 = substr($syscheck[2], 46, 85);
          }
          else
          {
              $ffile_name = $syscheck[2];
          }
          
          echo '
                <span id="toggleagt'.$agent_count.'">
                <a  href="#" '.$aclass.' title="'.$atitle.'" 
                onclick="ShowSection(\'agt'.$agent_count.'\');return false;">+'.
                $agent{'name'}." (".$agent{'ip'}.')'.$amsg.'</a><br /> 
                </span>
        
                <div id="contentagt'.$agent_count.'" style="display: none">
        
                <a  href="#" '.$aclass.' title="'.$atitle.'" 
                onclick="HideSection(\'agt'.
                $agent_count.'\');return false;">-'.$agent{'name'}.
                " (".$agent{'ip'}.')'.$amsg.'</a>
                <br />
                <div class="smaller">
                &nbsp;&nbsp;<b>Name:</b> '.$agent{'name'}.'<br />
                &nbsp;&nbsp;<b>IP:</b> '.$agent{'ip'}.'<br />
                &nbsp;&nbsp;<b>Last keep alive:</b> '.
                date('Y M d H:i:s', $agent{'change_time'}).'<br />
                &nbsp;&nbsp;<b>OS:</b> '.$agent{'os'}.'<br />
                </div>
                </div>
              ';
      }
  }
}
echo "\n";

}

function listAlert($ossec_handle){

    /* Getting last alerts */
    $alert_list = os_getalerts($ossec_handle, 0, 0, 30);
    if($alert_list == NULL)
    {
        echo "<b class='red'>Unable to retrieve alerts. </b><br />\n";
    }
    else
    {
        $alert_count = $alert_list->size() -1;
        $alert_array = $alert_list->alerts();
    
        while($alert_count >= 0)
        {
            echo '<div class="card shadow mb-4">
                    <div class="card-header py-3">
                       ';
            echo $alert_array[$alert_count]->toHtml();
            echo '</div> <div class="card-body">
            </div></div>';
            $alert_count--;
        }
    }

}



