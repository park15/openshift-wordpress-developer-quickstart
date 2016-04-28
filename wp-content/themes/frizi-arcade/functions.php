<?php

/**
 * games functions and definitions
 *
 * @package games
 */

/**
 * config custom boxes time range of showing games for mostplayed, toprated
 * posible options: daily,weekly,monthly,all
 * @param $boxTimeRange [daily|weekly|monthly|all]
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) {
    $content_width = 640;
    
    /* pixels */
}

global $myarcade_general, $game_post_type, $game_custom_cat, $game_custom_tag, $not_in_index;
$myarcade_general = get_option('myarcade_general');
$game_post_type = ($myarcade_general['post_type']) ? $myarcade_general['post_type'] : 'post';
$game_custom_cat = ($myarcade_general['custom_category']) ? $myarcade_general['custom_category'] : 'category';
$game_custom_tag = ($myarcade_general['custom_tags']) ? $myarcade_general['custom_tags'] : 'post_tag';

if (!function_exists('games_setup')):
    
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function games_setup() {
        
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on games, use a find and replace
         * to change 'games' to the name of your theme in all the template files
        */
        load_theme_textdomain('frizi-arcade', get_template_directory() . '/languages');
        
        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');
        
        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
        */
        add_theme_support('post-thumbnails');
        
        add_image_size('game-thumb', 200, 200, true);
        
        // (cropped)
        add_image_size('big-game-thumb', 400, 400, true);
        
        // (cropped)
        // This theme uses wp_nav_menu() in two location.
        register_nav_menus(array('page-menu' => __('Page Menu', 'frizi-arcade'),));
        
        /**
         * Add support for the  Custom Post Type
         * ex:require_once('inc/custom-post-type-[type].php');
         */
        if (!games_myarcade_plugin_activate()) {
            require_once ('inc/custom-post-type-game.php');
            
            // you can disable this if you like
            
            
        }
        
        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
        */
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
        
        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
        */
        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
        
        // Setup the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('games_custom_background_args', array('default-color' => 'ffffff', 'default-image' => '',)));
        
        /**
         * Required: set 'ot_theme_mode' filter to true.
         */
        add_filter('ot_theme_mode', '__return_true');
        
        /**
         * Show Theme Options UI Builder
         */
        add_filter('ot_show_options_ui', '__return_false');
        
        /**
         * Show Settings Pages
         */
        add_filter('ot_show_pages', '__return_false');
        
        /**
         * Required: include OptionTree.
         */
        require (trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php');
        
        //load options framework
        
        require (trailingslashit(get_template_directory()) . 'option-tree/theme-options.php');
        
        /**
         * Required: include wp_mobile_navwalker .
         */
        require (trailingslashit(get_template_directory()) . 'inc/wp-mobile-navwalker.php');
    }
    
    require (trailingslashit(get_template_directory()) . 'inc/fonts/googlefonts.php');
    
    require (trailingslashit(get_template_directory()) . 'inc/update.php');
    
    update_option('postratings_image', 'frizi-arcade');
    update_option('postratings_template_vote', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
    update_option('postratings_template_text', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
    update_option('postratings_template_none', '%RATINGS_IMAGES_VOTE%');
    update_option('postratings_template_permission', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
endif;

// games_setup
add_action('after_setup_theme', 'games_setup');

add_filter('ot_settings_id', 'frizi_arcade_settings', 1);
function frizi_arcade_settings() {
    return 'frizi_arcade_settings';
}
add_filter('ot_options_id', 'frizi_arcade_ot', 1);
function frizi_arcade_ot() {
    return 'frizi_arcade';
}

add_action('wp', 'game_get_links', 99);

function game_get_links() {
    if (!is_admin()) {
        global $wpdb, $linkid, $fontsArray;
        if ($linkid) {
            $fontsArray = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "games_link WHERE id = $linkid");
        }
    }
}

add_action('ot_after_theme_options_save', 'games_change_rating_stars');

function games_change_rating_stars($options) {
    update_option('postratings_image', 'frizi-arcade');
}

add_action('after_switch_theme', 'theme_activation_function');

function theme_activation_function() {
    global $wpdb;
    $data_table = $wpdb->prefix . "games_links_pages";
    $data_table_links = $wpdb->prefix . "games_link";
    $data_table2 = $wpdb->prefix . "games_links_pages2";
    $data_table_links2 = $wpdb->prefix . "games_link2";
    $sql = "CREATE TABLE IF NOT EXISTS $data_table_links (
                  `id` bigint(20) NOT NULL AUTO_INCREMENT,
                  `link_desc` varchar(255) NOT NULL,
                  `link_a` varchar(255) NOT NULL,
                  `link_text` varchar(255) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ;";
    
    $sql2 = "CREATE TABLE IF NOT EXISTS $data_table (
                  `link_id` bigint(20) NOT NULL,
                  `page` char(32) NOT NULL,
                  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  UNIQUE KEY `page` (`page`),
                  KEY `link_id` (`link_id`)
                );";
    $sql3 = "CREATE TABLE IF NOT EXISTS $data_table_links2 (
                  `id` bigint(20) NOT NULL AUTO_INCREMENT,
                  `link_desc` varchar(255) NOT NULL,
                  `link_a` varchar(255) NOT NULL,
                  `link_text` varchar(255) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ;";
    
    $sql4 = "CREATE TABLE IF NOT EXISTS $data_table2 (
                  `link_id` bigint(20) NOT NULL,
                  `page` char(32) NOT NULL,
                  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  UNIQUE KEY `page` (`page`),
                  KEY `link_id` (`link_id`)
                );";
    
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql2);
    dbDelta($sql3);
    dbDelta($sql4);
    
    flush_rewrite_rules(FALSE);
    
    update_option('postratings_image', 'frizi-arcade');
    update_option('postratings_template_vote', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
    update_option('postratings_template_text', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
    update_option('postratings_template_none', '%RATINGS_IMAGES_VOTE%');
    update_option('postratings_template_permission', '%RATINGS_IMAGES% %RATINGS_AVERAGE%');
}

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function games_widgets_init() {
    register_sidebar(array('name' => __('Sidebar', 'frizi-arcade'), 'id' => 'sidebar-1', 'description' => '', 'before_widget' => '<aside id="%1$s" class="widget %2$s">', 'after_widget' => '</aside>', 'before_title' => '<h1 class="widget-title">', 'after_title' => '</h1>',));
}

add_action('widgets_init', 'games_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function fizi_scripts() {
    
    wp_enqueue_script('frizi-simplemodal', get_template_directory_uri() . '/js/jquery.simplemodal.js', array('jquery'), '20120206', true);
    
    wp_register_script('frizi-report', get_template_directory_uri() . '/js/report.js', array('jquery', 'frizi-simplemodal'), '20120206', true);
    wp_localize_script('frizi-report', 'gamesreport', array('ajaxurl' => admin_url('admin-ajax.php'), 'loading' => __('Loading...', 'frizi-arcade'), 'sending' => __('Sending...', 'frizi-arcade'), 'goodbye' => __('Goodbye...', 'frizi-arcade'), 'nameerror' => __('Name is required. ', 'frizi-arcade'), 'emailerror' => __('Email is required. ', 'frizi-arcade'), 'emailerror2' => __('Email is invalid. ', 'frizi-arcade'), 'messageerror' => __('Message is required.', 'frizi-arcade')));
    wp_enqueue_script('frizi-report');
    
    wp_register_script('frizi-contact', get_template_directory_uri() . '/js/contact.js', array('jquery', 'frizi-simplemodal'), '20120206', true);
    wp_register_script('frizi-fullscreen', get_template_directory_uri() . '/js/jquery.fullscreen.js', array('jquery'), '20120206', true);
    wp_enqueue_script('frizi-contact');
    wp_enqueue_style('frizi-style-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,700,700italic,600italic,600,800italic,800&subset=latin,cyrillic-ext');
    wp_enqueue_style('frizi-custom-fonts', get_template_directory_uri() . '/inc/fonts/stylesheet.css', array());
    
    wp_enqueue_style('frizi-style', get_stylesheet_uri(), array('frizi-style-font', 'frizi-jscrollpane', 'frizi-custom-fonts', 'frizi-color-style'));
    
    $custom_css = ot_get_option('custom_css', '');
    
    if (!empty($custom_css)) {
        wp_add_inline_style('frizi-style', $custom_css);
    }
    
    wp_enqueue_style('frizi-jscrollpane', get_template_directory_uri() . '/libs/jscrollpane/jquery.jscrollpane.css', array());
    
    wp_enqueue_script('frizi-scrollepane', get_template_directory_uri() . '/libs/jscrollpane/jquery.jscrollpane.min.js', array('jquery'), '20120206', true);
    wp_enqueue_script('frizi-mousewheel', get_template_directory_uri() . '/libs/jscrollpane/jquery.mousewheel.js', array('jquery'), '20120206', true);
    
    wp_register_script('frizi-custom', get_template_directory_uri() . '/js/js.js', array('jquery', 'frizi-scrollepane', 'frizi-mousewheel', 'jquery-ui-autocomplete', 'frizi-fullscreen'), '20120206', true);
    wp_localize_script('frizi-custom', 'gamesdata', array('ajaxurl' => admin_url('admin-ajax.php')));
    wp_enqueue_script('frizi-custom');
    
    $color_style = ot_get_option('color_style', 'blue');
    
    wp_enqueue_style('frizi-color-style', get_template_directory_uri() . '/style/' . $color_style . '.css', array());
    
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
        wp_enqueue_script('jqueryvalidate', get_template_directory_uri() . '/js/jquery.validate.min.js', array('jquery'));
        wp_enqueue_script('commentvalidation', get_template_directory_uri() . '/js/comment-validation.js', array('jquery', 'jqueryvalidate'));
    }
}

add_action('wp_enqueue_scripts', 'fizi_scripts');

/**
 * Implement the Custom Header feature.
 */

//require get_template_directory() . '/inc/custom-header.php';



/**
 * Custom metabox  for this theme.
 */
require get_template_directory() . '/inc/theme-meta-boxes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Plugins file
 */
require get_template_directory() . '/inc/plugins.php';

/**
 * Load Links file
 */
require get_template_directory() . '/inc/sponsorlinks.php';

/**
 * Functions to deal with the AJAX request for autocomplete - one for logged in users, the other for non-logged in users.
 */
add_action('wp_ajax_game_autocompletesearch', 'game_autocomplete_suggestions');
add_action('wp_ajax_nopriv_game_autocompletesearch', 'game_autocomplete_suggestions');

function game_autocomplete_suggestions() {
    global $game_post_type;
    
    // Query for suggestions
    $posts = get_posts(array('s' => $_REQUEST['term'], 'post_type' => $game_post_type, 'numberposts' => 0, 'no_found_rows' => true, 'update_post_term_cache' => 0, 'update_post_meta_cache' => 0, 'cache_results' => 0));
    
    // Initialise suggestions array
    $suggestions = array();
    global $post;
    foreach ($posts as $post):
        setup_postdata($post);
        
        // Initialise suggestion array
        $suggestion = array();
        $suggestion['label'] = esc_html($post->post_title);
        $suggestion['link'] = get_permalink();
        $suggestion['image'] = get_game_thumbnail($width = 50, $height = 50, $class = '', $post->ID, false);
        
        // Add suggestion to suggestions array
        $suggestions[] = $suggestion;
    endforeach;
    
    // JSON encode and echo
    $response = $_GET["callback"] . "(" . json_encode($suggestions) . ")";
    echo $response;
    
    // Don't forget to exit!
    exit;
}

function games_get_page_views($post_id, $echo = false) {
    
    if (function_exists('wp_get_views')) {
        if ($echo) echo wp_get_views($post_id);
        else return wp_get_views($post_id);
    } 
    else return 0;
}

/**
 * Get rating hearts
 */
function games_get_rating_stars($post_id, $size, $echo = false) {
    $output = '';
    $hearts = round(get_post_meta($post_id, 'ratings_average', true), 0);
    
    if (empty($hearts)) $hearts = 0;
    
    switch ($size) {
        case "small":
            $img1 = '<img width="14" height="12" src="' . get_template_directory_uri() . '/images/s1.png" alt="">';
            $img2 = '<img width="14" height="12" src="' . get_template_directory_uri() . '/images/s2.png" alt="">';
            break;

        case "big":
            $img1 = '<img width="25" height="22" src="' . get_template_directory_uri() . '/images/st1.png" alt="">';
            $img2 = '<img width="25" height="22" src="' . get_template_directory_uri() . '/images/st2.png" alt="">';
            break;

        default:
            $img1 = '<img width="14" height="12" src="' . get_template_directory_uri() . '/images/s1.png" alt="">';
            $img2 = '<img width="14" height="12" src="' . get_template_directory_uri() . '/images/s2.png" alt="">';
            break;
    }
    
    for ($i = 0, $h = $hearts; $i < 5; $i++, $h--) {
        $output.= ($h > 0) ? $img1 : $img2;
    }
    
    if ($echo) echo $output;
    else return $output;
}

/**
 * Display 4 Most Played Games Within Category
 */
function get_most_played_games_by_cat($termid, $limit = 6, $title = '') {
    global $wpdb, $game_post_type, $game_custom_cat, $get_most_played_games_by_cat_id;
    $link = get_term_link(intval($termid), $game_custom_cat);
    $link = is_wp_error($link) ? '#' : $link;
    $term = get_term_by('id', $termid, $game_custom_cat, 'ARRAY_A');
    
    $args = array();
    
    // - Set up our variables
    
    $args = array('post_type' => $game_post_type, 'posts_per_page' => 8, 'meta_key' => 'played', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'tax_query' => array(array('taxonomy' => $game_custom_cat, 'field' => 'id', 'terms' => $termid)));
    $loop = new WP_Query($args);
?>
    <?php
    if ($loop->have_posts()): ?>
        <div class="block3 group categblock">
            <div class="header">
                <h3><?php
        echo $term['name'] ?></h3>
                <div class="header-bar"><a href="<?php
        echo $link
?>" class="show-all"><?php
        _e('SHOW All', 'frizi-arcade') ?></a></div>
            </div><!-- .header -->
            <div class="small-thumbs">
        <?php
        while ($loop->have_posts()):
            $loop->the_post();
            
            // Include the template for the content.
            get_template_part('inc/repeater-list', 'small');
        endwhile;
?>
            </div><!-- .small-thumbs -->    
        </div><!-- .block3 -->  
            <?php
    endif; ?>
    <?php
}

/**
 * Geta ajax sort
 */
add_action('wp_ajax_games_sort', 'get_games_sort');
add_action('wp_ajax_nopriv_games_sort', 'get_games_sort');

if (!function_exists('get_games_sort')) {
    
    function get_games_sort() {
        global $game_post_type;
        $thumbs_size = ot_get_option('thumbs', 'small');
        
        if (!wp_verify_nonce($_REQUEST['nonce'], "games_ajax_load_more_nonce")) {
            exit("No naughty business please");
        }
        
        $args = array('post_type' => $game_post_type, 'paged' => $_POST['page'], 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
        if ($thumbs_size === 'small') {
            $args['posts_per_page'] = 120;
        } 
        else {
            $args['posts_per_page'] = 30;
        }
        $sort = isset($_POST['sort']) ? $_POST['sort'] : 'date';
        
        if ($sort == 'most-played') {
            $args['meta_key'] = 'played';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['meta_query'] = array(array('key' => 'played', 'compare' => 'EXISTS'));
        } 
        elseif ($sort == 'top-rated') {
            $args['meta_key'] = 'ratings_average';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $args['meta_query'] = array(array('key' => 'ratings_average', 'compare' => 'EXISTS'));
        } 
        else {
            $args['orderby'] = 'date';
            $args['meta_query'] = array();
        }
        
        $loop = new WP_Query($args);
        
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            
            // You are on the last page
            
            
        }
        
        if ($loop->have_posts()):
            $k = 0;
            while ($loop->have_posts()):
                $loop->the_post();
                if ($thumbs_size == 'small') {
                    if ($k == 0) {
                        echo '<div  class="thumb game combo">';
                    }
                    get_template_part('inc/repeater-list', $thumbs_size);
                    $k++;
                    if ($k == 4) {
                        echo '</div>';
                        $k = 0;
                    }
                } 
                else {
                    
                    // Include the template for the content.
                    get_template_part('inc/repeater-list', $thumbs_size);
                }
            endwhile;
        endif;
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            echo '<div class="lastpage hidden"></div>';
        }
        exit();
    }
}

