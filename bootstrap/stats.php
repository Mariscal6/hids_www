<?php require('includes/config.php'); ?>
<?php require('includes/statsInit.php'); ?>

<?php require('imports/all.php'); ?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Stats</title>

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
    <?php $page="stats"; require('includes/sidePanel.php'); ?>
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
                <h1 class="h3 mb-0 text-gray-800">Stats&nbsp&nbsp<i class="fas fa-chart-bar"></i></h1>
                </div>
              </div>
            </div>
          </div>
          
          </br>

          <!-- Start Calendar -->
          <div class="row-12">
            <div class="card shadow mb-4">
              <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Monitoring Range</h6>
              </div>
              <div class="card-body">
              <form action="stats.php" method="POST">
                <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend date">
                        <label style="width: 150px;" class="input-group-text" for="inputGroupSelect01">Choose a Day&nbsp&nbsp<i class="far fa-calendar-alt"></i> </label>
                      </div>
                      <input type="text" value="<?php if(isset($_POST['full_date'])) { echo $_POST['full_date']; } else { echo $full_date; }?>" data-provide="datepicker" name="full_date" class="form-control input-group-addon">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Apply</button>
                </div>
              </form>
            </div>
          </div>
          <!-- End Calendar -->

          <!-- Aggregate By Severity One Day -->
          <div class="row-12">
            <div class="card shadow mb-4 show">
              <a href="#severityDay" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">Aggregate By Severity (Day)</h6>
              </a>
              <!-- Card Content - Collapse -->
              <div class="card-body collapse"id="severityDay" >
                <div style="justify-content: center; display: flex; height: 600px;">
                  <div id="severityChartDay">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Aggregate By Severity -->

          <!-- Aggregate By Severity One Day -->
          <div class="row-12">
            <div class="card shadow mb-4 show">
              <a href="#severityMonth" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">Aggregate By Severity (Month)</h6>
              </a>
              <!-- Card Content - Collapse -->
              <div class="card-body collapse"id="severityMonth" >
                <div style="justify-content: center; display: flex; height: 600px;">
                  <div id="severityChartMonth">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Aggregate By Severity -->

          <!-- Rules Toay -->
          <div class="row-12">
            <div class="card shadow mb-4 show">
              <a href="#rulesDay" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">Rules (Day)</h6>
              </a>
              <!-- Card Content - Collapse -->
              <div class="card-body collapse"id="rulesDay" >
                <?php require('includes/stats_rules_daily.php'); ?>
              </div>
            </div>
          </div>
          <!-- End Rules Today -->

          <!-- Rules Month -->
          <div class="row-12">
            <div class="card shadow mb-4 show">
              <a href="#rulesMonth" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">Rules (Month)</h6>
              </a>
              <!-- Card Content - Collapse -->
              <div class="card-body collapse"id="rulesMonth" >
                <?php require('includes/stats_rules_monthly.php'); ?>
              </div>
            </div>
          </div>
          <!-- End Rules Month -->

          <!-- Daily Alerts -->
          <div class="row-12">
            <div class="card shadow mb-4 show">
              <a href="#alertsDay" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">Today's Alerts</h6>
              </a>
              <div class="card-body collapse show" id="alertsDay">
                  <div id="dayChart">
                  </div>
              </div>
            </div>
          </div>
          <!-- End Daily Alerts -->
          
          <!-- Monthly Alerts -->
          <div class="row-12">
            <div class="card shadow mb-4">
            <a href="#alertsMonth" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true">
                <h6 class="m-0 font-weight-bold text-primary">This Month's Alerts</h6>
              </a>
              <div class="card-body collapse show" id="alertsMonth">
                <div style="justify-content: center; display: flex; height: 600px;">
                  <div id="monthChart">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End Monthly Alerts -->

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

</body>
</html>
<?php include('js/stats_js.php'); ?>