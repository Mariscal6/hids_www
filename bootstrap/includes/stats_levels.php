

<?php
$levels = [];
$values = [];
$val_array= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];


/* OS PHP init */
if (!function_exists('os_handle_start'))
{
    echo "<b class='red'>You are not allowed direct access.</b><br />\n";
    return(1);
}

/* Starting handle */
$ossec_handle = os_handle_start($ossec_dir);
if($ossec_handle == NULL)
{
    echo "<b class='red'>Unable to access ossec directory.</b><br />\n";
    return(1);
}


/* Current date values */
$curr_time = time(0);
$curr_day = date('d',$curr_time);
$curr_month = date('m', $curr_time);
$curr_year = date('Y', $curr_time);


/* Getting user values */
if(isset($_POST['day']))
{
    if(is_numeric($_POST['day']))
    {
        if(($_POST['day'] >= 0) && ($_POST['day'] <= 31))
        {
            $USER_day = $_POST['day'];
        }
    }
}
if(isset($_POST['month']))
{
    if(is_numeric($_POST['month']))
    {
        if(($_POST['month'] > 0) && ($_POST['month'] <= 12))
        {
            $USER_month = $_POST['month'];
        }
    }
}
if(isset($_POST['year']))
{
    if(is_numeric($_POST['year']))
    {
        if(($_POST['year'] >= 1) && ($_POST['year'] <= 3000))
        {
            $USER_year = $_POST['year'];
        }
    }
}


/* Building stat times */
if(isset($USER_year) && isset($USER_month) && isset($USER_day))
{
    /* Stat for whole month */
    if($USER_day == 0)
    {
        $init_time = mktime(0, 0, 0, $USER_month, 1, $USER_year);
        $final_time = mktime(0, 0, 0, $USER_month +1, 0, $USER_year);
    }

    else
    {
        $init_time = mktime(0, 0, 0, $USER_month, $USER_day, $USER_year);
        $final_time = mktime(0, 0, 10, $USER_month, $USER_day, $USER_year);
        
        /* Getting valid formated day */
        $USER_day = date('d',$init_time);
    }
}
else
{
    $init_time = $curr_time -1;
    $final_time = $curr_time;

    /* Setting user values */
    $USER_month = $curr_month;
    $USER_day = $curr_day;
    $USER_year = $curr_year;
}




/* Getting daily stats */
$l_year_month = date('Y/M', $init_time);

$stats_list = os_getstats($ossec_handle, $init_time, $final_time);

$daily_stats = array();
if(isset($stats_list{$l_year_month}{$USER_day}))
{
    $daily_stats = $stats_list{$l_year_month}{$USER_day};
    $all_stats = $stats_list{$l_year_month};
}

if(!isset($daily_stats{'total'}))
{
    echo '<br />
        <b class="red">No stats available.</b>';
    return(1);
}
else
{
    echo '<br />';
}

if( array_key_exists( 'level', $daily_stats ) ) {
    asort($daily_stats{'level'});
}

if( array_key_exists( 'rule', $daily_stats ) ) {
    asort($daily_stats{'rule'});
}

$odd_count = 0;
$odd_msg = '';


if( array_key_exists( 'level', $daily_stats ) ) {
foreach($daily_stats{'level'} as $l_level => $v_level)
{
    (int)$level_pct = (int)($v_level * 100)/$daily_stats{'alerts'};
    if(($odd_count % 2) == 0)
    {
        $odd_msg = ' class="odd"';
    }
    else
    {
        $odd_msg = '';
    }
    $odd_count++;
    $val_array[$l_level]=$v_level;
    array_push($levels, $l_level );
    array_push($values,$v_level );
}
echo '<div id="columnchart_values"></div>';
}

?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

    var levels = <?php  echo json_encode($levels);?>;
    var values = <?php  echo json_encode($values);?>;
    var val = <?php  echo json_encode($val_array);?>;

    var table = [["Levels", "Values", { role: "style" }]];
    const count = val.length;
    for (var i = 0; i < count; i++) {
      var row = [];
      color = generateColours(i)
      level = "Level "+ i;
      row.push(level, parseInt(val.shift()),color);
      table.push(row);
    }

      var data = google.visualization.arrayToDataTable(
          table
      );

      var view = new google.visualization.DataView(data);

      var options = {
        title: "Aggregate values by severity",
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
        vAxis: {scaleType: "mirrorLog"}
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
    }

    function generateColours(level){
        switch(level){
            case 0: return "#34F100";
            case 1: return "#5CF100";
            case 2: return "#76F100";
            case 3: return "#97F100";
            case 4: return "#B4F100";
            case 5: return "#D4F100";
            case 6: return "#A8F100";
            case 7: return "#E7F100";
            case 8: return "#F1D000";
            case 9: return "#F1AB00";
            case 10: return "#F18E00";
            case 11: return "#F17500";
            case 12: return "#F15400";
            case 13: return "#F13A00";
            case 14: return "#F11900";
            case 15: return "#F10000";
        }          
    }

</script>