/**
 * Geta ajax more load
 */
add_action('wp_ajax_games_ajax_load_more', 'get_games_ajax_load_more');
add_action('wp_ajax_nopriv_games_ajax_load_more', 'get_games_ajax_load_more');

if (!function_exists('get_games_ajax_load_more')) {
    
    function get_games_ajax_load_more() {
        global $game_post_type;
        $thumbs_size = ot_get_option('thumbs', 'small');
        
        if (!wp_verify_nonce($_REQUEST['nonce'], "games_ajax_load_more_nonce")) {
            exit("No naughty business please");
        }
        
        $args = array('post_type' => $game_post_type, 'posts_per_page' => $_POST['post_per_page'], 'paged' => $_POST['page'] + 1, 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
        
        $sort = isset($_POST['sort']) ? $_POST['sort'] : 'date';
        
        if ($sort == 'most-played') {
            $args['meta_key'] = 'played';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } 
        elseif ($sort == 'top-rated') {
            $args['meta_key'] = 'ratings_average';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } 
        else {
            $args['orderby'] = 'date';
        }
        
        $loop = new WP_Query($args);
        
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            
            // You are on the last page
            
            
        }
        if ($loop->have_posts()):
            $k = 0;
            while ($loop->have_posts()):
                $loop->the_post();
                if ($thumbs_size == 'small') {
                    if ($k == 0) {
                        echo '<div  class="thumb game combo">';
                    }
                    get_template_part('inc/repeater-list', $thumbs_size);
                    $k++;
                    if ($k == 4) {
                        echo '</div>';
                        $k = 0;
                    }
                } 
                else {
                    
                    // Include the template for the content.
                    get_template_part('inc/repeater-list', $thumbs_size);
                }
            endwhile;
        endif;
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            echo '<div class="lastpage hidden"></div>';
        }
        exit();
    }
}

