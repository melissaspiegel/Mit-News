<?php
if ( ! is_admin() ) {
wp_enqueue_style( 'bootstrapCSS', get_stylesheet_directory_uri() . '/css/bootstrap.css', 'false', '', false);
wp_enqueue_style( 'newsmobile', get_stylesheet_directory_uri() . '/css/newsmobile.css', 'false', '', false);
wp_enqueue_script( 'bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js', array( 'jquery' ), '3.3.1', true);

} 

//keep these here
wp_enqueue_script( 'lazyload', get_stylesheet_directory_uri() . '/js/lazyload.js', array( 'jquery' ), '', true);
wp_enqueue_script( 'myScripts', get_stylesheet_directory_uri() . '/js/myScripts.js', array( 'lazyload' ), '', true );

function remove_scripts(){
	wp_deregister_script('tabletop' );
	wp_deregister_script('productionJS');
	wp_deregister_script('underscore');
	wp_deregister_script('lib-hours');
}
add_action( 'wp_enqueue_scripts', 'remove_scripts', 100 ); 


// Remove dashboard menu items
function mitlibnews_remove_dashboard_menu_items() {
	if (!current_user_can('add_users')) {
		remove_menu_page('edit-comments.php');
		remove_menu_page('tools.php');
		remove_menu_page('edit.php?post_type=html_snippet');
	}
}

add_action('admin_menu', 'mitlibnews_remove_dashboard_menu_items');

// Remove unneeded dashboard widgets
function mitlibnews_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quickpress widget
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // Wordpress news
	if (!current_user_can('add_users')) {
		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // "At a glance" widget
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal'); // Activity widget
	}
} 

add_action('do_meta_boxes', 'mitlibnews_remove_dashboard_widgets' );

// Register the custom post types
function mitlibnews_register_news_posts() {
	$supports_default = array(
		'title',
		'editor',
		'thumbnail',
		'excerpt'
	);
	// spotlight
	$labelsFeatures = array(
		'name' => 'Spotlights',
		'singular_name' => 'Spotlight',
		'menu_name' => 'Spotlights',
		'name_admin_bar' => 'Spotlight',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Spotlight - should be about 60 characters',
		'new_item' => 'New Spotlight',
		'edit_item' => 'Edit Spotlight',
		'view_item' => 'View Spotlight',
		'all_items' => 'All Spotlights',
		'search_items' => 'Search Spotlights',
		'parent_item_colon' => 'Parent Spotlights:',
		'not_found' => 'No Spotlights found.',
		'not_found_in_trash' => 'No Spotlights found in Trash.'
	);
	$argsFeatures = array(
		'labels'  => $labelsFeatures,
		'public' => true,
		'menu_position' => 5,
		'supports' => array('title'),
		'taxonomies' => array('category')
		
	);
	register_post_type('spotlights', $argsFeatures);
	
		
add_filter('apto_object_taxonomies', 'theme_apto_object_taxonomies', 10, 2);
function theme_apto_object_taxonomies($object_taxonomies, $post_type)
    {
        if($post_type == 'spotlight')
            {
                if (array_search('Events', $object_taxonomies) !== FALSE)
                    unset($object_taxonomies[array_search('Events', $object_taxonomies)]);
            }
        return $object_taxonomies;
    }
	
	// Bibliotech
	$labelsFeatures = array(
		'name' => 'Bibliotech',
		'singular_name' => 'Bibliotech',
		'menu_name' => 'Bibliotech',
		'name_admin_bar' => 'Bibliotech',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Bibliotech',
		'new_item' => 'New Bibliotech',
		'edit_item' => 'Edit Bibliotech',
		'view_item' => 'View Bibliotech',
		'all_items' => 'All Bibliotech',
		'search_items' => 'Search Bibliotech',
		'parent_item_colon' => 'Parent Bibliotech:',
		'not_found' => 'No Bibliotech found.',
		'not_found_in_trash' => 'No Bibliotech found in Trash.',
		'taxonomies' => array('category')
		

	);
	$argsFeatures = array(
		'labels'  => $labelsFeatures,
		'public' => true,
		'menu_position' => 5,
		'supports' => $supports_default,
		'taxonomies' => array('category'),
		'capabilities' => array(
        'publish_posts' => 'Admin',
        'edit_posts' => 'Admin',
        'edit_others_posts' => 'Admin',
        'delete_posts' => 'Admin',
        'delete_others_posts' => 'Admin',
        'read_private_posts' => 'Admin',
        'edit_post' => 'Admin',
        'delete_post' => 'Admin',
        'read_post' => 'Admin'
		)
	);
	register_post_type('bibliotech', $argsFeatures);


}	

