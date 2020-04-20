<?php

/* OS PHP init */
if (!function_exists('os_handle_start'))
{
    echo "<b class='red'>You are not allowed direct access.</b><br />\n";
    return(1);
}

/* Starting handle */
$ossec_handle = os_handle_start($ossec_dir);
if($ossec_handle == NULL) {
    echo "<b class='red'>Unable to access ossec directory.</b><br />\n";
    return(1);
}

/* Current date values */
$curr_time = time(0);
$curr_day = date('d',$curr_time);
$curr_month = date('m', $curr_time);
$curr_year = date('Y', $curr_time);

if (isset($_POST['full_date'])) {
    $full_date = explode("/", $_POST['full_date']);
    $USER_day = $full_date[1];
    $USER_month = $full_date[0];
    $USER_year = $full_date[2];
} else {
    $USER_day = $curr_day;
    $USER_month = $curr_month;
    $USER_year = $curr_year;
    $full_date = $curr_month.'/'.$curr_day.'/'.$curr_year;
}

/* Building stat times */
if(isset($USER_year) && isset($USER_month) && isset($USER_day)) {
    /* Stat for whole month */
    if($USER_day == 0) {
        $init_time = mktime(0, 0, 0, $USER_month, 1, $USER_year);
        $final_time = mktime(0, 0, 0, $USER_month +1, 0, $USER_year);
    } else {
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

// ----------------- Datos Adrian -----------------

$l_year_month = date('Y/M', $init_time);
// Datos del día seleccionado por el usuario, o datos de HOY
$stats_list = os_getstats($ossec_handle, $init_time, $final_time);

// Datos de un mes entero
$init_time_adrian = mktime(0, 0, 0, $USER_month, 1, $USER_year);
$final_time_adrian = mktime(0, 0, 0, $USER_month +1, 0, $USER_year);
$stats_list_full_adrian = os_getstats($ossec_handle, $init_time_adrian, $final_time_adrian);

$daily_stats = array();
$monthly_stats = array();
if(isset($stats_list{$l_year_month}{$USER_day}))
{
    $daily_stats = $stats_list{$l_year_month}{$USER_day};
    $all_stats = $stats_list_full_adrian{$l_year_month};
    $monthly_stats = $stats_list_full_adrian{$l_year_month}{0};
}

// ----------------- Datos Daniel -----------------

$levels = [];
$values = [];
$val_array= [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

$levels_month = [];
$values_month = [];
$val_array_month = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

// 1 Dia

if( array_key_exists( 'level', $daily_stats ) ) {
    asort($daily_stats{'level'});
}

if( array_key_exists( 'rule', $daily_stats ) ) {
    asort($daily_stats{'rule'});
}

$odd_count = 0;
$odd_msg = '';

if( array_key_exists( 'level', $daily_stats ) ) {
    foreach($daily_stats{'level'} as $l_level => $v_level) {
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
}

// Este mes

if( array_key_exists( 'level', $monthly_stats ) ) {
    asort($monthly_stats{'level'});
}

if( array_key_exists( 'rule', $monthly_stats ) ) {
    asort($monthly_stats{'rule'});
}

$odd_count = 0;
$odd_msg = '';

if( array_key_exists( 'level', $monthly_stats ) ) {
    foreach($monthly_stats{'level'} as $l_level => $v_level) {
        (int)$level_pct = (int)($v_level * 100)/$monthly_stats{'alerts'};
        if(($odd_count % 2) == 0)
        {
            $odd_msg = ' class="odd"';
        }
        else
        {
            $odd_msg = '';
        }
        $odd_count++;
        $val_array_month[$l_level]=$v_level;
        array_push($levels_month, $l_level );
        array_push($values_month,$v_level );
    }
}

// Datos Guillermo

?>