/**
 * Geta ajax mostplayed load
 */
add_action('wp_ajax_games_ajax_load_mostplayed', 'get_games_ajax_load_mostplayed');
add_action('wp_ajax_nopriv_games_ajax_load_mostplayed', 'get_games_ajax_load_mostplayed');

if (!function_exists('get_games_ajax_load_mostplayed')) {
    
    function get_games_ajax_load_mostplayed() {
        global $game_post_type;
        
        if (!wp_verify_nonce($_REQUEST['nonce'], "games_ajax_load_more_nonce")) {
            exit("No naughty business please");
        }
        
        $args = array('post_type' => $game_post_type, 'posts_per_page' => $_POST['post_per_page'], 'paged' => $_POST['page'], 'meta_key' => 'played', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
        
        $loop = new WP_Query($args);
        
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            
            // You are on the last page
            
            
        }
        if ($loop->have_posts()):
            
            while ($loop->have_posts()):
                $loop->the_post();
                
                // Include the template for the content.
                get_template_part('inc/repeater-list', 'small');
            endwhile;
        endif;
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            echo '<div class="lastpage hidden"></div>';
        }
        exit();
    }
}

/**
 * Geta ajax best rated load
 */
add_action('wp_ajax_games_ajax_load_bestrated', 'get_games_ajax_load_bestrated');
add_action('wp_ajax_nopriv_games_ajax_load_bestrated', 'get_games_ajax_load_bestrated');

if (!function_exists('get_games_ajax_load_bestrated')) {
    
    function get_games_ajax_load_bestrated() {
        global $game_post_type;
        
        if (!wp_verify_nonce($_REQUEST['nonce'], "games_ajax_load_more_nonce")) {
            exit("No naughty business please");
        }
        
        $args = array('post_type' => $game_post_type, 'posts_per_page' => $_POST['post_per_page'], 'paged' => $_POST['page'], 'meta_key' => 'ratings_average', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
        
        $loop = new WP_Query($args);
        
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            
            // You are on the last page
            
            
        }
        if ($loop->have_posts()):
            
            while ($loop->have_posts()):
                $loop->the_post();
                
                // Include the template for the content.
                get_template_part('inc/repeater-list', 'small');
            endwhile;
        endif;
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            echo '<div class="lastpage hidden"></div>';
        }
        exit();
    }
}

/**
 * Display Most Played Games With Time Range
 */
add_action('wp_ajax_juego_ajax_load_mostplayed', 'get_most_played_games_ajax');
add_action('wp_ajax_nopriv_juego_ajax_load_mostplayed', 'get_most_played_games_ajax');

