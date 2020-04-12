<?php 
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
    $f_date = explode("T",$_POST['finaldate']);
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
?>