<script type="text/javascript">
var likes_top = [];
var posts_full = [];
<?php
	$from = null;
	$daysCount = 7;
	$dayLabel = array();

	$data = $db->getTopLikedPostFrom($from, $daysCount);
	
	foreach($data as $post){
		?>
		likes_top.push(parseInt('<?php echo $post->count; ?>'));
      posts_full.push('<?php echo $post->post_title; ?>');
		<?php
	}

?>


var chart1;
jQuery(document).ready(function() {
      chart1 = new Highcharts.Chart({
         chart: {
            renderTo: 'container-top',
            type: 'bar'
         },
         title: {
            text: ''
         },
         xAxis: {
         	labels : {
         		align: 'right',
         		rotation: -60,
               formatter: function(){
                  if(this.value){
                     if(this.value.length > 10){
                        return this.value.substr(0, 9) + '...';
                     }else{
                        return this.value;
                     }
                  }
               }
         	},
            categories: posts_full
         },
         yAxis: {
            title: {
               text: 'Likes',
               style: {
            		color: '#3E3E3E'
            	}
            }
         },
         tooltip: {
            formatter: function() {
                return ''+
                    this.x + ' - ' +
                    this.series.name +': '+ this.y;
            }
         },
         series: [{
         	name: 'likes',
            data: likes_top,
            color: '#3E3E3E'
         }]
      });
   });
</script>

<div id="container-top" class="kkadmin-small-chart"></div>
				