add_action('init', 'mitlibnews_register_news_posts');

// Disable admin color scheme
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

//custom images for the news
add_theme_support( 'post-thumbnails' );
add_image_size( 'news-home', 111, 206, true ); // Hard Crop Mode
add_image_size( 'news-listing', 323, 111, true ); // Hard Crop Mode
add_image_size( 'news-feature', 657, 256, true ); /// Hard Crop Mode
add_image_size( 'news-single', 451,'651', true ); /// Hard Crop Mode





//allows contributor to upload images
if ( current_user_can('contributor') && !current_user_can('upload_files') )
	add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
}



function init_category($request) {
	$vars = $request->query_vars;
	if (is_category() && !is_category('bibliotech') && !array_key_exists('post_type', $vars)) :
		$vars = array_merge(
			$vars,
			array('post_type' => 'any')
		);
		$request->query_vars = $vars;
	endif;
	return $request;
}
add_filter('pre_get_posts', 'init_category');


//Event RSS feed

add_action('init', 'eventRSS');
function eventRSS(){
        add_feed('event', 'eventRSSFunc');
}

function eventRSSFunc(){
        get_template_part('rss', 'event');
}

////removes plugins tools users
//function remove_menu_items() {
//  global $menu;
//  $restricted = array(__('Links'), __('Comments')/*, __('Media')*/,
//  /*__('Plugins'), __('Tools'),*/ __('Users'));
//  end ($menu);
//  while (prev($menu)){
//    $value = explode(' ',$menu[key($menu)][0]);
//    if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
//      unset($menu[key($menu)]);}
//    }
//  }
//
//add_action('admin_menu', 'remove_menu_items');


function customize_meta_boxes() {
  /* Removes meta boxes from Posts */
 // remove_meta_box('postcustom','post','normal');
  remove_meta_box('trackbacksdiv','post','normal');
  remove_meta_box('commentstatusdiv','post','normal');
  remove_meta_box('commentsdiv','post','normal');
  //remove_meta_box('tagsdiv-post_tag','post','normal');
  remove_meta_box('postexcerpt','post','normal');
   
  /* Removes meta boxes from pages */
 // remove_meta_box('postcustom','page','normal');
  remove_meta_box('trackbacksdiv','page','normal');
  remove_meta_box('commentstatusdiv','page','normal');
  remove_meta_box('commentsdiv','page','normal');  
  
}
add_action('admin_init','customize_meta_boxes');


function custom_favorite_actions($actions) {
  unset($actions['edit-comments.php']);
  return $actions;
}
add_filter('favorite_actions', 'custom_favorite_actions');


function remove_thumbnail_box() {
    remove_meta_box( 'postimagediv','post','side' );
}
add_action('do_meta_boxes', 'remove_thumbnail_box');

//remove parent bibliotech menu
add_action('admin_head', 'removeBiblioSelect');
function registerCustomAdminCss(){
$src = "/wp-content/themes/mit-libraries-news/custom-admin-css.css";
$handle = "customAdminCss";
wp_register_script($handle, $src);
wp_enqueue_style($handle, $src, array(), false, false);
    }
    add_action('admin_head', 'registerCustomAdminCss');
