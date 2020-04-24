<script type="text/javascript">

$( document ).ready(function() {
  $('#datetimepicker').datetimepicker({});
});

google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawDailyChart);

function drawDailyChart() {

  var hours = [];
  var alerts = [];
  var syschek = [];
  var firewall = [];

  <?php 

  for ($i = 0; $i < 23; $i++) {
    ?>
    var aux = [<?php echo $daily_stats{'alerts_by_hour'}[$i]; ?>];
    if (aux.length > 0) {
      var hour = '' + <?php echo $i; ?> + ':00'
      hours.push(hour);
      alerts.push(aux[0]);
    }

    aux = [<?php echo $daily_stats{'syscheck_by_hour'}[$i]; ?>];
    if (aux.length > 0) {
      syschek.push(aux[0]);
    }

    aux = [<?php echo $daily_stats{'firewall_by_hour'}[$i]; ?>];
    if (aux.length > 0) {
      firewall.push(aux[0]);
    }
    <?php
  }

  ?>

  var tabla = [['Hour', 'Alerts', 'Syscheck', 'Firewall']];

  for (var i = 0; i < hours.length; i++) {
    var fila = [];
    fila.push(hours[i]);
    fila.push(alerts[i]);
    fila.push(syschek[i]);
    fila.push(firewall[i]);
    tabla.push(fila);
  }

  var data = "";

  if (tabla.length == 1) {
    tabla.push(['No Data', 0, 0, 0]);
    data = google.visualization.arrayToDataTable(
      tabla
    );
  } else {
    data = google.visualization.arrayToDataTable(
      tabla
    );
  }

  /*$hour_alerts = $daily_stats{'alerts_by_hour'}[$i];
  $hour_syscheck = $daily_stats{'syscheck_by_hour'}[$i];
  $hour_firewall = $daily_stats{'firewall_by_hour'}[$i];

  (int)$total_pct = (int)($hour_total * 100)/max($daily_stats{'total'},1);
  (int)$alerts_pct = (int)($hour_alerts * 100)/max($daily_stats{'alerts'},1);
  (int)$syscheck_pct=(int)($hour_syscheck *100)/max($daily_stats{'syscheck'},1);
  (int)$firewall_pct=(int)($hour_firewall *100)/max($daily_stats{'firewall'},1);*/

  var data = google.visualization.arrayToDataTable(
    tabla
  );

  var date = '<?php echo $_POST['full_date']; ?>';

  if (date == '') {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    date = mm + '/' + dd + '/' + yyyy;
  }

  var options = {
    chart: {
      title: 'Alerts per Hour',
      subtitle: 'Alerts, Syscheck and Firewall in ' + date,
    },
    width: 1400,
    height: 600,
    hAxis : { 
      textStyle : {
        fontSize: 15
      },
      showTextEvery: true,
    },
    bars: 'horizontal' // Required for Material Bar Charts.
  };

  var chart = new google.charts.Bar(document.getElementById('dayChart'));

  chart.draw(data, google.charts.Bar.convertOptions(options));
}

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawMonthlyChart);

function drawMonthlyChart() {

  var days = [];
  var alerts = [];
  var syschek = [];
  var firewall = [];
  <?php  
  for ($i = 0; $i < 32; $i++) {
    $myi = $i;
    if ($i < 10) {
      $myi = "0".$i;
    }
    ?>
    var aux = [<?php echo $all_stats{$myi}{'alerts'}; ?>];
    if (aux.length > 0) {
      var day = '' + <?php echo $myi; ?>;
      days.push(day);
      alerts.push(aux[0]);
    }

    aux = [<?php echo $all_stats{$myi}{'syscheck'}; ?>];
    if (aux.length > 0) {
      syschek.push(aux[0]);
    }

    aux = [<?php echo $all_stats{$myi}{'firewall'}; ?>];
    if (aux.length > 0) {
      firewall.push(aux[0]);
    }
    <?php
  }

  ?>

  var tabla = [['Day', 'Alerts', 'Syscheck', 'Firewall']];

  for (var i = 0; i < days.length; i++) {
    var fila = [];
    fila.push(days[i].toString());
    fila.push(alerts[i]);
    fila.push(syschek[i]);
    fila.push(firewall[i]);
    tabla.push(fila);
  }

  if (tabla.length == 1) {
    tabla.push(['No Data', 0, 0, 0]);
    data = google.visualization.arrayToDataTable(
      tabla
    );
  } else {
    data = google.visualization.arrayToDataTable(
      tabla
    );
  }

  var date = '<?php echo $_POST['full_date']; ?>';
  var month = ""

  const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  if (date == '') {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();
    date = mm + '/' + dd + '/' + yyyy;
  } else {
    month = monthNames[<?php echo $USER_month; ?> - 1];
  }

  var options = {
    title : 'Alerts per Day in ' + month,
    vAxis: {title: 'Alerts'},
    hAxis: {title: 'Day'},
    seriesType: 'bars',
    series: {5: {type: 'line'}},
    vAxis: {scaleType: "mirrorLog"},
    width: 1600,
    height: 600,
  };

  var chart = new google.visualization.ComboChart(document.getElementById('monthChart'));
  chart.draw(data, options);
}

// Dani

google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawSeverityChartDaily);
function drawSeverityChartDaily() {

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
      vAxis: {scaleType: "mirrorLog"},
      width: 1600,
      height: 600,
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("severityChartDay"));
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

google.charts.load("current", {packages:['corechart']});
google.charts.setOnLoadCallback(drawSeverityChartMonthly);
function drawSeverityChartMonthly() {

  var levels = <?php  echo json_encode($levels_month);?>;
  var values = <?php  echo json_encode($values_month);?>;
  var val = <?php  echo json_encode($val_array_month);?>;

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
      vAxis: {scaleType: "mirrorLog"},
      width: 1600,
      height: 600,
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("severityChartMonth"));
    chart.draw(view, options);
  }

</script>