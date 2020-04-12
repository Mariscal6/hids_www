<?php 
require_once('includes/config.php');

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
    exit(1);
}


require_once('includes/search_variables.php');

/* Getting all agents. */
$agent_list = os_getagents($ossec_handle);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Search</title>

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
            <h1 class="h3 mb-0 text-gray-800">Search</h1>
          </div>
          <div class="smaller2">
            <?php 
              echo date('F dS Y h:i:s A');
              if($USER_monitoring == 1)
              {
                  echo ' -- Refreshing every '.$ossec_refresh_time.' secs</div><br />';
              }
            ?>
          </div>
          </br>
          
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12 p-3">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search options</h6>
                </div>
                <div class="col-sm-12 p-4">
                  <?php require('includes/searchForm.php');?>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search Results</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400" aria-hidden="true"></i>
                    </a>
                  </div>
                </div>
                <div class="card-body">
                <ul class="list-group list-group-flush">
                <?php
                if((!isset($USER_init) || !isset($USER_final) || !isset($USER_level))): ?>
                  <p class="text-danger">No search performed.</p>
                <?php endif;
                
                if($_POST['search'] != "Search")
                {
                  $output_list = os_getstoredalerts($ossec_handle, $USER_searchid);
                  $used_stored = 1;
                }
                
                /* Searching for new ones */
                else
                {
                    /* Getting alerts */
                    
                    $output_list = os_searchalerts($ossec_handle, $USER_searchid,
                                                   $USER_init, $USER_final,
                                                   $ossec_max_alerts_per_page,
                                                   $USER_level,$USER_rule, $LOCATION_pattern,
                                                   $USER_pattern, $USER_group,
                                                   $USER_srcip, $USER_user,
                                                   $USER_log);
                }
                if($output_list == NULL || $output_list[1] == NULL)
                {
                    if($used_stored == 1)
                    {
                        echo "<b class='red'>Nothing returned (search expired). </b><br />\n";
                    }
                    else
                    {
                        echo "<b class='red'>Nothing returned. </b><br />\n";
                    }
                    return(1);
                }
                
                
                /* Checking for no return */
                if(!isset($output_list[0]{'count'}))
                {
                    echo "<b class='red'>Nothing returned. </b><br />\n";
                    return(1);
                }
                
                
                /* Checking maximum page size */
                if($USER_page >= $output_list[0]{'pg'})
                {
                    $USER_page = $output_list[0]{'pg'};
                }
                
                /* Page 1 will become the latest and the latest, page 1 */
                $real_page = ($output_list[0]{'pg'} + 1) - $USER_page;
                
                
                echo "<b>Total alerts found: </b>".$output_list[0]{'count'};
                
                if($output_list[0]{'pg'} > 1)
                {
                    echo "<b>Output divided in </b>".
                         $output_list[0]{'pg'}." pages.<br />";
                
                    echo '<br /><form name="dopage" method="post" action="index.php?f=s">';
                }
                
                
                if($output_list[0]{'pg'} > 1)
                {
                    echo '
                        <input type="submit" name="search" value="<< First" class="button"
                               class="formText" />
                
                        <input type="submit" name="search" value="< Prev" class="button"
                               class="formText" />
                         ';
                
                    echo 'Page <b>'.$USER_page.'</b> ('.$output_list[0]{$real_page}.' alerts)';
                }
                
                /* Currently page */
                echo '
                    <input type="hidden" name="initdate"
                           value="'.date('Y-m-d H:i', $u_init_time).'" />
                    <input type="hidden" name="finaldate"
                           value="'.date('Y-m-d H:i', $u_final_time).'" />
                    <input type="hidden" name="rulepattern" value="'.$u_rule.'" />
                    <input type="hidden" name="srcippattern" value="'.$u_srcip.'" />
                    <input type="hidden" name="userpattern" value="'.$u_user.'" />
                    <input type="hidden" name="locationpattern" value="'.$u_location.'" />
                    <input type="hidden" name="level" value="'.$u_level.'" />
                    <input type="hidden" name="page" value="'.$USER_page.'" />
                    <input type="hidden" name="searchid" value="'.$USER_searchid.'" />
                    <input type="hidden" name="monitoring" value="'.$USER_monitoring.'" />
                    <input type="hidden" name="max_alerts_per_page"
                                         value="'.$ossec_max_alerts_per_page.'" />';
                
                
                if($output_list[0]{'pg'} > 1)
                {
                echo '
                    &nbsp;&nbsp;
                    <input type="submit" name="search" value="Next >" class="button"
                           class="formText" />
                     <input type="submit" name="search" value="Last >>" class="button"
                           class="formText" />
                    </form>
                ';
                }
                /* Checking if page exists */
                if(!isset($output_list[0]{$real_page}) ||
                   (strlen($output_list[$real_page]) < 5) ||
                   (!file_exists($output_list[$real_page])))
                {
                    echo "<b class='red'>Nothing returned (or search expired). </b><br />\n";
                    return(1);
                }
                
                echo "<br /><br />";
                $fp = fopen($output_list[$real_page], "r");
                if($fp)
                {
                    while(!feof($fp))
                    {
                        echo fgets($fp);
                    }
                }
                ?>
                
                  </li>
                  <li class="list-group-item">
                    <h2 class="card-title"> Resume </h2>
                  </li>
                </ul>
                
                </div>
              </div>
            </div>
          </div>

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