function get_most_played_games_ajax() {
    
    $args = array();
    
    // - Set up our variables from ajax-load-custom-boxes.js
    $args['paged'] = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;
    $args['limit'] = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 8;
    
    exit();
}

/**
 * Display Highest Rated Games With Time Range
 */
add_action('wp_ajax_juego_ajax_load_toprated', 'get_highest_rated_games_ajax');
add_action('wp_ajax_nopriv_juego_ajax_load_toprated', 'get_highest_rated_games_ajax');

function get_highest_rated_games_ajax() {
    
    $args = array();
    
    // - Set up our variables from ajax-load-custom-boxes.js
    $args['paged'] = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;
    $args['limit'] = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 8;
    $args['range'] = (isset($_GET['range'])) ? $_GET['range'] : 'weekly';
    
    get_highest_rated_games($args);
    exit();
}

/**
 * Display Recent  Games
 */
add_action('wp_ajax_juego_ajax_load_recent', 'get_recent_games_ajax');
add_action('wp_ajax_nopriv_juego_ajax_load_recent', 'get_recent_games_ajax');

function get_recent_games_ajax() {
    
    $args = array();
    
    // - Set up our variables
    $postType = (isset($_GET['postType'])) ? $_GET['postType'] : $game_post_type;
    $numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 8;
    $page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;
    
    $args = array('post_type' => $postType, 'posts_per_page' => $numPosts, 'paged' => $page, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
    
    get_recent_games($args);
    exit();
}

function get_recent_games($args, $template = 'small') {
    
    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        
        while ($loop->have_posts()):
            $loop->the_post();
            
            // Include the template for the content.
            get_template_part('inc/repeater-list', $template);
        endwhile;
    endif;
}

/**
 * Display Recent  Games
 */
add_action('wp_ajax_juego_ajax_load_related', 'get_related_games_ajax');
add_action('wp_ajax_nopriv_juego_ajax_load_related', 'get_related_games_ajax');

function get_related_games_ajax() {
    
    $args = array();
    
    // - Set up our variables
    $postType = (isset($_GET['postType'])) ? $_GET['postType'] : $game_post_type;
    $numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 8;
    $page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;
    $taxonomy = (isset($_GET['taxonomy'])) ? $_GET['taxonomy'] : '';
    $tag = (isset($_GET['tag'])) ? $_GET['tag'] : '';
    $exclude = (isset($_GET['exclude'])) ? $_GET['exclude'] : '';
    
    $args = array('post_type' => $postType, 'posts_per_page' => $numPosts, 'paged' => $page, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
    
    // - Query by Taxonomy
    if (!empty($taxonomy)) $args[$taxonomy] = $tag;
    
    // - Exclude posts if needed
    if (!empty($exclude)) {
        $exclude = explode(",", $exclude);
        $args['post__not_in'] = $exclude;
    }
    
    get_related_games($args);
    exit();
}

function get_related_games($args, $template = 'small') {
    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        
        while ($loop->have_posts()):
            $loop->the_post();
            
            // Include the template for the content.
            get_template_part('inc/repeater-list', $template);
        endwhile;
    endif;
}

/**
 * Ajax calback for lazy loading game post type
 */
add_action('wp_ajax_juego_ajax_load', 'games_ajax_load');
add_action('wp_ajax_nopriv_juego_ajax_load', 'games_ajax_load');

function games_ajax_load() {
    
    // Verify Referer-$nonce = wp_create_nonce('juego_postratings_' . $post_id . '-nonce');
    if (!check_ajax_referer('games-ajax-load-nonce', 'token', false)) {
        _e('Failed To Verify Referrer', 'juego_ajax_load');
        exit();
    }
    
    // - Set up our variables from ajax-load-more.js
    $postType = (isset($_GET['postType'])) ? $_GET['postType'] : $game_post_type;
    $category = (isset($_GET['category'])) ? $_GET['category'] : '';
    $author_id = (isset($_GET['author'])) ? $_GET['author'] : '';
    $taxonomy = (isset($_GET['taxonomy'])) ? $_GET['taxonomy'] : '';
    $tag = (isset($_GET['tag'])) ? $_GET['tag'] : '';
    $s = (isset($_GET['search'])) ? $_GET['search'] : '';
    $exclude = (isset($_GET['postNotIn'])) ? $_GET['postNotIn'] : '';
    $numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 6;
    $page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 0;
    
    // - Set up initial args
    $args = array('post_type' => $postType, 'category_name' => $category, 'author' => $author_id, 'posts_per_page' => $numPosts, 'paged' => $page, 's' => $s, 'orderby' => 'date', 'order' => 'DESC', 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
    
    // - Exclude posts if needed
    if (!empty($exclude)) {
        $exclude = explode(",", $exclude);
        $args['post__not_in'] = $exclude;
    }
    
    // - Query by Taxonomy
    if (empty($taxonomy)) {
        $args['tag'] = $tag;
    } 
    else {
        $args[$taxonomy] = $tag;
    }
    
    $loop = new WP_Query($args);
    if ($loop->have_posts()):
        $i = 0;
        while ($loop->have_posts()):
            $loop->the_post();
            $i++;
            
            //if($i==5) get_template_part( '/inc/banner-big');
            // - Run the repeater
            get_template_part('/inc/repeater-list', 'big');
        endwhile;
    endif;
    wp_reset_query();
    exit();
}

/**
 * Fix urls for filtering custom boxes (mostplayed,bestrated)
 */
function add_query_vars($aVars) {
    $aVars[] = "gameorder";
    
    // represents the name of the product category as shown in the URL
    return $aVars;
}

// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rules() {
    add_rewrite_tag('%gameorder%', '([^&]+)');
    add_rewrite_rule('^mostplayed/?', 'index.php?gameorder=played', 'top');
    add_rewrite_rule('^toprated/?', 'index.php?gameorder=rating', 'top');
}

// hook add_rewrite_rules function into rewrite_rules_array

add_action('init', 'add_rewrite_rules');

/**
 * Facebook Open Graph
 */
add_action('wp_head', 'add_fb_open_graph_tags');

function add_fb_open_graph_tags() {
    global $post, $wp;
    
    $image = '';
    
    if (is_single()) {
        if (get_the_post_thumbnail($post->ID, 'thumbnail')) {
            $thumbnail_id = get_post_thumbnail_id($post->ID);
            $thumbnail_object = get_post($thumbnail_id);
            $image = $thumbnail_object->guid;
        } 
        elseif (ot_get_option('share_image', false)) {
            $imagesrc = wp_get_attachment_image_src(ot_get_option('share_image'), 'medium');
            $image = $imagesrc[0];
        } 
        elseif (ot_get_option('logo_image', false)) {
            $imagesrc = wp_get_attachment_image_src(ot_get_option('logo_image'), 'medium');
            $image = $imagesrc[0];
        }

        //$description = get_bloginfo('description');
        $description = my_excerpt($post->post_content, $post->post_excerpt);
        $description = strip_tags($description);
        $description = str_replace("\"", "'", $description);
?>
        <meta name="description" content="<?php
        echo $description
?>" />

        <meta property="og:title" content="<?php
        get_game_title(0, true); ?>"/>
        <meta property="og:type" content="article"/>
        <?php
        if (!empty($image)) { ?>
            <meta property="og:image" content="<?php
            echo $image; ?>"/>
        <?php
        } ?>    
        <meta property="og:url" content="<?php
        the_permalink(); ?>"/>
        <meta property="og:description" content="<?php
        echo $description
?>"/>
        <meta property="og:site_name" content="<?php
        echo get_bloginfo('name'); ?>"/>
        <?php
    } 
    else {
        
        if (ot_get_option('share_image', false)) {
            $imagesrc = wp_get_attachment_image_src(ot_get_option('share_image'), 'medium');
            $image = $imagesrc[0];
        } 
        elseif (ot_get_option('logo_image', false)) {
            $imagesrc = wp_get_attachment_image_src(ot_get_option('logo_image'), 'medium');
            $image = $imagesrc[0];
        }

        if (is_tax()) {
            $taxname = ucfirst(single_term_title("", false));
            $meta_descrition = "$taxname" . get_bloginfo('name') . " - " . get_bloginfo('description');
        }
        if (is_search()) {
            $searchterm = ucfirst(get_search_query());
            $meta_descrition = "$searchterm" . get_bloginfo('name') . " - " . get_bloginfo('description');
        }
?>
        <meta name="description" content="<?php
        echo isset($meta_descrition) ? $meta_descrition : get_bloginfo('description'); ?>" />

        <meta property="og:title" content="<?php
        echo get_bloginfo('name'); ?>"/>
        <meta property="og:type" content="website"/>
        <meta property="og:image" content="<?php
        echo $image; ?>"/>
        <meta property="og:url" content="<?php
        echo home_url($wp->request); ?>"/>
        <meta property="og:description" content="<?php
        echo isset($meta_descrition) ? $meta_descrition : get_bloginfo('description'); ?>"/>
        <meta property="og:site_name" content="<?php
        echo get_bloginfo('name'); ?>"/>
        <?php
    }
}

add_filter('single_post_title', 'AIOSEO_post_title');

function AIOSEO_post_title($text) {
    if (get_game_title(0, false)) return get_game_title(0, false);
    return $text;
}

add_filter('aioseop_description', 'AIOSEO_description');

function AIOSEO_description($text) {
    return "";
}

function curdate() {
    return gmdate('Y-m-d', (time() + (get_option('gmt_offset') * 3600)));
}

function now() {
    return current_time('mysql');
}

function my_excerpt($text, $excerpt) {
    
    if ($excerpt) return $excerpt;
    
    $text = strip_shortcodes($text);
    
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n
     ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } 
    else {
        $text = implode(' ', $words);
    }
    
    return apply_filters('wp_trim_excerpt', $text, $excerpt);
}

add_action('wp_head', 'games_process_postviews');

function games_process_postviews() {
    global $user_ID, $post;
    if (is_int($post)) {
        $post = get_post($post);
    }
    if (!wp_is_post_revision($post) && (!empty($_SERVER['HTTP_USER_AGENT']) and !preg_match('~(bot|crawl)~i', $_SERVER['HTTP_USER_AGENT']))) {
        if (is_single() || is_page()) {
            $id = intval($post->ID);
            if (!$post_views = get_post_meta($post->ID, 'played', true)) {
                $post_views = 0;
            }
            
            update_post_meta($id, 'played', ($post_views + 1));
            do_action('postviews_increment_views', ($post_views + 1));
        }
    }
}

/**
 * Geta ajax report game form
 */
add_action('wp_ajax_report_game_form', 'games_report_form');
add_action('wp_ajax_nopriv_report_game_form', 'games_report_form');

function games_report_form() {
    $output = "
    <div class='contact-content'>
    <div class='inner'>
        <h4 class='contact-title'>" . __('Report game', 'frizi-arcade') . ":</h4>
        <div class='contact-loading' style='display:none'></div>
        <div class='contact-message' style='display:none'></div>
        
            
            <form action='#' style='display:none'>
             <input type='hidden' name='gameid'  value='" . $_POST["gameid"] . "' />
             <div class='l'>
                <input type='text' id='contact-name' class='contact-input' name='name' tabindex='1001' placeholder='" . __('Name', 'frizi-arcade') . "' />
            </div>
            <div class='l'> 
                <input type='text' id='contact-email' class='contact-input' name='email' tabindex='1002' placeholder='" . __('Email', 'frizi-arcade') . "' />
            </div>
            <div class='l'> 
                <textarea id='contact-message' class='contact-input' name='message' cols='40' rows='4' tabindex='1004' placeholder=\"" . __("What's wrong with game?", 'frizi-arcade') . "\" ></textarea>
            </div>";
    if (!is_user_logged_in()) {
        $output.= " <div class='l' id='contact-capcha'>
            
            <img src='" . get_template_directory_uri() . "/inc/captcha.php' />
            <input type='text' name='code' id='report-code' placeholder='" . __('Code', 'frizi-arcade') . "'>
            <input type='hidden' name='hash' id='hashcode' value='" . md5($_SESSION['captchacode']) . "' />
           
        </div>";
    }
    
    $output.= "<div class='l'>                  
                    <button type='submit' class='contact-send sd' tabindex='1006'>" . __("Send", 'frizi-arcade') . "</button>
                    
                </div>
                <input type='hidden' name='nonce' value='" . wp_create_nonce("games_report_nonce") . "'/>
            </form>
            </div>
        </div>  
    </div>
";
    
    echo $output;
    
    die();
}

/**
 * Send report game from
 */
add_action('wp_ajax_report_game', 'games_report');
add_action('wp_ajax_nopriv_report_game', 'games_report');

function games_report() {
    
    if (!wp_verify_nonce($_POST['nonce'], "games_report_nonce")) {
        exit("No naughty business please");
    }
    $adminmail = get_bloginfo('admin_email');
    
    if (!is_user_logged_in()) {
        if (empty($_POST["hash"]) || md5(trim(strtolower($_POST["code"]))) != strtolower($_POST["hash"])) {
            _e("Unfortunately,wrong captcha.");
            die();
        }
    }
    
    // Send the email
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";
    $headers[] = "From: $name <$email>";
    
    $message.= "\r\n" . __('Game id: ') . $_POST["gameid"];
    $message.= "\r\n" . __('Game url: ') . get_permalink($_POST["gameid"]);
    
    // make sure the token matches
    if (wp_mail($adminmail, __('Report game', 'frizi-arcade'), $message, $headers)) {
        _e("Your message was successfully sent.", 'frizi-arcade');
    } 
    else {
        _e("Unfortunately, your message could not be verified.");
    }
    
    die();
}

/**
 * Ajax check capcha
 */
add_action('wp_ajax_checkcapcha', 'games_checkcapcha');
add_action('wp_ajax_nopriv_checkcapcha', 'games_checkcapcha');

function games_checkcapcha() {
    
    if (empty($_POST["hash"]) || md5(trim(strtolower($_POST["code"]))) != strtolower($_POST["hash"])) {
        echo "fail";
        die();
    } 
    else {
        echo "success";
        die();
    }
}

/**
 * Geta ajax contact form
 */
add_action('wp_ajax_games_contact_form', 'games_contact_form');
add_action('wp_ajax_nopriv_games_contact_form', 'games_contact_form');

function games_contact_form() {
    $output = "
    <div class='contact-content'>
    <div class='inner'>
        <h4 class='contact-title'>" . __('Contact us', 'frizi-arcade') . ":</h4>
        <div class='contact-loading' style='display:none'></div>
        <div class='contact-message' style='display:none'></div>
        
            
            <form action='#' style='display:none'>
             <div class='l'>
                <input type='text' id='contact-name' class='contact-input' name='name' tabindex='1001' placeholder='" . __('Name', 'frizi-arcade') . "' />
            </div>
            <div class='l'> 
                <input type='text' id='contact-email' class='contact-input' name='email' tabindex='1002' placeholder='" . __('Email', 'frizi-arcade') . "' />
            </div>
            <div class='l'> 
                <input type='text' id='contact-subject' class='contact-input' name='subject' tabindex='1003' placeholder='" . __('Subject', 'frizi-arcade') . "' />
            </div>
            <div class='l'> 
                <textarea id='contact-message' class='contact-input' name='message' cols='40' rows='4' tabindex='1004' placeholder=\"" . __("Message", 'frizi-arcade') . "\" ></textarea>
            </div>
        ";
    if (!is_user_logged_in()) {
        $output.= " <div class='l' id='contact-capcha'>
            
            <img src='" . get_template_directory_uri() . "/inc/captcha.php' />
            <input type='text' name='code' id='report-code' placeholder='" . __('Code', 'frizi-arcade') . "'>
            <input type='hidden' name='hash' id='hashcode' value='" . md5($_SESSION['captchacode']) . "' />
        </div>";
    }
    
    $output.= " 
                    
                    <button type='submit' class='contact-send sd' tabindex='1006' >" . __("Send", 'frizi-arcade') . "</button>
                
                <input type='hidden' name='nonce' value='" . wp_create_nonce("games_report_nonce") . "'/>
            </form>
            </div>
        </div>  
    </div>
";
    
    echo $output;
    
    die();
}

/**
 * Send report game from
 */
add_action('wp_ajax_games_send_message', 'games_send_message');
add_action('wp_ajax_nopriv_games_send_message', 'games_send_message');

function games_send_message() {
    
    if (!wp_verify_nonce($_POST['nonce'], "games_report_nonce")) {
        exit("No naughty business please");
    }
    $adminmail = get_bloginfo('admin_email');
    
    if (!is_user_logged_in()) {
        if (empty($_POST["hash"]) || md5(trim(strtolower($_POST["code"]))) != strtolower($_POST["hash"])) {
            _e("Unfortunately,wrong captcha.");
            die();
        }
    }
    
    // Send the email
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";
    $headers[] = "From: $name <$email>";
    
    // make sure the token matches
    if (wp_mail($adminmail, __('Report game', 'frizi-arcade'), $message, $headers)) {
        _e("Your message was successfully sent.", 'frizi-arcade');
    } 
    else {
        _e("Unfortunately, your message could not be verified.");
    }
    
    die();
}

/* ----------------------------------------------------------------------------------- */

/*  Template for comments and pingbacks. */

/*  Used as a callback by wp_list_comments() for displaying the comments. */

/* ----------------------------------------------------------------------------------- */
if (!function_exists('games_custom_comment')) {
    
    function games_custom_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type):
        case 'pingback':
        case 'trackback':
?>
                <li class="post pingback">
                    <p><?php
            _e('Pingback:', 'frizi-arcade'); ?> <?php
            comment_author_link(); ?><?php
            edit_comment_link(__('(Edit)', 'essential'), ' '); ?></p>
                <?php
            break;

        default:
?>
                <li <?php
            comment_class('group com'); ?> id="li-comment-<?php
            comment_ID(); ?>">
                    <article id="comment-<?php
            comment_ID(); ?>" class="comment group">
                        <div class="image-container"><?php
            echo get_avatar($comment, 70); ?></div><!-- .image-container -->
                        <div class="comment-content group com-in">
                            <div class="com-arr"></div>
                            <div class="comment-author vcard com-name">
                    <?php
            printf(__('<span class="says">%s</span> ', 'frizi-arcade'), sprintf('<cite class="fn">%s</cite>', get_comment_author_link())); ?>


                            </div><!-- .comment-author .vcard -->
                            <div class="comment-text">
                <?php
            comment_text(); ?>
                <?php
            edit_comment_link(__('(Edit)', 'frizi-arcade'), ' '); ?>
                            </div>
                <?php
            if ($comment->comment_approved == '0'): ?>
                                <br/>
                                <em><?php
                _e('Your comment is awaiting moderation.', 'frizi-arcade'); ?></em>
                                <br />
                <?php
            endif; ?>
                            <div class="reply">
                <?php
            comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
                            </div><!-- .reply -->
                            <time  datetime="<?php
            comment_time('c'); ?>">
                                <?php
            printf(__('%1$s at %2$s', 'essential'), get_comment_date(), get_comment_time());
            
            // translators: 1: date, 2: time
            
?>
                            </time>
                        </div><!-- .comment-content -->                             
                        <div class="clear"></div>               
                    </article><!-- #comment-<?php
            comment_ID(); ?> -->
                            <?php
            break;
        endswitch;
    }
}

