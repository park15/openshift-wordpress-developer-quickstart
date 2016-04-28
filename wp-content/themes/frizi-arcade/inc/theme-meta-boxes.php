<?php
/**
 * Meta boxes for theme settings page
 *
 * @package sweetsunday
 * @since sweetsunday 1.0
 * 
 */


if ( ! defined( 'ABSPATH' ) ) exit;




/*-----------------------------------------------------------------------------------*/
/*  Adds a meta box to the post/page editing screen */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'games_custom_meta' ) ) {
	function games_custom_meta() {
		global $game_post_type;
		global $post;
		if (function_exists('get_game') && (isset($post->ID) && get_post_meta($post->ID,'mabp_game_uuid',true) != FALSE))  return;
		add_meta_box('Game-info', __( 'Game info', 'frizi-arcade' ), 'game_meta_callback', $game_post_type);
		
	} 
}
add_action('add_meta_boxes', 'games_custom_meta');


/*-----------------------------------------------------------------------------------*/
/*  Adds wp admin scripts */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'prospekt_admin_scripts' ) ) {
	function prospekt_admin_scripts() {
		global $typenow,$game_post_type;
		
	    if( $typenow == $game_post_type	) {
      	    wp_enqueue_media();
			
			wp_enqueue_style('games-admin', get_template_directory_uri() . '/inc/css/admin-styles.css');
			
			//file
			wp_register_script( 'meta-box-file',get_stylesheet_directory_uri() . '/inc/js/file-upload.js', array( 'jquery' ) );
	        wp_localize_script( 'meta-box-file', 'meta_file',
	            array(
	                'title' => __( 'Choose or Upload file', 'frizi-arcade' ),
	                'button' => __( 'Use this file', 'frizi-arcade' ),
	            )
	        );
	        wp_enqueue_script( 'meta-box-file' );
        }
	}
}

add_action('admin_print_scripts', 'prospekt_admin_scripts');

/*-----------------------------------------------------------------------------------*/
/*  Adds games meta box */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'prospekt_layout_meta_callback' ) ) {
	function game_meta_callback( $post ) {
		$stored_meta = get_post_meta( $post->ID );
		if(!isset($stored_meta['mabp_description'][0]))
			$stored_meta['mabp_description'][0] ='';
		if(!isset($stored_meta['mabp_instructions'][0]))
			$stored_meta['mabp_instructions'][0] ='';
		if(!isset($stored_meta['mabp_width'][0]))
			$stored_meta['mabp_width'][0] ='';
		if(!isset($stored_meta['mabp_height'][0]))
			$stored_meta['mabp_height'][0] ='';
		if(!isset($stored_meta['mabp_swf_url'][0]))
			$stored_meta['mabp_swf_url'][0] ='';
        if(!isset($stored_meta['game_code'][0]))
			$stored_meta['game_code'][0] ='';
		?>

		<p>
		    <div class="game-row-content">
		        <label><?php _e('Game description','frizi-arcade'); ?></label><br>
		        <textarea name="mabp_description"  class="meta-full" ><?php echo esc_attr($stored_meta['mabp_description'][0]) ?></textarea>
				
		    </div>
		</p>
		<p>
		    <div class="game-row-content">
		        <label><?php _e('Game instruction','frizi-arcade'); ?></label><br>
		        <textarea name="mabp_instructions"  class="meta-full" ><?php echo esc_attr($stored_meta['mabp_instructions'][0]) ?></textarea>
				
		    </div>
		</p>
         <p>
		    <div class="game-row-content">
		        <label><?php _e('Game code','frizi-arcade'); ?></label><br>
		        <textarea name="game_code"  class="meta-full" ><?php echo esc_attr($stored_meta['game_code'][0]) ?></textarea>
				
		    </div>
		</p>
        <p><h2><?php _e('or','frizi-arcade'); ?></h2></p>
		<p>
		    <div class="game-row-content">
		        <label><?php _e('Game width','frizi-arcade'); ?></label><br>
		        <input type="text" name="mabp_width"  class="meta-full"  value="<?php echo esc_attr($stored_meta['mabp_width'][0]) ?>">
		    </div>
		</p>
		<p>
		    <div class="game-row-content">
		        <label><?php _e('Game height','frizi-arcade'); ?></label><br>
		        <input type="text" name="mabp_height"  class="meta-full"  value="<?php echo esc_attr($stored_meta['mabp_height'][0]) ?>">
		    </div>
		</p>
        
        
		<p>
		    <div class="game-row-content">
		        <label><?php _e('Game file','frizi-arcade'); ?></label><br>
				<input type="text" name="mabp_swf_url"  class="custom_upload_file_val meta-full"  value="<?php echo esc_attr($stored_meta['mabp_swf_url'][0]) ?>">
				<br />
				<input type="button" id="file-image-button" class="custom_upload_file_button" value="<?php _e( 'Choose or Upload file', 'frizi-arcade' )?>" />
				<a class="custom_clear_file_button" href="#"><?php _e('Remove file', 'frizi-arcade')?></a>
				
		    </div>
		</p>
	<?php }
}


/*-----------------------------------------------------------------------------------*/
/*  Saves the custom meta input
/*-----------------------------------------------------------------------------------*/	
if ( ! function_exists( 'game_meta_save' ) ) {
	function game_meta_save( $post_id ) {
		global $post;
		if (function_exists('get_game') && (isset($post->ID) && get_post_meta($post->ID,'mabp_game_uuid',true) != FALSE))  return;
	 
	    // Checks save status
	    $is_autosave = wp_is_post_autosave( $post_id );
	    $is_revision = wp_is_post_revision( $post_id );
	    
	 
	   // Exits script depending on save status
       if ( $is_autosave || $is_revision  ) return;
	 
		
	   
		if( isset( $_POST[ 'mabp_description' ] ) )
			update_post_meta( $post_id, 'mabp_description', $_POST[ 'mabp_description' ] );
		if( isset( $_POST[ 'mabp_instructions' ] ) )
			update_post_meta( $post_id, 'mabp_instructions', $_POST[ 'mabp_instructions' ] );	
		if( isset( $_POST[ 'mabp_width' ] ) )
			update_post_meta( $post_id, 'mabp_width', $_POST[ 'mabp_width' ] );	
		if( isset( $_POST[ 'mabp_height' ] ) )
			update_post_meta( $post_id, 'mabp_height', $_POST[ 'mabp_height' ] );
		if( isset( $_POST[ 'mabp_swf_url' ] ) )
			update_post_meta( $post_id, 'mabp_swf_url', $_POST[ 'mabp_swf_url' ] );
        if( isset( $_POST[ 'game_code' ] ) )
			update_post_meta( $post_id, 'game_code', $_POST[ 'game_code' ] );
		
	}
}
add_action( 'save_post', 'game_meta_save' );