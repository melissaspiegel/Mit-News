<?php
    /*
        Template Name: Additional Posts Archives
    */
?>
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
	 
 
		
		
		
		    $offset = htmlspecialchars(trim($_GET['offset']));
    if ($offset == '') {
        $offset = 10;
    }
	
	 $limit = htmlspecialchars(trim($_GET['limit']));
    if ($limit == '') {
        $limit = 9;
    }
    
    
	
	$args = array(
	 	'post_type' => array('bibliotech' ),
	 	'post__not_in'   => array( 'sticky_posts'),
	 	'ignore_sticky_posts' => 1,
		'offset'          => 10,
		'posts_per_page'  => $limit,
		'order'                  => 'DESC',
		'orderby'                => 'date',
		'suppress_filters' => false
				
		
);			
 $the_query = new WP_Query($args); 	


?>
  <div class="row">
  
  
 <?php
//removes button start
$ajaxLength = $the_query->post_count;
?>
<?php if ($ajaxLength < $limit){ ?>
<script>
$("#another").hide();
</script>


<?php } 
//removes button end 
if( $the_query->have_posts() ):  
$i = 0;		
while ( $the_query->have_posts() ) : $the_query->the_post(); 
 ?>
     <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php 
 renderRegularCard($i, $post);
$theLength = $my_query->post_count;	
$i++; 
endwhile;
endif;
wp_reset_query();  // Restore global post data stomped by the_post(). ?>
</div>