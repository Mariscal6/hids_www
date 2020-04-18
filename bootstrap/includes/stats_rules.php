<table id="rules_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
		<th>Rule</th>
    	<th>Value</th>
   	 	<th>Percentage</th>
		</tr>
	</thead>
	<tbody>
	<?php $odd_count = 0;
	$odd_msg = '';

	if( array_key_exists( 'rule', $daily_stats ) ) {
		foreach($daily_stats{'rule'} as $l_rule => $v_rule)
		{
			(int)$rule_pct = (int)($v_rule * 100)/$daily_stats{'alerts'};
			if(($odd_count % 2) == 0)
			{
				$odd_msg = ' class="odd"';
			}
			else
			{
				$odd_msg = '';
			}
			$odd_count++;
			echo '
			<tr'.$odd_msg.'>
			<td>Total for Rule '.$l_rule.'</td>
			<td>'.number_format($v_rule).'</td>
			<td>'.sprintf("%.01f", $rule_pct).'%</td>
			</tr>
			';
		}
	}
	if(($odd_count % 2) == 0)
	{
		$odd_msg = ' class="odd"';
	}
	else
	{
		$odd_msg = '';
	}
	echo '
	<tr'.$odd_msg.'>
	<td>Total for all rules</td>
	<td>'.number_format($daily_stats{'alerts'}).'</td>
	<td>100%</td>
	</tr>
	';?>
	</tbody>
</table>

<script src="./includes/tools/jquery.dataTables.min.js"></script>
<script src="./includes/tools/jquery.dataTable.percentageBars.js"></script>
<script src="./includes/tools/dataTables.buttons.min.js"></script>
<script src="./includes/tools/buttons.print.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
  // DataTable initialisation
  var table = $('#rules_table').DataTable({
    "dom": '<B><"row" lf>rt<"my-4" ip>',
	"paging": true,
	"colReorder":true,
    "autoWidth": true,
    "columnDefs": [{
        targets: 2,
        render: $.fn.dataTable.render.percentBar('round','#fff', '#FF9CAB', '#FF0033', '#FF9CAB', 0, 'solid')
    }],
	"buttons": [
		//{ "extend": 'colvis', "text":'Export',"className": 'btn btn-secondary'},
		{ "extend":'copyHtml5', "text": 'Copy html',"className":'btn btn-secondary'},
		{ "extend":'csvHtml5', "text": 'CSV <i style="margin-left:4px;" class="fas fa-file-csv"></i>',"className":'btn btn-secondary'},
		{ "extend":'excelHtml5', "text":'Excel <i style="margin-left:4px;" class="fas fa-file-excel"></i>',"className":'btn btn-secondary'},
		{ "extend":'pdfHtml5', "text":'Pdf <i style="margin-left:4px;" class="far fa-file-pdf"></i>',"className":'btn btn-secondary'},
		{ "extend":'print', "text":'Print <i style="margin-left:4px;" class="fas fa-print"></i>',"className":'btn btn-secondary'},
	]
	});

	var buttons = $("#rules_table_wrapper .dt-buttons");
	buttons.addClass("btn-group my-3");
	var filter= document.querySelector("#rules_table_filter");
	filter.className= "input-group col-sm-2";
	filter.children[0].children[0].className="form-control";
	var show= document.querySelector("#rules_table_length");
	show.className= "col-sm-10";
});

</script>