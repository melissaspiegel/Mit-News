<script type="text/javascript">
$(document).ready(function() {
  $("img.img-responsive").lazyload({ 
    effect : "fadeIn", 
    effectspeed: 450 ,
	failure_limit: 999999
  }); 
});	
</script>
<?php
$date = DateTime::createFromFormat('Ymd', get_field('event_date'));

?>
<?php
    /*
        Template Name: Additional Posts
    */
    $offset = htmlspecialchars(trim($_GET['offset']));
    if ($offset == '') {
        $offset = 9;
    }
	
	 $limit = htmlspecialchars(trim($_GET['limit']));
    if ($limit == '') {
        $limit = 9;
    }
	
	
	$args = array(
	'posts_per_page'      => $limit,
	'post_type' => array('Spotlights','bibliotech', 'post'),
	'offset'  			  => 9,
	'post__not_in'            => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1,
	'orderby'   	=> 'date',
	'order'     	=> 'DESC',
	'suppress_filters' => false

);
$the_query = new WP_Query($args); 
//removes button start
$ajaxLength = $the_query->post_count;
if ($ajaxLength < $limit){ ?>
<script>
$("#another").hide();
</script>
<?php } 
//removes button end 
if( $the_query->have_posts() ):  
  $o = -1;	
  while ( $the_query->have_posts() )   : $the_query->the_post(); 
    $o++; ?>
     <div id="theBox" class= "<?php if ($o % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php 
    renderRegularCard($o, $post);
  endwhile; 
endif;  
wp_reset_query();  // Restore global post data stomped by the_post(). ?>      