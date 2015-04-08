<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); 



$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
?>
<?php get_template_part('inc/sub-header'); ?>


<section id="" class="">
  <div id="content" role="main">
    <?php if ( have_posts() ) : ?>
    <div class="container">
      <div class="row">
        <?php
			/* Start the Loop */
			$i = 0;
			while ( have_posts() ) : the_post();
			 ?>
     <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php 
			 renderRegularCard($i, $post);
			$i++; 
			?>
        <!--last-->
    	
   
	 <?php 
		 wp_reset_query();  
		endwhile; ?>
        <?php else : ?>
        <?php //get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>
        </div>
      </div>
      <!--closeMITcontainer--> 
    </div>
    <!--closes row-->
    
     <?php get_template_part('inc/more-posts'); ?>
  </div>
  <!-- #content --> 
</section>
<!-- #primary -->
<script>
<?php
if (is_category( )) {
  $cat = get_query_var('cat');
  $yourcat = get_category ($cat);
  $category2 = get_category_by_slug( $yourcat->slug);
  $categoryID2 = $category2->cat_ID;
 }
?>
$(document).ready(function() {
    var offset = 21;
	var limit = 9;
    //$("#postContainer").load("/news/add-posts-category/");
    $("#another").click(function(){
		limit = limit+9;
        offset = offset+21;
        $("#postContainer")
            //.slideUp()
            .load("/news/add-posts-category/?offset="+offset+"&limit="+limit+"&categoryID="+<?php echo $categoryID2; ?>+"", function() {
			 //.load("/news/test/?offset="+offset, function() {
			   $(this).slideDown();
			   
			
			   $('#another').click(function() {
			  // alert($j(this).load());
       });
			   
    	});
    	
    
            
        return false;
    });

});
</script>

<div class="container">
<?php get_footer(); ?>