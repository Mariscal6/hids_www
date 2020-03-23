<?php 
/* @(#) $Id: main.php,v 1.12 2008/03/03 19:37:26 dcid Exp $ */

/* Copyright (C) 2006-2013 Trend Micro
 * All rights reserved.
 *
 * This program is a free software; you can redistribute it
 * and/or modify it under the terms of the GNU General Public
 * License (version 3) as published by the FSF - Free Software
 * Foundation
 */

require('includes/config.php'); 

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

$cont = 1;
foreach ($array_lib as $mylib)
{
  if(!(include($mylib)))
  {
    echo "error";
    echo "$include_error '$mylib'.\n<br />";
    echo "$int_error";
    return(1);
  }
  echo $cont;
  $cont++;
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

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Home</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script type="text/javascript" src="js/calendar.js"></script>
  <script type="text/javascript" src="js/calendar-en.js"></script>
  <script type="text/javascript" src="js/calendar-setup.js"></script>
  <script type="text/javascript" src="js/prototype.js"></script>
  <script type="text/javascript" src="js/hide.js"></script>

  <?php require('imports/allCSS.php'); ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require('includes/sidePanel.php'); ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require('includes/topBar.php');?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Main</h1>
          </div>
          <?php
           /* Printing current date */
           echo '<div class="smaller2">'.date('F dS, Y h:i:s A').'</div><br />';
          ?>
         
          <!-- Content Row -->
          <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Available Agents</h6>
                </div>
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <a href="index">
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                        <?php
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
                        
                        ?>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Latest Modified Files</h6>
                </div>
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <?php
                    
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

                    ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Card (Row) -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Latest Events</h6>
                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->

          <!-- List last alerts -->
          <?php 
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
          ?>
          <!-- End list last alerts -->
         

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require('includes/footer.php'); ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php require('includes/logoutModal.php'); ?>
  <!-- End of Logout Modal-->

  <?php require('imports/all.php'); ?>

</body>

</html>
