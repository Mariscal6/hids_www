<?php require('includes/config.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Error 404</title>

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
      <?php echo('hola'); ?>
      <!-- End of Sidebar -->

      <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require('includes/topBar.php'); ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="row">
          <!-- Begin Page Content -->
          <div class="container-fluid">
            <!-- 404 Error Text -->
            <div class="text-center">
              <div class="error mx-auto" data-text="404">
                404
              </div>
              <p class="lead text-gray-800 mb-5">Page Not Found</p>
              <p class="text-gray-500 mb-0">Nice try, but...</p>
              <a href="index.php">&larr; Back to Main</a>
            </div>
            
          </div>
          <!-- /.container-fluid -->
        
        </div>
      
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
