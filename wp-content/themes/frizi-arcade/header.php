<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package games
 */
$gameorder  = get_query_var('gameorder',FALSE);
if( $gameorder == FALSE){
    $gameorder = isset($_GET ['gameorder'] ) ? $_GET ['gameorder'] : '';
 }   


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo ot_get_option('facebook_application_id_', '') ?>&version=v2.0";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

        <?php if (ot_get_option('lights_switch', 'on') == 'on') { ?>
            <div class="curtain-wrapper"></div>
<?php } ?>    
        <div class="head">
            
            <div class="center">
                
                    <?php if (ot_get_option('logo_image')) { ?>
                    <h1 class="logo image">
                        <a href="<?php echo esc_url(home_url()) ?>" class="logo-image" title="<?php bloginfo('name') ?>">
                        <?php echo wp_get_attachment_image(ot_get_option('logo_image'), 'medium'); ?>
                        </a>
                    </h1>    
                    <?php } else { ?>
                    <h1 class="logo">
                        <a href="<?php echo esc_url(home_url()) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/star.png" width="57" height="56" alt=""/><?php custom_text_logo() ?></a>
                    </h1>
                    <?php } ?>    
                

                <div class="select-box-wrap">
                    <div class="select-box">
                        <div class="s-icon s-icon1"></div>
                        <div class="select-box-header">
                            <p><?php _e('Categories', 'frizi-arcade') ?></p>
                            <span></span></div>
                        <div class="select-drop">
                            <div class="select-drop-arrow"></div>
                            <div class="select-drop-in scroll-pane">
                                <div class="show_mobile">
                                    <?php wp_nav_menu(array('theme_location'  => 'page-menu','items_wrap' => '<ul id="%1$s" class="%2$s nav">%3$s</ul>', 'fallback_cb' => FALSE )) ?> 
                                </div>    
                                <ul>
                                    <?php wp_list_categories('orderby=name&title_li=&hierarchical=0'); ?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="select-box">
                        <div class="s-icon s-icon2"></div>
                        <div class="select-box-header">
                            <p>
                                <?php if($gameorder == 'played') {?>
                                    <?php _e('Most Played', 'frizi-arcade') ?></p>
                                <?php }elseif($gameorder == 'rating') {?>
                                    <?php _e('Top Rated', 'frizi-arcade') ?></p>
                                <?php }else{?>
                                    <?php _e('Latest', 'frizi-arcade') ?></p>
                                <?php } ?>
                            <span></span></div>
                        <div class="select-drop">
                            <div class="select-drop-arrow"></div>
                            <div class="select-drop-in scroll-pane">
                                <ul>
                                    <?php if ( get_option('permalink_structure') ) { ?>
                                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Latest', 'frizi-arcade') ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/mostplayed/')); ?>"><?php _e('Most Played', 'frizi-arcade') ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/toprated/')); ?>"><?php _e('Top Rated', 'frizi-arcade') ?></a></li>
                                    <?php } else { ?>
                                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Latest', 'frizi-arcade') ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/')); ?>?gameorder=played"><?php _e('Most Played', 'frizi-arcade') ?></a></li>
                                        <li><a href="<?php echo esc_url(home_url('/')); ?>?gameorder=rating"><?php _e('Top Rated', 'frizi-arcade') ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="search-box">
                        <div class="s-icon s-icon3"></div>
                        <div class="search-box-header">
                            <form method="get" id="searchform1" role="search" action="<?php echo esc_url(home_url('/')); ?>" class="searchform">
                                <input type="text" id="ajaxsearchfield" class="in1" name="s" placeholder="<?php _e('Search...', 'frizi-arcade') ?>">
                                <input type="button" value="" onClick="document.getElementById('searchform1').submit();">
                            </form>    
                        </div>
                        <div class="select-drop-arrow"></div>
                        <div class="search-drop">


                        </div>
                        <div class="search-over">
                            <div class="in1-x">
                                <form method="get" id="searchform2" role="search" action="<?php echo esc_url(home_url('/')); ?>" class="searchform">
                                    <input type="text" class="in1" id="ajaxsearchfield-mobile" placeholder="<?php _e('Search...', 'frizi-arcade') ?>">
                                    <input type="submit" class="go" value="" onClick="document.getElementById('searchform2').submit();">
                                </form>    
                            </div>

                        </div>
                    </div>

                    
                        
                       
                                
                                    <?php wp_nav_menu(array('container_class' => 'select-box pages_menu_wrapper', 'theme_location'  => 'page-menu','items_wrap' => ' <div class="pages_menu">
                        </div>
                        <div class="select-drop">
                            <div class="select-drop-arrow"></div>
                            <div class="select-drop-in scroll-pane"><ul id="%1$s" class="%2$s nav">%3$s</ul></div>
                        </div>', 'fallback_cb' => FALSE )) ?> 
                                
                            
                    
                </div>
                <a class="header-share-button addthis_button" href="http://www.addthis.com/bookmark.php?v=300"></a> 
                <script type="text/javascript">var addthis_config = {"data_track_addressbar": false, ui_offset_top: -9999};</script> 
                <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script></div>
        </div>
        <div class="wrap">