<?php 
global $game_post_type , $page;
$features_slider = ot_get_option( 'featured_games_in_header',  'on' ); 
$thumbs_size = ot_get_option( 'thumbs','small' );
?>

<?php if($features_slider != 'off' &&  is_front_page()){?>
		<?php get_template_part('box-featured-games'); ?>
	
<?php } ?>	

<?php $big_ad_code = ot_get_option( 'big_ad_code_' );
if(isset($big_ad_code) &&  !is_single() ) {?>
	<div class="banner"><?php echo $big_ad_code ?></div>
<?php } ?>

<div class="header">
    <h1><span></span><?php _e('New Games','frizi-arcade') ?></h1>
    <div class="sort">
      <div class="sort-icon"></div>
      <div class="sort-wrap" data-page='<?php echo $page ?>' data-action="games_sort" data-nonce="<?php echo wp_create_nonce("games_ajax_load_more_nonce"); ?>"> <span></span>
        <ul>
          <li><a href="#" data-sort="latest" class="active"><?php _e('latest','frizi-arcade') ?></a></li>
          <li><a href="#" data-sort="most-played"><?php _e('most played','frizi-arcade') ?></a></li>
          <li><a href="#" data-sort="top-rated"><?php _e('top rated','frizi-arcade') ?></a></li>
        </ul>
      </div>
    </div>
</div>
<div class="thumbs-wrap group">  
	<div class="thumbs group <?php echo $thumbs_size ?>">
	    <?php
	    
	    // if index reuse main query
	    if (is_home()) {
	        $loop = clone $wp_query;
                if(function_exists('GetPostsCTRIndex')){
                    $loop = GetPostsCTRIndex();
                }
	    } else {
	        $args = array('post_type' => $game_post_type, 'posts_per_page' => 29, 'ignore_sticky_posts' => true);
                if($thumbs_size === 'small'){
                    $args ['posts_per_page'] = 116;   
                }

                    $loop = new WP_Query($args);
	    }
	    $i=0;
        $k=0;
		$inside_content_ad_code = ot_get_option( 'rectangular_ad_code_' );
        
        
		
	    while ($loop->have_posts()) {
	        $loop->the_post();
	        $i++;
	        if ((($i == 5  && $thumbs_size == 'big') or ($i == 21  && $thumbs_size == 'small') ) && !is_single()) {
	            //Paste your ad code here
	            
				if(isset($inside_content_ad_code)) {?>
					<div class="thumb-banner"><?php echo $inside_content_ad_code ?></div>
				<?php } 
					            
	            
	        
	        } 
            if ($thumbs_size == 'small'){
                if ($k == 0){
                    echo '<div  class="thumb game combo">';
                }
                get_template_part('inc/repeater-list', $thumbs_size);
                $k++;
                if ($k == 4){
                    echo '</div>';
                    $k=0;
                }
                
                
            } else {
                // Include the template for the content.
                get_template_part('inc/repeater-list', $thumbs_size);
            }
	        
	        
	    }
		
	    ?>
	   
	    
    
	</div><!-- .thumbs -->
	 <a href="#" class="more"
	    	data-action="games_ajax_load_more"
	    	data-page="1"
	    	data-post_per_page="<?php echo $thumbs_size === 'small' ? '120' : '30' ?>"
	    	data-nonce="<?php echo wp_create_nonce("games_ajax_load_more_nonce"); ?>">
	    	<span></span><?php _e('Show more games', 'frizi-arcade') ?>
	    </a>
</div>	<!-- .thumbs-wrap -->
<div class="main-wrap">
		<?php 
		
		get_template_part('box-mostplayedgames');
		get_template_part('box-bestratedgames');
	    ?>
	    
	  	<div class="block2">
	      <div class="header">
	        <h3>Tag Cloud</h3>
	      </div>
      		<div class="tags">
      			<?php $args = array('taxonomy'  => array('post_tag')); 
	  			wp_tag_cloud($args); ?>
	  		</div>
    	</div><!-- .block2 -->
    <br class="clear">
    <?php if (is_front_page() && ot_get_option( 'list_cat',  'off' ) == 'on') { ?>
	<div class="block3-wrap">
		<div class="block3-in">
			<?php $list_of_categories = ot_get_option( 'list_of_categories' ); 
			if($list_of_categories){
				foreach ($list_of_categories as $key => $category) {
					get_most_played_games_by_cat($category);
				}
			}?>
		</div><!-- .block3-in -->
	</div> <!-- .block3-wrap -->
    <?php } ?>
     <?php if (!is_single()) {?>
    		<div class="banner"><?php echo $big_ad_code ?></div> 	
     <?php } ?>    
	
	 <?php wp_reset_query(); ?>  
	 
	<?php if ( function_exists( 'ot_get_option' ) ) {
  				$facebook_fan_page = ot_get_option( 'facebook_fan_page_url' );
		} ?> 
            
     <?php if (is_front_page()) { ?>        
        <div class="txt-box <?php if (!isset($facebook_fan_page) or empty($facebook_fan_page)  ) echo 'wide' ?>">
            <?php if ($aboutustitle = ot_get_option( 'about_us_title' )){?>
            <div class="header">
                <h3><?php echo $aboutustitle ?></h3>
            </div>	
            <?php }?>
          <?php if ($aboutustext = ot_get_option( 'about_us_text' )){?>
              <div class="txt-box-in">
                  <p><?php echo $aboutustext; ?></p>
              </div>
           <?php }?>   
        </div>
     <?php } ?>        
    <?php if (isset($facebook_fan_page) && !empty($facebook_fan_page)): ?>
        <div class="facebook-box <?php if (!is_front_page()) { echo 'wide'; } ?>">
	    	<div class="fb-like-box" data-href="<?php echo $facebook_fan_page ?>" data-width="600px" data-height="200px" data-colorscheme="<?php echo ot_get_option( 'background_style',  'light' ) ?>" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
	    </div>
	<?php endif; ?>    	    
</div>
<div class="clear"></div>