/* ----------------------------------------------------------------------------------- */

/* Check if game is new
/*----------------------------------------------------------------------------------- */
if (!function_exists('games_is_game_new')) {
    
    function games_is_game_new($postid) {
        
        global $post;
        
        if (isset($postid)) {
            
            //$postid = $post -> ID;
            
            
        }
        
        $newday = ot_get_option('maximum_days_for_new_games', '3');
        
        return get_the_time('U', $postid) > current_time('timestamp') - ($newday * 86400);
    }
}

/* ----------------------------------------------------------------------------------- */

/* Set session for capcha */

/* ----------------------------------------------------------------------------------- */
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');

function myStartSession() {
    if (!session_id()) {
        session_start();
    }
}

function myEndSession() {
    session_destroy();
}

/* ----------------------------------------------------------------------------------- */

/* Get favicon url */

/* ----------------------------------------------------------------------------------- */
if (!function_exists('games_favicon_url')) {
    
    function games_favicon_url() {
        $url = ot_get_option('favicon');
        if (!$url or empty($url)) {
            $url = get_template_directory_uri() . '/favicon.ico';
        }
        if (is_ssl()) $url = str_replace('http://', 'https://', $url);
        return $url;
    }
}

/* ----------------------------------------------------------------------------------- */

/* Add favicon html */

