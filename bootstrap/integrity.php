<?php require('includes/config.php'); ?>
<?php require('includes/integrityInit.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Integrity Check</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom Colors -->
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
            <h1 class="h3 mb-0 text-gray-800">Integrity Check</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <form name="dosearch" method="post" action="index.php?f=i">
                      Agent name: 
                      <select name="agentpattern" class="formText">
                      <?php 
                      foreach($syscheck_list as $agent => $agent_name) {
                        $sl = "";
                        if ($agent == "global_list") {   
                          continue;
                        } else if($u_agent == $agent) {
                          $sl = ' selected="selected"';
                        }
                        echo '<option value="'.$agent.'" '.$sl.'> &nbsp; '.$agent.'</option>';
                      }
                      echo '</select>';
                      echo '<input type="submit" name="ss" value="Dump database" class="button"/>';
                      if($USER_agent != NULL) {
                        echo ' &nbsp; &nbsp;<a class="bluez" href="index.php?f=i"> &lt;&lt;back</a>';
                      }
                      
                      /* Dumping database */
                      if( array_key_exists( 'ss', $_POST ) ) {
                        if(($_POST['ss'] == "Dump database") && ($USER_agent != NULL))
                        {
                            os_syscheck_dumpdb($ossec_handle, $USER_agent);
                            return(1);
                        }
                      }
                      
                      ?>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->

          <!-- Card (Row) -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Latest modified files (for all agents):</h6>
                </div>
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <?php
                        /* Last modified files */
                        if(($syscheck_list == NULL) || ($syscheck_list{'global_list'} == NULL)) {
                          echo '<ul class="ulsmall bluez">
                              No integrity checking information available.<br />
                              Nothing reported as changed.
                              </ul>
                            ';
                        } else {
                          echo '<table><tr><td valign="top">';
                          if(isset($syscheck_list{'global_list'}) && isset($syscheck_list{'global_list'}{'files'})) {
                            $last_mod_date = "";
                            $sk_count = 0;
       
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
                                echo "\n<br /><b>$last_mod_date</b><br />\n";
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
                                if($ffile_name2 != "") {
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
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->


          <!-- Content Row -->
          <div class="row">

          </div>

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
