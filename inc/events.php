 <!--/EVENT  DATE-->
          <?php if(get_field('event_date')){ 
				$date = DateTime::createFromFormat('Ymd', get_field('event_date'));
				
			?>
          
          
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
          <?php 	}	?>
          <!--EVENT --> 