/* ----------------------------------------------------------------------------------- */
add_action('wp_head', 'games_favicon');
if (!function_exists('games_favicon')) {
    
    function games_favicon() {
?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php
        echo games_favicon_url() ?>" />
    <link rel="icon" type="image/x-icon" href="<?php
        echo games_favicon_url() ?>" />
    <?php
    }
}

// add game no-game to post class
function post_game_class($classes) {
    global $post;
    if (get_post_meta($post->ID, 'mabp_game_tag', true)) {
        $classes[] = 'is-game';
    } 
    else {
        $classes[] = 'no-game';
    }
    return $classes;
}

add_filter('post_class', 'post_game_class');

add_action('wp_footer', 'capcaha_hack');
if (!function_exists('capcaha_hack')) {
    
    function capcaha_hack() {
        if (!isset($_SESSION['captchacode']) && !is_user_logged_in()) {
            echo "<img class='hidden' src='" . get_template_directory_uri() . "/inc/captcha.php' />";
        }
    }
}

if (!function_exists('games_myarcade_plugin_activate')) {
    
    function games_myarcade_plugin_activate() {
        
        if (function_exists('myarcade_frontend_scripts')) {
            return TRUE;
        }
        
        return false;
    }
}
add_filter('body_class', 'browser_body_class');

