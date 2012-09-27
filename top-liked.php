<script type="text/javascript">
var likes_top = [];
var posts_full = [];
var posts = [];
<?php
	$from = null;
	$daysCount = 7;
	$dayLabel = array();

	$data = $db->getTopLikedPostFrom($from, $daysCount);
	
	foreach($data as $post){
		?>
		likes_top.push(parseInt('<?php echo $post->count; ?>'));
      posts_full.push('<?php echo $post->post_title; ?>');
      posts.push('<?php echo substr($post->post_title, 0, 10) . "..."; ?>');
		<?php
	}

?>


var chart1;
   jQuery(document).ready(function() {
      chart1 = jQuery.jqplot('container-top', [likes_top], {
         seriesColors : ["#3E3E3E"],
         seriesDefaults:{
            renderer: jQuery.jqplot.BarRenderer,
            rendererOptions: {fillToZero: true},
            rendererOptions: {
                barDirection: 'horizontal'
            },
            shadow: false
        },
        series:[
            {label:'Likes'}
        ],
        axes: {
            yaxis: {
                renderer: jQuery.jqplot.CategoryAxisRenderer,
                ticks: posts
            }
        },
        grid: {
        	background: '#ffffff',
        	shadow: false,
        	borderWidth: 1.0
        }
      });
   });
</script>

<div id="container-top" class="kkadmin-small-chart"></div>
				