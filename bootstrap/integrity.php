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
    <?php $page="integrity"; require('includes/sidePanel.php'); ?>
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
          <div class="card border-left-custom">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <h1 class="h3 mb-0 text-gray-800">Integrity Checking&nbsp&nbsp<i class="fas fa-fingerprint"></i></h1>
                </div>
              </div>
            </div>
          </div>

          <br/>

          <!-- Content Row -->
          <div class="row">
            
          </div>

          <!-- Content Row -->
          <form name="dosearch" method="post" action="index.php?f=i">
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Agent</h6>
                </div>
                <div class="card-body">

                  
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Agent name:</label>
                        </div>
                        <select name="agentpattern" class="custom-select">
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
                        ?>
                        </select>
                      </div>
                </div>
                <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                  <?php
                      /* Dumping database */
                      if( array_key_exists( 'ss', $_POST ) ) {
                        if(($_POST['ss'] == "Dump database") && ($USER_agent != NULL))
                        {
                            os_syscheck_dumpdb($ossec_handle, $USER_agent);
                            return(1);
                        }
                      }
                  ?>
                  <button type="submit" name="ss" class="btn btn-success">Dump database</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- End Card -->

          <form id="filterForm" action="" method="POST">
          <!-- Start Card -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Filters</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Maximum Files per Day: </label>
                      </div>
                      <input id="maxFiles" type="text" class="form-control" name="maxFiles" value="<?php echo $maxFiles; ?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Maximum Days: </label>
                      </div>
                      <input id="maxDays" type="text" class="form-control" name="maxDays" value="<?php echo $maxDays; ?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Order of Dates:</label>
                      </div>
                      <select id="dayOrder" class="custom-select" name="dayOrder">
                        <option value="asc" <?php if ($dayOrder == "asc") { echo 'selected';} ?>>Ascending</option>
                        <option value="desc" <?php if ($dayOrder == "desc") { echo 'selected';} ?>>Descending</option>
                      </select>
                      </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Order of Files:</label>
                      </div>
                      <select id="fileOrder" class="custom-select" name="fileOrder">
                        <option value="asc" <?php if ($fileOrder == "asc") { echo 'selected';} ?>>Ascending</option>
                        <option value="desc" <?php if ($fileOrder == "desc") { echo 'selected';} ?>>Descending</option>
                      </select>
                      </div>
                    </div>
                </div>
                <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                  <button type="submit" class="btn btn-success">Apply Filters</button>
                  <button type="button" class="btn btn-danger" onclick="clearFilters();">Clear Filters</button>
                </div>
              </div>
            <div>
          </div>
          </form>
          <!-- End Card -->
          
          <!-- Card (Row) -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Latest modified files (for all agents)</h6>
                </div>
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2" id="modifiedFiles">
                    <?php
                        /* Last modified files */
                        require('includes/tools/integrity/modifiedFiles.php');
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

    </div>
    <!-- End of Content Wrapper -->

    <!-- Footer -->
    <?php require('includes/footer.php'); ?>
    <!-- End of Footer -->

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
