<?php

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
                <a href="#" '.$aclass.' title="'.$atitle.'" 
                    onclick="ShowSection(\'agt'.$agent_count.'\');return false;"> +'.
                    $agent{'name'}." (".$agent{'ip'}.')'.$amsg.'
                </a><br> 
            </span>

            <div id="contentagt'.$agent_count.'" style="display: none">
                <a href="#" '.$aclass.' title="'.$atitle.'" 
                    onclick="HideSection(\'agt'. $agent_count.'\');return false;" >- '.$agent{'name'}." (".$agent{'ip'}.')'.$amsg.'
                </a>
                <br>
                <div class="smaller">
                    <b>Name:</b> '.$agent{'name'}.'<br>
                    <b>IP:</b> '.$agent{'ip'}.'<br>
                    <b>Last keep alive:</b> '.
                    date('Y M d H:i:s', $agent{'change_time'}).'<br>
                    <b>OS:</b> '.$agent{'os'}.'<br>
                </div>
            </div>
            ';

        $agent_count++;
    }

    echo '</td>';
}

function showLastModified($ossec_handle){
    $syscheck_list = os_getsyscheck($ossec_handle);
    if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL))
    {
        echo '<ul class="ulsmall bluez">
            No integrity checking information available.<br />
            Nothing reported as changed.
            </ul>
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
                   <span id="togglesk'.$sk_count.'">
                   <a  href="#" class="bluez" title="Expand '.$syscheck[2].'" 
                   onclick="ShowSection(\'sk'.$sk_count.'\');return false;">+'.
                   $ffile_name.'</a><br /> 
                   </span>
    
                   <div id="contentsk'.$sk_count.'" style="display: none">
    
                   <a  href="#" title="Hide '.$syscheck[2].'" 
                   onclick="HideSection(\'sk'.
                   $sk_count.'\');return false;">-'.$ffile_name.'</a>
                   <br />
                   <div class="smaller">
                   &nbsp;&nbsp;<b>File:</b> '.$ffile_name.'<br />';
                   if($ffile_name2 != "")
                   {
                       echo "&nbsp;&nbsp;&nbsp;&nbsp;".$ffile_name2.'<br />';
                   }
                   echo '
                   &nbsp;&nbsp;<b>Agent:</b> '.$syscheck[1].'<br />
                   &nbsp;&nbsp;<b>Modification time:</b> '.
                   date('Y M d H:i:s', $syscheck[0]).'<br />
                   </div>
    
                   </div>
                   ';
           }
       }
    }
    
    
    echo '</td></tr></table>
    ';
    echo "<br /> <br />\n";
    
    

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
        $alert_count = $alert_list->size()-1;
        $alert_array = $alert_list->alerts();
    
        while($alert_count >= 0)
        {
            echo '<div class="card shadow mb-4">
                    <div class="card-header py-3">';
                    echo $alert_array[$alert_count]->titleToHtml();
                     
            echo '</div>
                    <div class="card-body">';
                    echo $alert_array[$alert_count]->toHtml();
             echo'</div></div>';
            $alert_count--;
        }
    }

}



