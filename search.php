<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php get_template_part('inc/sub-header'); ?>




<div id="primary" class="content-area">
  <main id="main" class="content-main" role="main">
    <div class="container">
    <div class="row">
    
    <h2 class="search">Search results for <strong><?php echo $_GET['s'] ?></strong></h2>
   		
     <?php  if($post == ""){ ?>
		
		
		
	 <?php	echo "<p class='search'>". "Sorry, we didn't find anything matching your search. Please try a different search term." . "</p>" ; ?>
		
		
	
	
	<?php	} ?>
        
 
        
      <?php 
	 

//	  
		
	 $i = 2;	
 	 while ( have_posts() ) : the_post(); 
    $i++;
	 ?>
     <div id="theBox" class= "<?php if ($i % 3 == 0) echo "third"; ?> padding-right-mobile col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4">
    <?php 

    renderRegularCard($i, $post);
  	endwhile;  
	wp_reset_query();  // Restore global post data stomped by the_post(). ?>      
	  
      <!--//////////// -->
      <!--last-->
    </div>
 
      
      <!--//////////// -->
    
    </div> <!--closeFLexContainer--> 
    </div><!--closes row-->

<?php

if($i >= 11){ 
get_template_part('inc/more-posts');   
} ?> 
 </main>
  <!-- #main --> 
  
</div>
<script type="text/javascript">
$(document).ready(function() {
    var offset = 11;
	var limit = 9;
	var car = "<?php echo $_GET['s'] ?>";
	var car = encodeURIComponent(car);
   // $("#postContainer").load("/news/search-results/");
    $("#another").click(function(){
		limit = limit+9;
        offset = offset+11;
        $("#postContainer")
            //.slideUp()
            .load("/news/search-results/?offset="+offset+"&limit="+limit+"&search="+car, function() {
			 //.load("/news/test/?offset="+offset, function() {
			   $(this).slideDown();
			 	
			   
    	});
            
        return false;
    });

});
</script>

<!-- #primary -->
 <div class="container">
<?php get_footer(); ?>