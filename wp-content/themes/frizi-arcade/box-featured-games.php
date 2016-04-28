<?php
/**
 * The template for displaying most played games.
 *
 * @package games
 */

global $game_post_type;
?>

            
			<?php $args = array();
			
			
			$args = array(
			  'post_type' 			=> $game_post_type,
			  'posts_per_page' 		=> -1,
			  'meta_key' 			=> '_is_ns_featured_post',
			  'meta_value' 			=> 'yes',
			  'post_status' 			=> 'publish',
			  'ignore_sticky_posts' 	=> true,
			    );
				
				$loop = new WP_Query($args);?>
				
			    <?php 	if ($loop->have_posts()) :?>
                    <div class="slider-wrap"> 
                        <div class="jcarousel-wrapper-wrap">
                              <div class="jcarousel-wrapper">
                                <div class="jcarousel">
                                  <ul>

                                        <?php
                                            while ($loop->have_posts()) : $loop->the_post();
                                                // Include the template for the content.
                                                get_template_part('inc/repeater-list', 'slider');
                                            endwhile;?>
                                                    </ul>
                                </div>
                                <!-- Prev/next controls --> 
                                <a href="#" class="jcarousel-control-prev"></a> <a href="#" class="jcarousel-control-next"></a> 
                            </div>
                        </div>
                    </div>
				<?php endif;
						    				
			?>
	 