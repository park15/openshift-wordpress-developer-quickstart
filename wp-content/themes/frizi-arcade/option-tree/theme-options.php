<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'admin_init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet */
  if ( ! function_exists( 'ot_settings_id' ) )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'general',
        'title'       => __( 'General', 'frizi-arcade' )
      ),
      array(
        'id'          => 'style',
        'title'       => __( 'Style', 'frizi-arcade' )
      ),
     /* array(
        'id'          => 'home_page',
        'title'       => __( 'Home Page', 'frizi-arcade' )
      ),*/
      array(
        'id'          => 'google',
        'title'       => __( 'Google', 'frizi-arcade' )
      ),
      array(
        'id'          => 'ads',
        'title'       => __( 'Ads', 'frizi-arcade' )
      ),
      array(
        'id'          => 'social_networks',
        'title'       => __( 'Social networks', 'frizi-arcade' )
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'logo_image',
        'label'       => __( 'Logo image', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => 'ot-upload-attachment-id',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'favicon',
        'label'       => __( 'Favicon', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'home_featured_thumbs',
        'label'       => __( 'Show featured thumbs on home page', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'maximum_days_for_new_games',
        'label'       => __( 'Maximum days for new games', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'show_rating',
        'label'       => __( 'Show game rating', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'off',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ), 
      array(
        'id'          => 'show_game_preloader',
        'label'       => __( 'Show game preloader', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
       array(
        'id'          => 'lights_switch',
        'label'       => __( 'Show lights on-off switch', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ), 
        array(
        'id'          => 'singleadds',
        'label'       => __( 'Single page ads', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'left',
        'type'        => 'radio',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'left',
            'label'       => __( 'Left', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'right',
            'label'       => __( 'Right', 'frizi-arcade' ),
            'src'         => ''
          )
        )
      ),
         array(
        'id'          => 'how_to_play',
        'label'       => __( 'Show how to play', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         array(
        'id'          => 'how_to_play_auto',
        'label'       => __( 'Auto show how to play', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'custom_how_to_play_code',
        'label'       => __( 'Custom how to play code', 'frizi-arcade' ),
        'desc'        => 'If you want to use custom code for how to play section paste it here. Allowed tag is ##game_name##. Leave blank for default.',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'defmenu',
        'label'       => __( 'Use builtin menu', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'homemenu',
        'label'       => __( 'Show home link in menu', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'categoriesmenu',
        'label'       => __( 'Show categories dropdown in menu', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'sharelink',
        'label'       => __( 'Show share link in menu', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
        array(
        'id'          => 'contactus',
        'label'       => __( 'Show contact us thumb in footer', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'on',
        'type'        => 'on-off',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'custom_rss_feed_url',
        'label'       => __( 'Custom Rss Feed url', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'comments',
        'label'       => __( 'Comments', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => 'normal',
        'type'        => 'radio',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'normal',
            'label'       => __( 'Normal', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'facebook',
            'label'       => __( 'Facebook', 'frizi-arcade' ),
            'src'         => ''
          )
        )
      ),
      
      array(
        'id'          => 'custom_head_code',
        'label'       => __( 'Custom head code', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      /*array(
        'id'          => 'background_style',
        'label'       => __( 'Background', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'light',
            'label'       => __( 'Light', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'dark',
            'label'       => __( 'Dark', 'frizi-arcade' ),
            'src'         => ''
          )
        )
      ),*/
      array(
        'id'          => 'color_style',
        'label'       => __( 'Color', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'select',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'choices'     => array( 
          array(
            'value'       => 'blue',
            'label'       => __( 'Blue', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'green',
            'label'       => __( 'Green', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'orange',
            'label'       => __( 'Orange', 'frizi-arcade' ),
            'src'         => ''
          ),
          array(
            'value'       => 'pink',
            'label'       => __( 'Pink', 'frizi-arcade' ),
            'src'         => ''
          ),
           array(
            'value'       => 'purple',
            'label'       => __( 'Purple', 'frizi-arcade' ),
            'src'         => ''
          ),
           array(
            'value'       => 'red',
            'label'       => __( 'Red', 'frizi-arcade' ),
            'src'         => ''
          )    
            
        )
      ),
       
      array(
        'id'          => 'custom_css',
        'label'       => __( 'Custom css', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'style',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
     
      array(
        'id'          => 'google_analytics_code',
        'label'       => __( 'Google analytics code', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'google',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'big_ad_code_',
        'label'       => __( 'Big ad code', 'frizi-arcade' ),
        'desc'        => __( '728x90. If you use adsense, we STRONGLY recommend to use responsive ad unit!', 'frizi-arcade' ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ads',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),   
      array(
        'id'          => 'rectangular_ad_code_',
        'label'       => __( 'Rectangular ad code', 'frizi-arcade' ),
        'desc'        => __( '300x250', 'frizi-arcade' ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ads',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         array(
        'id'          => 'full_screen_top_code_',
        'label'       => __( 'Fullscreen top ad code', 'frizi-arcade' ),
        'desc'        => __( '', 'frizi-arcade' ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ads',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
         array(
        'id'          => 'full_screen_bottom_code_',
        'label'       => __( 'Fullscreen bottom ad code', 'frizi-arcade' ),
        'desc'        => __( '', 'frizi-arcade' ),
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'ads',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'facebook_fan_page_url',
        'label'       => __( 'Facebook fan page url', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_networks',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'facebook_application_id_',
        'label'       => __( 'Facebook application id', 'frizi-arcade' ),
        'desc'        => __( 'needed for comments', 'frizi-arcade' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_networks',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'twitter_url',
        'label'       => __( 'Twitter url', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_networks',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'share_image',
        'label'       => __( 'Facebook Share Image', 'frizi-arcade' ),
        'desc'        => __( 'This image will be shown on facebook when people share/like/comment on your site. Games will always have game thumbnail as shared image so this is just in case when people share homepage/categories/tags/search results etc.', 'frizi-arcade' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social_networks',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'condition'   => '',
        'operator'    => 'and',
        'type'        => 'upload',
        'class'       => 'ot-upload-attachment-id',
      ),
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
      
    update_option( ot_settings_id(), $custom_settings ); 
   
  }
  
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}