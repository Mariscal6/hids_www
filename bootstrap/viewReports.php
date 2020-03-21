<?php require('includes/config.php'); ?>
<?php require('includes/loadReports.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Reports</title>

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
            <h1 class="h3 mb-0 text-gray-800">Reports</h1>
          </div>

          <!-- All Read -->
          <div id="reportsRead" class="row" hidden>
            <div class="col-md-6 justify-content-center">
                <span>
                <a href="index" class="btn btn-success btn-circle btn-lg">
                    <i class="fas fa-check"></i>
                </a> &nbsp&nbsp No new reports!
                </span>
            </div>
          </div>

          <!-- Card -->
          <div class="row">
            <div class="col-lg-12">
              <div name="reportCard" id="report1" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Report from: adrian</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(-156px, 19px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <div class="dropdown-header">Options</div>
                      <a class="dropdown-item" affects="report1" onclick="hideCard(this)">Hide</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">21:44 29/02/2020</div>
                    <p>Yesterday I found a bug inside the application where...</p>

                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->

          <!-- Card -->
          <div class="row">
            <div class="col-lg-12">
              <div name="reportCard" id="report2" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Report from: guillermo</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" x-placement="bottom-end" style="position: absolute; transform: translate3d(-156px, 19px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <div class="dropdown-header">Options</div>
                      <a class="dropdown-item" affects="report2" onclick="hideCard(this)">Hide</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">21:44 29/02/2020</div>
                    <p>I would like to file a petition to become administrator for this platform.</p>

                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->

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
