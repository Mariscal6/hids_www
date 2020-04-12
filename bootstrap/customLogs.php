<?php require('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Custom Logs</title>

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

      <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require('includes/topBar.php'); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <!-- Begin Page Content -->
        <div class="container-fluid">


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
                                  <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">Type:</label>
                              </div>
                              <select id="dayOrder" class="custom-select" name="dayOrder" onchange="changeType(this);">
                                  <option disabled selected value="">Select a type</option>
                                  <option value="command">Command</option>
                                  <option value="localFile">Localfile</option>
                                  <option value="response">Active Response</option>
                              </select>
                          </div>
                      </div>
                      <br>
                      <div class="row" id="typeContent">


                      </div>
                      <div class="row" id="secondLocalFile">
        
                      </div>
                  </div>
                  <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                    <button type="submit" disabled class="btn btn-success" title="Not all fields are complete">Add Register</button>
                  </div>
                </div>
              <div>
            </div>
            </form>
        
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
