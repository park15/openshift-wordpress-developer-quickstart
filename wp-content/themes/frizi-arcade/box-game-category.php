<?php
/**
 * The template for displaying most played games.
 *
 * @package games
 */

global $boxTimeRange; ?>
<div class="block1 group">
      <div class="header">
        <h3><?php _e('Most Played', 'frizi-arcade') ?></h3>
        <div class="header-bar"><a href="#" class="back">&lt;</a> <a href="#" class="next">&gt;</a><a href="#" class="show-all"><?php _e('SHOW All','frizi-arcade') ?></a></div>
      </div>
	<div id="most_played_games" class="thumbs-small-wrap ">
 
     <div class="small-thumbs-wrap"  
     	data-action="juego_ajax_load_mostplayed"
         data-path="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php"
         data-page="1"
         data-display-posts="8"
         data-range="<?php echo $boxTimeRange; ?>">
	        <div class="small-thumbs">
	           <?php if (function_exists('wpp_get_mostpopular') && function_exists('get_most_played_games')) {
	            $args = array('paged' => 1, 'limit' => 8, 'range' => $boxTimeRange);
	            get_most_played_games($args);
	        }
	        ?>
	       	</div>
	    </div>
	</div>
</div>	
