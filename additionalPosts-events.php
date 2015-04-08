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
    /*
        Template Name: Additional Posts Events
    */
    $offset = htmlspecialchars(trim($_GET['offset']));
    if ($offset == '') {
        $offset = 11;
    }
	
	 $limit = htmlspecialchars(trim($_GET['limit']));
    
	if ($limit == '') {
        $limit = 18;
    }	
?>
<?php
$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
$args = array(

  'posts_per_page' => $limit,
  'ignore_sticky_posts' => true,
  'offset' => 9,

  'post_type' => 'post',
  'meta_query' => array(
    array(
      'key' => 'is_event',
      'value' => '1',
      'compare' => '=',
    ),
    array(
      'key' => 'event_date',
      'value' => date("Y-m-d"),
      'compare' => '<',
      'type' => 'DATE'
    ),
  ),

  'meta_key' => 'event_date',
  'orderby' => array(
    'meta_value_num' => 'DESC',
  ),

);

$archive = array(

  'posts_per_page' => 9,
  'ignore_sticky_posts' => true,

  'post_type' => 'post',
  'tag' => 'oldevents',

  'orderby' => 'post_date',

);

/*
$args = array(
  'post_type'              => 'post',
  'posts_per_page'         =>	$limit,
  'offset'                 => 9,
  'ignore_sticky_posts'    => true,
  'meta_key'               => 'event_date',
  'orderby'                => array(
    'meta_value_num'     => 'DESC',
    'date'               => 'DESC',
  ),
  'meta_query'             => array(

    array(
      'key'              => 'is_event',
      'value'            => '1',
      'compare'          => '='
    ),

  ),
);
*/

$the_query = new WP_Query($args); 

// Need to handle switch to archived posts

//removes button start
$ajaxLength = $the_query->post_count;

if ($ajaxLength < $limit){ 
?>
<script>
$("#another").hide();
</script>
<?php 
}
//removes button end 


if( $the_query->have_posts() ):  
  $o = -1;	
  while ( $the_query->have_posts() )   : $the_query->the_post(); 
    $o++;
    renderEventCard($o, $post);
  endwhile; 
endif;  

wp_reset_query();  // Restore global post data stomped by the_post(). 

?>