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
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container',
            type: 'column'
         },
         title: {
            text: ''
         },
         xAxis: {
         	labels : {
         		align: 'right',
         		rotation: -45
         	},
            categories: dayLabel
         },
         yAxis: {
            title: {
               text: 'Likes',
               style: {
            		color: '#3E3E3E'
            	}
            }
         },
         series: [{
         	name: 'likes',
            data: likes,
            color: '#3E3E3E'
         }]
      });
   });
</script>

<div id="container" class="kkadmin-small-chart"></div>
				