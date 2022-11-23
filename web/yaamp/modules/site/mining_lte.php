<?php

$algo = user()->getState('yaamp-algo');

JavascriptFile("/extensions/jqplot/jquery.jqplot.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.dateAxisRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.barRenderer.js");
JavascriptFile("/extensions/jqplot/plugins/jqplot.highlighter.js");
JavascriptFile('/yaamp/ui/js/auto_refresh.js');

$height = '240px';

openMainContent();
?>
<!-- Auto Refresh -->
<div id='resume_update_button'style='color: #ffffff; background-color: #41464b; border: 1px solid #7d7d7d;
  padding: 10px; margin-left: 20px; margin-right: 20px; margin-top: 15px; cursor: pointer; display: none;'
  onclick='auto_page_resume();' align=center>
    <div class="alert alert-warning alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <h5><i class="icon fas fa-exclamation-triangle"></i> Auto Refresh Is Paused - Click Here To Resume </h5>
    </div>
  </div>
  <!-- ./Auto Refresh -->

<div class="row">
  <div class="col-lg-6">
    <?php

		echo <<<end
		<div id='mining_results'>
		<br>
		</div>
		end;

		if($algo != 'all')
		{
		openCard('card-primary','Last 24 Hours Estimate '.$algo);
		echo'<div id="graph_results_price" style="height: $height;"></div></div></div><br>';

		openCard('card-primary','Last 24 Hours Hashrate '.$algo);
		echo '<div id="pool_hashrate_results" style="height: $height;"></div></div></div><br>';
		}

		$algo_unit = 'Mh';
		$algo_factor = yaamp_algo_mBTC_factor($algo);
		if ($algo_factor == 0.001) $algo_unit = 'Kh';
		if ($algo_factor == 1000) $algo_unit = 'Gh';
		if ($algo_factor == 1000000) $algo_unit = 'Th';
		if ($algo_factor == 1000000000) $algo_unit = 'Ph';

		?>

   </div> <!-- col-lg-6 close -->
  <div class="col-lg-6">

		<div id='pool_current_results'><br></div>

		<div id='found_results'><br></div>
		<br>
 </div> <!-- col-lg-6 close -->
</div> <!-- row close -->

<?php
closeMainContent();

echo <<<end

<script>

var global_algo = '$algo';

function select_algo(algo)
{
	window.location.href = '/site/gomining?algo='+algo;
}

function page_refresh()
{
	pool_current_refresh();
	mining_refresh();
	found_refresh();

	if(global_algo != 'all')
	{
		pool_hashrate_refresh();
		main_refresh_price();
	}
}

////////////////////////////////////////////////////

function pool_current_ready(data)
{
	$('#pool_current_results').html(data);
}

function pool_current_refresh()
{
	var url = "/site/current_results";
	$.get(url, '', pool_current_ready);
}

////////////////////////////////////////////////////

function mining_ready(data)
{
	$('#mining_results').html(data);
}

function mining_refresh()
{
	var url = "/site/mining_results";
	$.get(url, '', mining_ready);
}

////////////////////////////////////////////////////

function found_ready(data)
{
	$('#found_results').html(data);
}

function found_refresh()
{
	var url = "/site/found_results";
	$.get(url, '', found_ready);
}

///////////////////////////////////////////////////////////////////////

function main_ready_price(data)
{
	graph_init_price(data);
}

function main_refresh_price()
{
	var url = "/site/graph_price_results";
	$.get(url, '', main_ready_price);
}

function graph_init_price(data)
{
	$('#graph_results_price').empty();

	var t = $.parseJSON(data);
	var plot1 = $.jqplot('graph_results_price', t,
	{
		title: '<b>Estimate (mBTC/{$algo_unit}/day)</b>',
		axes: {
			xaxis: {
				tickInterval: 7200,
				renderer: $.jqplot.DateAxisRenderer,
				tickOptions: {formatString: '<font size=1>%#Hh</font>'}
			},
			yaxis: {
				min: 0,
				tickOptions: {formatString: '<font size=1>%#.3f &nbsp;</font>'}
			}
		},

		seriesDefaults:
		{
			markerOptions: { style: 'none' }
		},

		grid:
		{
			borderWidth: 1,
			shadowWidth: 0,
			shadowDepth: 0,
			background: '#41464b'
		},

	});
}

///////////////////////////////////////////////////////////////////////

function pool_hashrate_graph_init(data)
{
	
	$('#pool_hashrate_results').empty();
    data = JSON.parse(data);
    var data1 = data[0];
    var data2 = data[1];
    var options = {
					series : [{
						name : 'Hashrate',
						data : data1,
					},{
						name : 'Average',
						data : data2,
					}],
					chart : {
						type : "area",
						height : 240,
						foreColor : "#FFF",
						fontFamily : 'Tahoma, Arial',
						stacked : false,
						dropShadow : {
							enabled : true,
							enabledSeries : [0],
							top : -2,
							left : 2,
							blur : 5,
							opacity : 0.03
						},
						toolbar : {
							show : true,
						}
					},
					colors : ['#008BB2','#830000'],
					stroke : {
						curve : "smooth",
						width : 2
					},
					dataLabels : {
						enabled : false
					},

					markers : {
						size : 0,
						strokeColor : "#000",
						strokeWidth : 2,
						strokeOpacity : 1,
						fillOpacity : 1,
						hover : {
							size : 6
						}
					},
					xaxis : {
						type : "datetime",
						axisBorder : {
							show : true
						},
						axisTicks : {
							show : true
						}
					},
yaxis : {
                        decimalsInFloat : 3,
						labels : {
							minWidth: 50,
							"formatter": function (val) {
								if(val> 1000000000){
									val = val / 1000000000;
									return val.toFixed(2) +" PH/s"
								}
								if(val> 1000000){
									val = val / 0000000;
									return val.toFixed(2) +" TH/s"
								}
								if(val> 1000){
									val = val / 1000;
									return val.toFixed(2) +" GH/s"
								}
								if(val> 1){
									val = val / 1;
									return val.toFixed(2) +" MH/s"
								}
								if(val> 0.001){
									val = val / 0.001;
									return val.toFixed(2) +" KH/s"
								}else {
									val = val / 0.000001;
									return val.toFixed(2) +" H/s"
								}
            						},
							offsetX : -10,
							offsetY : 0
						}
					},
					grid : {
            borderColor: "#555555",
						show : true,
						padding : {
							left : 0,
							right : 0
						}
					},
					tooltip : {
						x : {
							format : "dd MMM yyyy"
						},
                        theme : "dark",
					},
					legend : {
						position : 'top',
						horizontalAlign : 'left'
					},
					fill : {
						type : 'gradient',
						gradient : {
							shadeIntensity : 1,
							opacityFrom : 0.5,
							opacityTo : 0,
							stops : [0, 100, 100]
						}
					},
				};
				    
                var chart = new ApexCharts(document.querySelector("#pool_hashrate_results"), options);
				if (!chart.chartRendered || typeof chart.chartRendered != 'undefined') {
					console.log(chart.chartRendered);
            		chart.render().then(() => chart.chartRendered = true);
				}			
}

</script>


end;
