<?php
/**
 * The template for displaying Archive pages.
 * also bibliotech cat pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); 
$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
get_template_part('inc/sub-header'); 
if((get_post_type( get_the_ID() ) == 'bibliotech') || (cat_is_ancestor_of(73, $cat) or is_category(73))){  
 get_template_part('inc/bib-header'); 
 } ?>
<section id="" class="site-content">
  <div id="content" role="main">
    <?php if ( have_posts() ) : ?>
    <div class="container">
    <div class="row">
   <?php 
	  $i = -1;	
	 	while ( have_posts() ) : the_post();
	  	$i++; ?>
     <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php  renderRegularCard($i, $post);
    endwhile;
	endif;  
	wp_reset_query();  // Restore global post data stomped by the_post(). ?> 
   </div>
    <!-- MITContainer --> 
    </div><!--closes row-->
  </div>
  <!-- #content --> 
</section>
<!-- #primary -->
<?php  
 if($i  > 7){ 
	get_template_part('inc/more-posts');   
	}  
	?>   
</div>
<!-- wrap --> 
<script>
$(document).ready(function() {
    var offset = 11;
	var limit = 9;
    //$("#postContainer").load("/news/add-bibliotech-posts/");
    $("#another").click(function(){
		limit = limit+9;
        offset = offset+11;
        $("#postContainer")
            //.slideUp()
            .load("/news/more-archives/?offset="+offset+"&limit="+limit, function() {
			 //.load("/news/test/?offset="+offset, function() {
			   $(this).slideDown();
		});
            
        return false;
    });
});
</script>
<div class="container">
<?php get_footer(); ?>