if ( ! function_exists( 'biblio_taxonomy' ) ) {

// Register Custom Taxonomy
function biblio_taxonomy() {

	$labels = array(
		'name'                       => _x( 'bibliotechs', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'bibliotech', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Create issue', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		
	);
	register_taxonomy( 'bibliotech_issues', array( 'bibliotech' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'biblio_taxonomy', 0 );


}

function news_sidebar_widget() {

	register_sidebar( array(
		'name'          => 'subscribe',
		'id'            => 'subscribe',
		'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
		'after_widget' => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'news_sidebar_widget' );


//lets only search posts
function SearchFilter($query) {
if ($query->is_search) {
$query->set('post_type', array('post', 'Bibliotech', 'Spotlights'));
}
return $query;
}

add_filter('pre_get_posts','SearchFilter');

// rendering event cards
function renderEventCard($i, $post) {
?>
  <div class="<?php if ($i % 3 == 0){ echo "third "; } ?> col-xs-12  col-xs-B-6 col-sm-4 col-md-4 eventsPage padding-right-mobile">
    <div itemscope itemtype="http://data-vocabulary.org/Event" class="flex-item blueTop eventsBox <?php if (get_field("listImg")) { echo "has-image";} else { echo "no-image"; } ?>" onClick='location.href="<?php if((get_field("external_link") != "") && $post->post_type == 'spotlights'){ the_field("external_link");}else{ echo get_post_permalink();}  ?>"'>
<?php
if (get_field("listImg") != "" ) { ?>
      <img data-original="<?php the_field("listImg") ?>" width="100%" height="111"  alt="<?php the_title(); ?>" itemprop="photo" class="img-responsive"  />
<?php } ?>
      <h2 itemprop="summary" class="entry-title title-post">
        <a itemprop="url" href="<?php the_permalink(); ?>">
          <?php the_title(); ?>
        </a> 
      </h2>
      <!--/EVENT  DATE-->
<?php            
$date = get_field('event_date');
// $date = 19881123 (23/11/1988)

// extract Y,M,D
$y = substr($date, 0, 4);
$m = substr($date, 4, 2);
$d = substr($date, 6, 2);

// create UNIX
$time = strtotime("{$d}-{$m}-{$y}");
// format date (23/11/1988)

if(get_field('event_date')){  
?>
      <time itemprop="startDate" datetime="<?php  echo date('d/m/Y', $time);  ?>">
        <?php   $date = DateTime::createFromFormat('Ymd', get_field('event_date'));?>
      </time>
              
      <div class="events">
		  <div class="event"> </div>
		  <?php echo $date->format('F j, Y'); 
		 
		   $startTime = get_field('event_start_time'); 
		   $myDash = '&ndash;';
		   $endTime = get_field('event_end_time'); 
		 
		 
		  ?>&nbsp;&nbsp;
          
          <span class="time">
          	
            <?php if(($startTime) && ($endTime)){ 
			  		echo $startTime;
					echo "&ndash;";
					echo $endTime;
							
					}elseif($startTime){ 
			  		
					echo $startTime;
			}  ?>
            </span> 
          
           </div>
<?php   } ?>
      <!--EVENT -->
          
      <div itemprop="description" class="excerpt-post">
      <?php get_template_part('inc/entry'); ?>
      </div>
          
      <div class="category-post">
        <span  itemprop="eventType">
<?php 
$category = get_the_category();     
$rCat = count($category);
$r = rand(0, $rCat -1);
echo '<a title="'.$category[$r]->cat_name.'"  title="'.$category[$r]->cat_name.'" href="'.get_category_link($category[$r]->term_id ).'">'.$category[$r]->cat_name.'</a>';
?>
        </span>

        <span class="mitDate">
          <time class="updated"  datetime="<?php echo get_the_date(); ?>">&nbsp;&nbsp;<?php echo get_the_date(); ?></time>
        </span> 
      </div>
    </div> <!-- close itemscope -->
  </div> <!-- close eventsPage -->
<?php
  };



//////////////////////render REGULAR card	
function renderRegularCard($i, $post){ ?>
	

      
      <div class="flex-item blueTop  eventsBox <?php if (get_field("listImg")) { echo "has-image";} else { echo "no-image"; } ?>" onClick='location.href="<?php if((get_field("external_link") != "") && $post->post_type == 'spotlights'){ the_field("external_link");}else{ echo get_post_permalink();}  ?>"'>
     <?php get_template_part('inc/spotlights'); ?>
        <?php
		if (get_field("listImg") != "" ) { ?>
         <img data-original="<?php the_field("listImg") ?>" width="100%" height="111" class="img-responsive"  alt="<?php the_title();?>"/>
        <?php } ?>
       		<?php if($post->post_type == 'spotlights'){ ?>
				<h2 class="entry-title title-post spotlights">
         			 <a href="<?php the_field("external_link"); ?>"><?php the_title();?></a>
        		</h2> 
				<?php }else{ ?>
        		<h2 class="entry-title title-post">
          			<a href="<?php the_permalink(); ?>"><?php the_title();?></a>
        		</h2>
        		<?php 	} ?>
    	       <?php get_template_part('inc/events'); ?>
         		 <?php if($post->post_type == 'spotlights'){ 
			  	}else{  
			 	 get_template_part('inc/entry');
				}?>
        <!--final **** else-->
        <?php {  ?>
        <!--EVENT -->
        <?php } ?>
        <div class="category-post <?php  if(get_post_type( get_the_ID() ) == 'bibliotech'){ echo "Bibliotech";} ?>">
	<?php 
	
	
  		if(is_page('bibliotech-index') || (is_page_template('additionalPosts-biblio.php')) || (is_category('bibliotech_issues') || (is_tax() ) || is_page_template('additionalPosts-archives.php'))){
	   		echo "<div class='biblioPad'>&nbsp;<a href='/news/bibliotech-index/' title='Bibliotech'>Bibliotech</a></div>"; 
	   }elseif((get_post_type( get_the_ID() ) == 'bibliotech') && (!is_page_template('additionalPosts-biblio.php'))){
	   
	   		echo "<div class='bilbioImg bilbioTechIcon'>
	   		</div>";
	   echo "<div class='biblioPadding'>&nbsp;<a href='/news/bibliotech-index/' title='Bibliotech'>Bibliotech</a>"; ?>
	   
	    <span class="mitDate">
          <time class="updated"  datetime="<?php echo get_the_date(); ?>">&nbsp;&nbsp;<?php echo get_the_date(); ?></time>
          </span> </div> 
	   
	   
	<?php 	  }else{
				$category = get_the_category();     
				$rCat = count($category);
				$r = rand(0, $rCat -1);
				echo '<a title="'.$category[$r]->cat_name.'"  title="'.$category[$r]->cat_name.'" href="'.get_category_link($category[$r]->term_id ).'">'.$category[$r]->cat_name.'</a>'; ?>
	 
          <span class="mitDate">
          <time class="updated"  datetime="<?php echo get_the_date(); ?>">&nbsp;&nbsp;<?php echo get_the_date(); ?></time>
          </span> </div> 
            
        <?php  } ?>
        
       </div><!--last-->
    </div>
    <?php  if(get_post_type( get_the_ID() ) == 'bibliotech'){ ?>
    </div><!--this div closes the open div in biblio padding-->
    <?php } ?>
 
    
    
<?php	} ?>

<?php
//////////////////////render FEATURE card	
function renderFeatureCard($i, $post){ ?>


    <div class="padding-right-mobile sticky col-xs-3 col-xs-B-6 col-sm-8 col-lg-8 col-md-8" onClick='location.href="<?php echo get_post_permalink(); ?>"' style="padding-right:0px;" > <img src="<?php the_field("featuredListImg"); ?>" class="img-responsive" width="679" height="260" alt="<?php the_title();?>" /> </div>
    <div class=" hidden-xs bgWhite col-xs-12 col-xs-B-6 col-sm-4 col-md-4 col-lg-4" onClick='location.href="<?php if((get_field("external_link") != "") && $post->post_type == 'spotlights'){ the_field("external_link");}else{ echo get_post_permalink();}  ?>"'>
      <?php if($post->post_type == 'spotlights'){ ?>
			 <h2 class="entry-title title-post spotlights">
          <a href="<?php the_field("external_link"); ?>"><?php the_title();?></a>
        </h2> 
		<?php }else{ ?>
        <h2 class="entry-title title-post">
         <a href="<?php the_permalink(); ?>"><?php the_title();?></a>
        </h2>
        <?php 	} ?>
    <?php get_template_part('inc/events'); ?>
       <?php if($post->post_type == 'spotlights'){ 
			  	}else{  
			 	 get_template_part('inc/entry');
				}?>
      <div class="category-post">
        <?php 
$category = get_the_category(); 
if($category[0]){
echo '<a title="'.$category[0]->cat_name.'" href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>';
}
?>
 <span class="mitDate">&nbsp;&nbsp;<?php echo get_the_date(); ?></span> 
        <!--echo all the cat --> 
      </div>
    </div>
</div>




<?php } ?>

<?php
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}


?>