<?php
/*
Template Name:Bibliotech 
*/
$pageRoot = getRoot($post);
$section = get_post($pageRoot);
$isRoot = $section->ID == $post->ID;
get_header(); ?>
<?php get_template_part('inc/sub-header'); ?>
<?php get_template_part('inc/bib-header'); ?>

<div class="container">
<div class="row">
<?php 
$sticky = get_option( 'sticky_posts' );
$args = array(
	'posts_per_page'      => 1,
	'post__in'            => $sticky,
	'ignore_sticky_posts' => 1,
	'post_type' => 'bibliotech',
	'order'                  => 'DESC',
	'orderby'                => 'date',
	'suppress_filters' => false
);
$query2 = new WP_Query( $args );
if( $query2->have_posts() ):  
while ( $query2->have_posts() ) : $query2->the_post(); ?>
<?php if ( isset($sticky[0]) ) { ?>
<!-- ////////////////////////ONLY VISIBLE ON MOBILE\\\\\\\\\\\\\\\\\\\\ -->
<div class="visible-xs visible-sm hidden-md hidden-lg col-xs-B-6 col-sm-4 col-md-4 col-lg-4 padding-right-mobile">
   <?php renderRegularCard($i, $post); ?>
<!-- ////////////////////////END ONLY VISIBLE ON MOBILE\\\\\\\\\\\\\\\\\\\\ -->
<div class="sticky  hidden-xs hidden-sm col-md-12 clearfix">
<?php  renderFeatureCard($i, $post); ?>
<?php wp_reset_postdata(); ?>
<?php wp_reset_query(); ?>
<?php  } ?>
<?php endwhile; ?>
<?php endif; ?>

<?php	 
$bibliotechs = array(
			'posts_per_page'      => 9,
			'post__not_in'        => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
			'post_type'       	  => 'bibliotech',
			'orderby'        	  => 'date',
			'order'          	  => 'DESC',
			'suppress_filters'    => false
			);

$bibloQuery = new WP_Query($bibliotechs);	
//print_r($the_query);
$bilbio = (array) $bibloQuery ->posts;
 //$theLength = $count_posts->publish;
      if( count($bilbio) > 0 ) {
        $i = 2;
        foreach ($bilbio as $post) {
			
        $i++;
		?>
      <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php renderRegularCard($i, $post); 
	} 
		//echo $i;
      }
      ?>

  </div>
  <!--closeMITContainer-->
  <?php
 if($i >=11){ 
 get_template_part('inc/more-posts');   
	} ?> 
</div>
<!-- wrap --> 
<script>
$(document).ready(function() {
    var offset = 10;
	var limit = 9;
    $("#another").click(function(){
		limit = limit+9;
        offset = offset+10;
        $("#postContainer")
            .load("/news/add-bibliotech-posts/?offset="+offset+"&limit="+limit, function() {
			   $(this).slideDown();
			   
				
				
			   
    	});
    	
    
            
        return false;
    });

});
</script>
<div class="container">
<?php get_footer(); ?>