<?php 
class objSorter 
{ 
var $property; 
var $sorted; 

    function ObjSorter($objects_array,$property=null) 
        { 
            $sample    = $objects_array[0]; 
            $vars    = get_object_vars($sample); 

        if (isset($property)) 
            { 
            if (isset($sample->$property)) 
// make sure requested property is correct for the object 
                {    
                $this->property = $property; 
                usort($objects_array, array($this,'_compare')); 
                } 
            else 
                {    
                $this->sorted    = false; 
                return;    
                } 
            } 
        else 
            {    
                list($property,$var)     = each($sample); 
                $this->property         = $property; 
                usort($objects_array, array($this,'_compare')); 
            } 

        $this->sorted    = ($objects_array); 
        } 

    function _compare($apple, $orange) 
        { 
        $property    = $this->property; 
        if ($apple->$property == $orange->$property) return 0; 
        return ($apple->$property < $orange->$property) ? -1 : 1; 
        } 
} // end class 
?>

<script type="text/javascript">
var likes_top = [];
var posts_full = [];
var posts = [];
<?php
	$from = null;
	$daysCount = 7;
	$dayLabel = array();

	$objects = new ObjSorter($db->getTopLikedPostFrom($from, $daysCount));

  $data = $objects->sorted;
	
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
				