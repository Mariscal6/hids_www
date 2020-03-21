<?php 
require('includes/config.php'); 

$int_error="Internal error. Try again later.\n <br />";
$include_error="Unable to include file:";

$array_lib = array("../ossec_conf.php", "../lib/ossec_categories.php",
"../lib/ossec_formats.php",  
"../lib/os_lib_handle.php",
"../lib/os_lib_agent.php",
"../lib/os_lib_mapping.php",
"../lib/os_lib_stats.php",
"../lib/os_lib_syscheck.php",
"../lib/os_lib_firewall.php",
"../lib/os_lib_alerts.php");

foreach ($array_lib as $mylib)
{
  if(!(include($mylib)))
  {
    echo "$include_error '$mylib'.\n<br />";
    echo "$int_error";
    
  }
}

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


/* Initializing some variables */
$u_final_time = time(0);
$u_init_time = $u_final_time - $ossec_search_time;
$u_level = $ossec_search_level;
$u_pattern = "";
$u_rule = "";
$u_srcip = "";
$u_user = "";
$u_location = "";


$USER_pattern = NULL;
$LOCATION_pattern = NULL;
$USER_group = NULL;
$USER_log = NULL;
$USER_rule = NULL;
$USER_srcip = NULL;
$USER_user = NULL;
$USER_page = 1;
$USER_searchid = 0;
$USER_monitoring = 0;
$used_stored = 0;

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
          
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search Settings</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400" aria-hidden="true"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(-156px, 19px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <div class="dropdown-header">Options</div>
                      <a class="dropdown-item" affects="main-stats" onclick="hideCard(this)">Hide</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Date History</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected disabled>Today</option>
                    <option value="1">Yesterday</option>
                    <option value="2">Last Week</option>
                    <option value="3">Last Month</option>
                  </select>
                </div>

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Alert Level&nbsp&nbsp&nbsp</label>
                  </div>
                  <select class="custom-select" id="inputGroupSelect01">
                    <option selected disabled>5 or Lower</option>
                    <option value="1">6</option>
                    <option value="2">7</option>
                    <option value="3">8</option>
                    <option value="3">9 or Higher</option>
                  </select>
                </div>
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
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(-156px, 19px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <div class="dropdown-header">Options</div>
                      <a class="dropdown-item" affects="main-stats" onclick="hideCard(this)">Hide</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                
                <p class="text-center">No Results.</p>
                
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
