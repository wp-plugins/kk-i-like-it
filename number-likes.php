<script type="text/javascript">
var likes = [];
var dates = [];
var dayLabel = [];
<?php
	$from = null;
	$daysCount = 7;
	$dayLabel = array();

	$data = $db->getTopLikesFrom($from, $daysCount);
	
	if(empty($from)){
		$from = time();
	}else{
		$from = strtotime($from);
	}

	$days = array();
	
	foreach ($data as $day) {
		$days[date('d-m-Y', strtotime($day->date))] = $day->count;
	}
	
	for($i = 0; $i < $daysCount; $i++){
		
		if($i == 0){
			if(!empty($days[date("d-m-Y", $from)])){
				?> likes.push(parseInt('<?php echo $days[date("d-m-Y", $from)]; ?>')); <?php
			}else{
				?> likes.push(0); <?php
			}
?>
			dayLabel.push('<?php echo date("d-m-Y", $from); ?>');
<?php
		}else{
			if(!empty($days[date("d-m-Y", $from - ($i * 24 * 3600))])){
				?> likes.push(parseInt('<?php echo $days[date("d-m-Y", $from - ($i * 24 * 3600))]; ?>')); <?php
			}else{
				?> likes.push(0); <?php
			}
?>
			dayLabel.push('<?php echo date("d-m-Y", $from - ($i * 24 * 3600)); ?>');
<?php
		}
	}

?>

var chart1;
jQuery(document).ready(function() {
      chart1 = jQuery.jqplot('container', [likes], {
      	seriesColors : ["#3E3E3E"],
      	seriesDefaults:{
            renderer: jQuery.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            shadow: false
        },
        series:[
            {label:'Likes'}
        ],
        axesDefaults: {
	        tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer ,
	        tickOptions: {
	          angle: -30,
	          fontSize: '7pt'
	        }
        },
        axes: {
            xaxis: {
                renderer: jQuery.jqplot.CategoryAxisRenderer,
                ticks: dayLabel
            },
            yaxis: {
	            
	        },
        },
        grid: {
        	background: '#ffffff',
        	shadow: false,
        	borderWidth: 1.0
        }
      });
});
</script>

<div id="container" class="kkadmin-small-chart"></div>
				