function browser_body_class($classes = '') {
    
    $classes[] = ot_get_option('thumbs', 'small') . '-thumbs-set';
    $classes[] = ot_get_option('background_style', 'light') . '-style';
    $classes[] = ot_get_option('color_style', 'blue') . '-color';
    
    return $classes;
}

add_action('ot_header_list', 'addlinktooptiontreeheader');

function addlinktooptiontreeheader() {
    add_thickbox();
    echo '<a type="submit" class="option-tree-ui-button button button-primary buy-theme thickbox"  href="#TB_inline?width=400&height=250&inlineId=modal-window-id"  title="Buy Paid Version">Buy Paid Version</a>';
    echo '<li class="logo"><a href="http://www.arcadepulse.com" target="_blank">FriziArcade</a></li>';
    echo '<li>For all support questions please visit our forum: <a href="http://forum.arcadepulse.com" target="_blank">http://forum.arcadepulse.com</a> - <a href="http://forum.arcadepulse.com/forum/frizi/frizi-arcade-change-log/">Changelog</a> <br />' . 'Join us today on facebook <a href="https://www.facebook.com/groups/ArcadeWebmastersBiz/" target="_blank">Arcade Webmasters group</a> to meet more fellow webmasters!</li>';
    echo '<div id="modal-window-id" style="display:none;">
    <div><p>If you want to remove link to our website in bottom right(footer), you need to buy paid version.
    </p><p>Paid version costs $25 per domain.</p> 
    <p>To buy paid version send $25 to PayPal info@arcadepulse.com and write note with domain name and your email so I can send you instructions how to activate it.</p>
    

        <p>Thank you for supporting us!</p></div>
    </div>';
}

add_filter('wp_nav_menu_items', 'your_custom_menu_item', 10, 2);

function your_custom_menu_item($items, $args) {
    $sharelink = ot_get_option('sharelink', 'on');
    if ($args->theme_location == 'primary' && $sharelink == 'on') {
        $items.= '<li><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300">' . __('Share', 'frizi-arcade') . '</a>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,   ui_offset_top: -9999};</script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script></li>';
    }
    if ($args->theme_location == 'mobile' && $sharelink == 'on') {
        $items = '<li><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300">' . __('Share', 'frizi-arcade') . '</a>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":false,   ui_offset_top: -9999};</script>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script></li>' . $items;
    }
    return $items;
}

if (!function_exists('custom_text_logo')) {
    
    function custom_text_logo() {
        $blogname = get_bloginfo('name');
        
        $blogname = explode(' ', $blogname);
        
        $words = count($blogname);
        
        if ($words == 0) {
        } 
        elseif ($words == 1) {
            
            echo "<span class='one-word'><i></i>$blogname[0]</span>";
            return;
        } 
        elseif ($words == 2) {
            echo "<span class='two-word'><i></i><span>$blogname[0]</span><br/><span class='sec'>$blogname[1]</span></span>";
            return;
        } 
        else {
            echo "<span class='two-word'><i></i>$blogname[0] $blogname[1]<br/><span class='sec'>$blogname[2]</span></span>";
            return;
        }
    }
}

function add_swf_mimes($mimes) {
    
    $mimes['swf'] = 'application/x-shockwave-flash';
    
    return $mimes;
}

add_filter('upload_mimes', 'add_swf_mimes');

function custom_navigation() {
?>
    <?php
    if (ot_get_option('logo_image')) { ?>
        <a href="<?php
        echo esc_url(home_url()) ?>" class="logo-image" title="<?php
        bloginfo('name') ?>">
        <?php
        echo wp_get_attachment_image(ot_get_option('logo_image'), 'medium'); ?>
        </a>    
        <?php
    } 
    else { ?>
        <a href="<?php
        echo esc_url(home_url()) ?>" class="logo-text" title="<?php
        bloginfo('name') ?>"><?php
        custom_text_logo() ?></a>
    <?php
    } ?>
    
    <?php
    if (ot_get_option('defmenu', 'on') == 'on') { ?>    
        <ul class='nav'>
            <li><a href="<?php
        echo esc_url(home_url()) ?>"><?php
        _e('Home', 'frizi-arcade') ?></a></li>
            <?php
        if (get_the_category_list()) { ?>
                        <li><a href="#"><?php
            _e('Categories', 'frizi-arcade') ?></a>
                            <ul class="sub-menu">
                <?php
            wp_list_categories('orderby=name&title_li='); ?> 
                            </ul>
                        </li>
            <?php
        } ?>
            <?php
        $sharelink = ot_get_option('sharelink', 'on');
        if ($sharelink == 'on') {
?>
                <li><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300"><?php
            _e('Share', 'frizi-arcade') ?></a>
                    <script type="text/javascript">var addthis_config = {"data_track_addressbar": false, ui_offset_top: -9999};</script>
                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
                </li>
            <?php
        } ?>
        </ul>
    <?php
    } 
    else { ?>
        
        <?php
        wp_nav_menu(array('theme_location' => 'primary', 'items_wrap' => '<ul id="%1$s" class="%2$s nav">%3$s</ul>', 'fallback_cb' => FALSE)) ?> 

    <?php
    } ?>

    <div class="nav-icon"></div>


    <?php
    if (ot_get_option('defmenu', 'on') == 'on') { ?>
        
       
        <div class="small-nav">
            <ul class='menu'>
                <?php
        $sharelink = ot_get_option('sharelink', 'on');
        if ($sharelink == 'on') {
?>
                    <li><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300"><?php
            _e('Share', 'frizi-arcade') ?></a>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar": false, ui_offset_top: -9999};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
                    </li>
                <?php
        } ?>
                <li><a href="<?php
        echo esc_url(home_url()) ?>"><?php
        _e('Home', 'frizi-arcade') ?></a></li>
                <li class="menu-item  menu-item-has-children"><a href="#"><?php
        _e('Categories', 'frizi-arcade') ?></a>
                    <ul class="sub-menu">
                        <?php
        wp_list_categories('orderby=name&title_li='); ?> 
                    </ul>
                </li>

            </ul>
        </div>
    <?php
    } 
    else { ?>
        
        <?php
        wp_nav_menu(array('theme_location' => 'mobile', 'container_class' => 'small-nav', 'fallback_cb' => FALSE)) ?> 

    <?php
    } ?>
    <?php
    get_search_form();
}

