<?php  
$pageRoot = getRoot($post);$section = get_post($pageRoot);$isRoot = $section->ID == $post->ID; get_header(); get_template_part('inc/sub-header');
$sticky = get_option( 'sticky_posts' );
?>
<div class="container">
<div class="row">
<?php
$args = array(
	'posts_per_page'      => 1,
	'post__in'            => $sticky,
	'ignore_sticky_posts' => 1,
	'orderby'   	=> 'menu_order',
	'order'     	=> 'DESC',
	'suppress_filters' => false
);

$mobileNews = new WP_Query($args) ;
$mn = (array) $mobileNews->posts;
if ( isset($sticky[0]) ) { ?>
<!-- ////////////////////////ONLY VISIBLE ON MOBILE\\\\\\\\\\\\\\\\\\\\ -->
      <?php
      if( count($mn) > 0 ) {
        $i = -1;
        foreach ($mn as $m) {
          $i++; ?>
<div class="visible-xs visible-sm hidden-md hidden-lg col-xs-B-6 col-sm-4 col-md-4 col-lg-4 padding-right-mobile">
   <?php renderRegularCard($i, $post); ?>
    
    <?php    } 
      }
      ?>
<!-- ////////////////////////END END ONLY VISIBLE ON MOBILE\\\\\\\\\\\\\\\\\\\\ -->
<div class="sticky  hidden-xs hidden-sm col-md-12 clearfix">
<?php  renderFeatureCard($i, $post); ?>
 <!--closes the entire first sitcky container--> 
 <?php wp_reset_postdata(); ?>
  <?php wp_reset_query(); ?>
<?php  } ?>
<div class="news-site">
  <?php
$args = array(
	'posts_per_page'      => 9,
	'post_type' => array('spotlights','bibliotech', 'post'),
	'post__not_in'            => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1,
	'orderby'   	=> 'post_date',
	'order'     	=> 'DESC',
	'suppress_filters' => false
	
);
$the_query = new WP_Query( $args );	
//print_r($the_query);

$allNews = (array) $the_query->posts;
 //$theLength = $count_posts->publish;
      if( count($allNews) > 0 ) {
        $i = 2;
        foreach ($allNews as $post) {
        $i++; ?>
        <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
        <?php
         renderRegularCard($i, $post);
        } 
		//echo $i;
      }
      ?>
  </div>
<?php  if($i > 6){ 
 get_template_part('inc/more-posts'); 
 } ?>
  </div><!--close row-->
  </div><!--close container-->

<script>
$(document).ready(function() {
    var offset = 9;
	var limit = 9;
    $("#postContainer").load("/news/test/");
    $("#another").click(function(){
		limit = limit+9;
        offset = offset+9;
        $("#postContainer")
            //.slideUp()
            .load("/news/test/?offset="+offset+"&limit="+limit, function() {
			 //.load("/news/test/?offset="+offset, function() {
			   $(this).slideDown();
			 	
			   
    	});
            
        return false;
    });

});

</script>
<div class="container">
<?php 
	get_footer();
?>