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


  <!-- Dump Database Modal -->
  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header" style="display: block;" >
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">File Integrity</h4>
          </div>
          <div class="modal-body">
            <div class="" id="nof"></div>
            <hr>
            <div class="" id="md5"></div>
            <hr>
            <div class="" id="sha1"></div>
            <hr>
            <div class="" id="size"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>      
      </div>
  </div>

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
          <form name="dosearch" method="post" action="integrity.php">
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Agent</h6>
                </div>
                <div class="card-body">

                    <div class="row">
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
                </div>
                <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                  <button type="submit" name="ss" class="btn btn-success">Apply Agent</button>
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
              </div>
              </div>
            <div>
          </div>
          </form>
          <!-- End Card -->

          <form id="searchByName" action="" method="POST">
          <!-- Start Card -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search Files By Name</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">File Name: </label>
                      </div>
                      <input id="fileName" type="text" class="form-control" name="fileName" value="<?php echo $fileName; ?>">
                    </div>
                  </div>
                </div>
                <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                  <button type="submit" class="btn btn-success">Search</button>
                  <button type="button" class="btn btn-danger" onclick="clearFilters();">Clear Search</button>
                </div>
              </div>
            <div>
          </div>
          </form>
          <!-- End Card -->

          <form id="searchByHash" action="" method="POST">
          <!-- Start Card -->
          <div class="row">
            <div class="col-lg-12">
              <div id="main-stats" class="card show mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Search File By Hash</h6>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">MD5 Hash: </label>
                      </div>
                      <input id="md5" type="text" class="form-control" name="md5" value="<?php echo $md5; ?>">
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label style="width: 200px;" class="input-group-text" for="inputGroupSelect01">SHA1 Hash: </label>
                      </div>
                      <input id="sha1" type="text" class="form-control" name="sha1" value="<?php echo $sha1; ?>">
                    </div>
                  </div>
                </div>
                <div class="card-footer py-3 d-flex flex-row align-items-center justify-content-between">
                  <button type="submit" class="btn btn-success">Search File By Hash</button>
                  <button type="button" class="btn btn-danger" onclick="clearFilters();">Clear Search</button>
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
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      </div>
      <!-- End of Main Content -->

      </div>
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
  <script src="js/integrity.js"></script>

</body>

</html>

<script>

function loadSpecificChecksum(element) {
    var path = element.getAttribute('fileName');

    var array = <?php  echo json_encode($db_changes);?>;
    var name = "";
    var md5 = "";
    var sha1 = "";
    var size = 0;
    for (var i = 0; i < array.length; i++) {
      if (array[i][i].name == path) {
        name = array[i][i].name;
        md5 = array[i][i].sum;
        size = array[i][i].size;
        break;
      }
    }

    md5 = md5.split('->');
    size = size.split('->');

    var allMD5 = [];
    var allSHA1 = [];
    var allSizes = size;

    for (var i = 0; i < md5.length; i++) {
      var fila = md5[i].split(' ');
      allMD5.push(fila[1]);
      allSHA1.push(fila[3]);
    }

    var icon = '<p style="color: red; text-align: center;"><i class="fas fa-angle-double-down"></i></p>';

    var nof = document.getElementById('nof');
    nof.innerHTML = "<h2>File Directory:</h2><br>"
     + "<h4 style='text-align: center;'>" + name + "</h4>";

    var md5Div = document.getElementById('md5');
    var html = "<h2>MD5 History:</h2><br>";
    
    for (var i = 0; i < allMD5.length; i++) {
      html += '<h5 style="text-align: center;">' + allMD5[i] + '</h5>';
      if (i != allMD5.length - 1) {
        html += icon;
      }
    }

    md5Div.innerHTML = html;

    var sha1Div = document.getElementById('sha1');
    html = "<h2>SHA1 History:</h2><br>";
    for (var i = 0; i < allSHA1.length; i++) {
      html += '<h5 style="text-align: center;">' + allSHA1[i] + '</h5>';
      if (i != allSHA1.length - 1) {
        html += icon;
      }
    }

    sha1Div.innerHTML = html;
    
    var sizeDiv = document.getElementById('size');
    html = "<h2>Size History:</h2><br>";

    for (var i = 0; i < allSizes.length; i++) {
      html += '<h5 style="text-align: center;">' + allSizes[i] + '</h5>';
      if (i != allSizes.length - 1) {
        html += icon;
      }
    }

    sizeDiv.innerHTML = html;

}

</script>
