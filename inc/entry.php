

<?php

if($post->post_type == 'spotlights') {
   
}else{
?>

<div class="excerpt-post">

           <?php 
		   $myContent = $post->post_content;
		   $myContent = preg_replace('/\[.+\]/','', $myContent);
		   $myContent = str_replace(']]>', ']]&gt;', $myContent);
		   $myContent =  strip_tags($myContent);
		   $mitlistImg = get_field("listImg");
		   $myContent = strip_tags($myContent);
		   $myTitle = get_the_title();
		   $myDate = get_field('event_date');
		   $mySubtitle = get_field('subtitle');
if($mySubtitle){ ?>
		<h4 class="subT">	 <?php 
		
		if(strlen($mySubtitle) > 40){
			
			  $stringCut = substr($mySubtitle, 0, 40);
			  
			   $mySubtitle = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
			   echo $mySubtitle;
			}else{
				echo $mySubtitle;
				}
		
		
		
		?> </h4>
		
        
        
        
        
        <p class="entry-summary">	
			
	<?php		
			
			if (((strlen($myTitle) <=50) && ($mitlistImg != '') && ($myDate))){

    // truncate string
    echo "**";
    $stringCut = substr($myContent, 0, 40);
	$myContent = "";
	
    // make sure it ends in a word so assassinate doesn't become ass...
    $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}elseif (((strlen($myTitle) >=50) && ($mitlistImg != '') && ($myDate))){

    // truncate string
    echo "!!";
    //$stringCut = substr($myContent, 0, 10);
    $myContent = "";
	

    // make sure it ends in a word so assassinate doesn't become ass...
    
}elseif ((strlen($myTitle) <=50) && ($mitlistImg != '')){

    // truncate string
	echo "+50 img";
    $stringCut = substr($myContent, 0, 90);
	

    // make sure it ends in a word so assassinate doesn't become ass...
    $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}elseif(((strlen($myTitle) >=51) && ($mitlistImg != ''))) {
	echo "+51img";;
	 $stringCut = substr($myContent, 0, 40);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	

	}elseif(strlen($myTitle) >=54) {
	 echo "+54";
	 $stringCut = substr($myContent, 0, 50);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	
	
	}elseif(strlen($myTitle) <=55) {
	 echo "-54";
	 $stringCut = substr($myContent, 0, 140);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	
	}
			
			
	?>		
			
			
			
			
			
			
			
			
			
			
			
			<?php	}else{ ?>




<p class="entry-summary">




<?php
//no subtitle
if (((strlen($myTitle) <=50) && ($mitlistImg != '') && ($myDate))){

    // truncate string
    //echo "**";
    $stringCut = substr($myContent, 0, 40);
	

    // make sure it ends in a word so assassinate doesn't become ass...
    $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}elseif (((strlen($myTitle) >=50) && ($mitlistImg != '') && ($myDate))){

    // truncate string
   echo "!!";
    //$stringCut = substr($myContent, 0, 10);
    $myContent = "";
	

    // make sure it ends in a word so assassinate doesn't become ass...
    
}elseif ((strlen($myTitle) <=50) && ($mitlistImg != '')){

    // truncate string
    $stringCut = substr($myContent, 0, 90);
	

    // make sure it ends in a word so assassinate doesn't become ass...
    $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
}elseif(((strlen($myTitle) >=51) && ($mitlistImg != ''))) {
	 
	 $stringCut = substr($myContent, 0, 40);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	

	}elseif(strlen($myTitle) >=54) {
	 
	 $stringCut = substr($myContent, 0, 150);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	
	
	}elseif(strlen($myTitle) <=55) {
	 
	 $stringCut = substr($myContent, 0, 150);
	 $myContent = substr($stringCut, 0, strrpos($stringCut, ' ')).'...'; 
	
	}
	}
echo $myContent;
		  
?>
</p>
</div>

<?php } ?>