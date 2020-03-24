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

/* Getting search id */
print_r($_POST);
if(isset($_POST['searchid']))
{
    if(preg_match('/^[a-z0-9]+$/', $_POST['searchid']))
    {
        $USER_searchid = $_POST['searchid'];
    }
}


$rt_sk = "";
$sv_sk = 'checked="checked"';
if(isset($_POST['monitoring']) && ($_POST['monitoring'] == 1))
{
    $rt_sk = 'checked="checked"';
    $sv_sk = "";

    /* Cleaning up time */
    $USER_final = $u_final_time;
    $USER_init = $u_init_time;
    $USER_monitoring = 1;

    /* Cleaning up fields */
    $_POST['search'] = "Search";
    unset($_POST['initdate']);
    unset($_POST['finaldate']);

    /* Deleting search */
    if($USER_searchid != 0)
    {
        os_cleanstored($USER_searchid);
    }

    /* Refreshing every 90 seconds by default */
    $m_ossec_refresh_time = $ossec_refresh_time * 1000;

    echo '
        <script language="javascript">
            setTimeout("document.dosearch.submit()",'.
            $m_ossec_refresh_time.');
        </script>
        ';
}


/* Reading user input -- being very careful parsing it */
$datepattern = "/^([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})$/";
if(isset($_POST['initdate']))
{
    $i_date = explode("T",$_POST['initdate']);
    if(preg_match($datepattern, $i_date[0]." ".$i_date[1], $regs))
    {
        $USER_init = mktime($regs[4], $regs[5], 0,$regs[2],$regs[3],$regs[1]);
        $u_init_time = $USER_init;
    }
}
if(isset($_POST['finaldate']))
{
    $f_date = explode("T",$_POST['initdate']);
    if(preg_match($datepattern,  $f_date[0]." ".$f_date[1], $regs) == true)
    {
        $USER_final = mktime($regs[4], $regs[5], 0,$regs[2],$regs[3],$regs[1]);
        $u_final_time = $USER_final;
    }
}
if(isset($_POST['level']))
{
    if((is_numeric($_POST['level'])) &&
        ($_POST['level'] > 0) &&
        ($_POST['level'] < 16))
    {
        $USER_level = $_POST['level'];
        $u_level = $USER_level;
    }
}
if(isset($_POST['page']))
{
    if((is_numeric($_POST['page'])) &&
        ($_POST['page'] > 0) &&
        ($_POST['page'] <= 999))
    {
        $USER_page = $_POST['page'];
    }
}


$strpattern = "/^[0-9a-zA-Z.: _|^!\-()?]{1,128}$/";
$intpattern = "/^[0-9]{1,8}$/";

if(isset($_POST['strpattern']))
{
   if(preg_match($strpattern, $_POST['strpattern']) == true)
   {
       $USER_pattern = $_POST['strpattern'];
       $u_pattern = $USER_pattern;
   }
}


/* Getting location */
if(isset($_POST['locationpattern']))
{
    $lcpattern = "/^[0-9a-zA-Z.: _|^!>\/\\-]{1,156}$/";
    if(preg_match($lcpattern, $_POST['locationpattern']) == true)
    {
        $LOCATION_pattern = $_POST['locationpattern'];
        $u_location = $LOCATION_pattern;
    }
}


/* Group pattern */
if(isset($_POST['grouppattern']))
{
    if($_POST['grouppattern'] == "ALL")
    {
        $USER_group = NULL;
    }
    else if(preg_match($strpattern,$_POST['grouppattern']) == true)
    {
        $USER_group = $_POST['grouppattern'];
    }
}

/* Group pattern */
if(isset($_POST['logpattern']))
{
    if($_POST['logpattern'] == "ALL")
    {
        $USER_log = NULL;
    }
    else if(preg_match($strpattern,$_POST['logpattern']) == true)
    {
        $USER_log = $_POST['logpattern'];
    }
}


/* Rule pattern */
if(isset($_POST['rulepattern']))
{
   if(preg_match($strpattern, $_POST['rulepattern']) == true)
   {
       $USER_rule = $_POST['rulepattern'];
       $u_rule = $USER_rule;
   }
}


/* Src ip pattern */
if(isset($_POST['srcippattern']))
{
   if(preg_match($strpattern, $_POST['srcippattern']) == true)
   {
       $USER_srcip = $_POST['srcippattern'];
       $u_srcip = $USER_srcip;
   }
}


/* User pattern */
if(isset($_POST['userpattern']))
{
   if(preg_match($strpattern, $_POST['userpattern']) == true)
   {
       $USER_user = $_POST['userpattern'];
       $u_user = $USER_user;
   }
}


/* Maximum number of alerts */
if(isset($_POST['max_alerts_per_page']))
{
    if(preg_match($intpattern, $_POST['max_alerts_per_page']) == true)
    {
        if(($_POST['max_alerts_per_page'] > 200) &&
           ($_POST['max_alerts_per_page'] < 10000))
        {
            $ossec_max_alerts_per_page = $_POST['max_alerts_per_page'];
        }
    }
}



/* Getting search id  -- should be enough to avoid duplicates */
if( array_key_exists( 'search', $_POST ) ) {
    if($_POST['search'] == "Search")
    {
        /* Creating new search id */
        $USER_searchid = md5(uniqid(rand(), true));
        $USER_page = 1;
    }
    else if($_POST['search'] == "<< First")
    {
        $USER_page = 1;
    }
    else if($_POST['search'] == "< Prev")
    {
        if($USER_page > 1)
	    {
	        $USER_page--;
	    }
	}
	else if($_POST['search'] == "Next >")
	{
	    $USER_page++;
	}
	else if($_POST['search'] == "Last >>")
	{
	    $USER_page = 999;
	}
	else if($_POST['search'] == "")
	{
	}
	else
	{
	    echo "<b class='red'>Invalid search. </b><br />\n";
	    return;
	}
}

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
                  <form name="dosearch" method="post" action="search.php">
                    <div class="row">
                      <input type="hidden" name="monitoring" value="0" checked="checked"/>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">From:</label>
                          </div>
                            <input type='datetime-local' class="form-control rounded-right" name="initdate" value="<?php echo date('Y-m-d\Th:i', $u_init_time) ?>"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">To:</label>
                          </div>
                            <input type='datetime-local' class="form-control rounded-right" name="finaldate" value="<?php echo date('Y-m-d\Th:i', $u_final_time) ?>"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-sm-12 pl-5">
                        <input type="radio" name="monitoring" value="1" <?php echo $rt_sk?>/>
                        <label> Real time monitoring </label>
                      </div>
                    </div>
                    <hr/>
                    <div class="row mt-1">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Minimum level:</label>
                          </div>
                          <select class="custom-select" name="level">
                            <?php
                              if($u_level == 1)
                              {
                                  echo '   <option value="1" selected="selected">All</option>';
                              }
                              else
                              {
                                  echo '   <option value="1">All</option>';
                              }
                              for($l_counter = 15; $l_counter >= 2; $l_counter--)
                              {
                                  if($l_counter == $u_level)
                                  {
                                      echo '   <option value="'.$l_counter.'" selected="selected">'.
                                           $l_counter.'</option>';
                                  }
                                  else
                                  {
                                      echo '   <option value="'.$l_counter.'">'.$l_counter.'</option>';
                                  }
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Category: </label>
                          </div>
                          <select class="custom-select" name="grouppattern" id="inputGroupSelect01">
                            <option value="ALL" class="bluez">All categories</option>
                            <?php 
                              foreach($global_categories as $_cat_name => $_cat)
                              {
                                  foreach($_cat as $cat_name => $cat_val)
                                  {
                                      $sl = "";
                                      if($USER_group == $cat_val)
                                      {
                                          $sl = ' selected="selected"';
                                      }
                                      if(strpos($cat_name, "(all)") !== FALSE)
                                      {
                                          echo '<option class="bluez" '.$sl.
                                              ' value="'.$cat_val.'">'.$cat_name.'</option>';
                                      }
                                      else
                                      {
                                          echo '<option value="'.$cat_val.'" '.$sl.
                                              '> &nbsp; '.$cat_name.'</option>';
                                      }
                                  }
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Pattern: </label>
                          </div>
                          <input type="text" class="form-control" name="strpattern" value="<?php echo $u_pattern?>"/>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Log formats: </label>
                          </div>
                          <select class="custom-select" name="logpattern">
                              <?php
                                echo '<option value="ALL" class="bluez">All log formats</option>';

                                foreach($log_categories as $_cat_name => $_cat)
                                {
                                    foreach($_cat as $cat_name => $cat_val)
                                    {
                                        $sl = "";
                                        if($USER_log == $cat_val)
                                        {
                                            $sl = ' selected="selected"';
                                        }
                                        if(strpos($cat_name, "(all)") !== FALSE)
                                        {
                                            echo '<option class="bluez" '.$sl.
                                                 ' value="'.$cat_val.'">'.$cat_name.'</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="'.$cat_val.'" '.$sl.
                                                 '> &nbsp; '.$cat_name.'</option>';
                                        }
                                    }
                                }
                              ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Srcip: </label>
                          </div>
                          <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">User: </label>
                          </div>
                          <input type="text" class="form-control" name="srcippattern" value="<?php echo $u_srcip?>"/>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Location: </label>
                          </div>
                          <input type="text" class="form-control" name="locationpattern" value="<?php echo $u_location?>"/>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Rule id: </label>
                          </div>
                          <input type="text" class="form-control" name="rulepattern" value="<?php echo $u_rule?>"/>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <div class="col-sm-6">
                        <div class="input-group mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Max Alerts: </label>
                          </div>
                          <input type="text" class="form-control" name="max_alerts_per_page" value="<?php echo $ossec_max_alerts_per_page?>"/>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <input type="submit" name="search" value="Search" class="btn btn-info" />
                      </div>
                    </div>
                    <input type="hidden" name="searchid" value="<?php echo $USER_searchid ?>" />
                  </form>
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
                      <a class="dropdown-item" href="#">Order by</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Order by</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                <ul class="list-group list-group-flush">
                <?php echo $USER_init."---";
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
                print_r($output_list);
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
                
                
                echo "<b>Total alerts found: </b>".$output_list[0]{'count'}."<br />";
                
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