add_action('custom_header', 'custom_navigation');

add_action('init', 'clear_gamecache_links');

function clear_gamecache_links() {
    global $wpdb;
    if (is_admin() && current_user_can('manage_options')) {
        if (isset($_GET['clear_game_link_cache'])) {
            $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "games_links_pages");
            $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "games_link");
            add_action('admin_notices', 'arcade_pulse_clear_cache_notice');
        }
    }
}

function arcade_pulse_clear_cache_notice() {
    
    echo '<div class="updated"><p>Cache cleared!</p></div>';
}

function theme_link() {
    global $wpdb, $sponsorlink;
    
    if ($sponsorlink) {
        $sponsorlink = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "games_link2 WHERE id = $sponsorlink");
        
        if ($sponsorlink) {
            echo $sponsorlink->link_desc . ' <a href="' . $sponsorlink->link_a . '">' . $sponsorlink->link_text . '</a>';
        }
    }
}

/**
 * Geta ajax more load
 */
add_action('wp_ajax_infinite_scroll', 'get_games_infinite_scroll');
add_action('wp_ajax_nopriv_infinite_scroll', 'get_games_infinite_scroll');

if (!function_exists('get_games_infinite_scroll')) {
    
    function get_games_infinite_scroll() {
        global $game_post_type;
        
        $offset = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        
        if ($offset == 1) {
            $offset = 87;
        } 
        else {
            $offset = 87 + ($offset * 20);
        }
        
        $args = array('post_type' => $game_post_type, 'posts_per_page' => 60, 'offset' => $offset, 'post_status' => 'publish', 'ignore_sticky_posts' => true,);
        
        $sort = isset($_POST['sort']) ? $_POST['sort'] : 'date';
        
        if ($sort == 'most-played') {
            $args['meta_key'] = 'played';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } 
        elseif ($sort == 'top-rated') {
            $args['meta_key'] = 'ratings_average';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } 
        else {
            $args['orderby'] = 'date';
        }
        $args = wp_parse_args($_POST['querystring'], $args);
        
        $loop = new WP_Query($args);
        
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            
            // You are on the last page
            
            
        }
        if ($loop->have_posts()):
            $k = 0;
            while ($loop->have_posts()):
                $loop->the_post();
                
                if ($k == 0) {
                    echo '<div class="box">';
                }
                $k++;
                get_template_part('inc/repeater-list', 'small');
                
                if ($k == 4 OR ($loop->current_post + 1 == $loop->post_count)) {
                    echo '</div>';
                    $k = 0;
                }
            endwhile;
        endif;
        $current_page = $loop->get('paged');
        if (!$current_page) {
            $current_page = 1;
        }
        if ($current_page == $loop->max_num_pages) {
            echo '<div class="lastpage hidden"></div>';
        }
        exit();
    }
}

add_action('wp_head', 'cursor_style', 1);

function cursor_style() {
    echo "<style>body{cursor:url(" . get_stylesheet_directory_uri() . "/images/cursor1.png), auto}</style>";
}

function fritzi_modify_main_query($query) {
    
    global $game_post_type, $not_in_index;
    
    if ((!$query->is_singular()) && $query->is_main_query()) {
        
        // Run only on the homepage
        
        if (($query->is_home() or $query->is_front_page()) && ot_get_option('home_featured_thumbs', 'on') == 'on') {
            $query->query_vars['posts_per_page'] = 88;
            
            $query->set('post_type', array($game_post_type));
        } 
        else {
            $query->query_vars['posts_per_page'] = 84;
        }
        
        $query->query_vars['ignore_sticky_posts'] = true;
        
        $gameorder = get_query_var('gameorder', FALSE);
        if ($gameorder == FALSE) {
            if (isset($_GET['gameorder'])) {
                $gameorder = $_GET['gameorder'];
            }
        }
        
        if ($gameorder == 'played') {
            $query->query_vars['orderby'] = 'meta_value_num';
            $query->query_vars['meta_key'] = 'played';
            $query->query_vars['order'] = 'desc';
        } 
        elseif ($gameorder == 'rating') {
            
            $query->query_vars['orderby'] = 'meta_value_num';
            $query->query_vars['meta_key'] = 'ratings_average';
            $query->query_vars['order'] = 'desc';
        }
        
        return $query;
    }
}

add_action('pre_get_posts', 'fritzi_modify_main_query');

function get_related_games_posts_ids($post_id, $number = 5) {
    
    global $game_custom_cat;
    
    $related_ids = false;
    
    $post_ids = array();
    
    // get tag ids belonging to $post_id
    $tag_ids = wp_get_post_terms($post_id, $game_custom_cat, array('fields' => 'ids'));
    
    if ($tag_ids) {
        
        // get all posts that have the same tags
        $tag_posts = get_posts(array('posts_per_page' => - 1,
        
        // return all posts
        'no_found_rows' => true,
        
        // no need for pagination
        'fields' => 'ids',
        
        // only return ids
        'post__not_in' => array($post_id),
        
        // exclude $post_id from results
        'tax_query' => array(array('taxonomy' => $game_custom_cat, 'field' => 'id', 'terms' => $tag_ids, 'operator' => 'IN'))));
        
        // loop through posts with the same tags
        if ($tag_posts) {
            $score = array();
            $i = 0;
            foreach ($tag_posts as $tag_post) {
                
                // get tags for related post
                $terms = wp_get_post_terms($tag_post, $game_custom_cat, array('fields' => 'ids'));
                $total_score = 0;
                
                foreach ($terms as $term) {
                    if (in_array($term, $tag_ids)) {
                        ++$total_score;
                    }
                }
                
                if ($total_score > 0) {
                    $score[$i]['ID'] = $tag_post;
                    
                    // add number $i for sorting
                    $score[$i]['score'] = array($total_score, $i);
                }
                ++$i;
            }
            
            // sort the related posts from high score to low score
            uasort($score, 'sort_tag_score');
            
            // get sorted related post ids
            $related_ids = wp_list_pluck($score, 'ID');
            
            // limit ids
            $related_ids = array_slice($related_ids, 0, (int)$number);
        }
    }
    return $related_ids;
}

function sort_tag_score($item1, $item2) {
    if ($item1['score'][0] != $item2['score'][0]) {
        return $item1['score'][0] < $item2['score'][0] ? 1 : -1;
    } 
    else {
        return $item1['score'][1] < $item2['score'][1] ? -1 : 1;
        
        // ASC
        
        
    }
}
