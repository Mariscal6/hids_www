<?php require('includes/config.php'); ?>
<?php require('includes/indexInit.php'); ?>
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
 
  <?php require('imports/allCSS.php'); ?>
  
  <?php require('includes/indexFunction.php'); ?>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php $page="main"; require('includes/sidePanel.php'); ?>
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

        <div class="card border-left-custom">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
              <h1 class="h3 mb-0 text-gray-800">Home&nbsp&nbsp<i class="fas fa-home"></i></h1>
              </div>
            </div>
          </div>
        </div>

        </br>
         
          <!-- Content Row -->
          <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Available Agents&nbsp&nbsp<i class="fas fa-server"></i></h6>
                </div>
                <div class="card-body" style="min-height: 208px;">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <?php
                      showAgents($ossec_handle);
                    ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">Latest Modified Files&nbsp&nbsp<i class="far fa-file-code"></i></h6>
                </div>
                <div class="card-body" style="min-height: 208px;">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                    <?php
                      showLastModified($ossec_handle);
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
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="background-color:#eaecf4">
                  <h6 class="m-0 font-weight-bold text-primary">Latest Events&nbsp&nbsp<i class="fas fa-digital-tachograph"></i></h6>
                </div>
                <div class="p-4"> 
                  <?php 
                    listAlert($ossec_handle)
                  ?>  
                </div>
              </div>
            </div>
          </div>
          <!-- End Card -->

          <!-- List last alerts -->

         
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

  <script type="text/javascript" src="js/calendar.js"></script>
  <script type="text/javascript" src="js/calendar-en.js"></script>
  <script type="text/javascript" src="js/calendar-setup.js"></script>
  <script type="text/javascript" src="js/prototype.js"></script>
  <script type="text/javascript" src="js/hide.js"></script>


</body>

</html>