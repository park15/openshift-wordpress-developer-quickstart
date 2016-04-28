<?php
/**
* Plugin Name: Game Custom Post Type
* Description: Adds custom post types for Games Arcade plugin
* Version: 1
*/

add_action( 'init', 'register_my_cpt_game' );
/**
 * Register a game post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function register_my_cpt_game() {
    $labels = array(
      'name'               => _x( 'Games', 'post type general name' ),
      'singular_name'      => _x( 'Game', 'post type singular name' ),
      'menu_name'          => _x( 'Games', 'admin menu' ),
      'name_admin_bar'     => _x( 'Game', 'add new on admin bar' ),
      'add_new'            => _x( 'Add New', 'add new game' ),
      'add_new_item'       => __( 'Add New Game' ),
      'new_item'           => __( 'New Game' ),
      'edit_item'          => __( 'Edit Game' ),
      'view_item'          => __( 'View Game' ),
      'all_items'          => __( 'All Games' ),
      'search_items'       => __( 'Search Games' ),
      'parent_item_colon'  => __( 'Parent Games:' ),
      'not_found'          => __( 'No games found.' ),
      'not_found_in_trash' => __( 'No games found in Trash.' ),
    );

    $args = array(
      'labels'             => $labels,
      'description' => 'Game custom post type for arcade plugin',
      'map_meta_cap' => true,
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'show_in_menu'       => true,
      'query_var'          => true,
      'menu_icon' 			=> 'http://juegosdevestir365.com/wp-content/plugins/myarcadeplugin/core/images/arcade.png',
      'rewrite'            => array( 'slug' => 'juego' ),
	  'query_var' => true,
      'capability_type'    => 'post',
      'has_archive'        => true,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'editor', 'author', 'thumbnail','custom-fields','comments')
    );

    register_post_type( 'game', $args );
}
// disable wysiwyg for cpt game so not to break template with custom html
add_filter( 'user_can_richedit', 'disable_for_cpt' );
function disable_for_cpt( $default ) {
    global $post;
    if ( 'game' == get_post_type( $post ) )
        return false;
    return $default;
}

/*
for more information on taxonomies, go here:
http://codex.wordpress.org/Function_Reference/register_taxonomy
*/

// hook into the init action and call register_game_taxonomies when it fires
add_action( 'init', 'register_game_taxonomies', 0 ); 

// create two taxonomies, genres and writers for the post type "book"
function register_game_taxonomies() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
      'name'              => _x( 'Game categories', 'taxonomy general name' ),
      'singular_name'     => _x( 'Game category', 'taxonomy singular name' ),
      'search_items'      => __( 'Search Genres' ),
      'all_items'         => __( 'All Game Categories' ),
      'parent_item'       => __( 'Parent Game Category' ),
      'parent_item_colon' => __( 'Parent Game Category:' ),
      'edit_item'         => __( 'Edit Game Category' ),
      'update_item'       => __( 'Update Game Category' ),
      'add_new_item'      => __( 'Add New Game Category' ),
      'new_item_name'     => __( 'New Game Category Name' ),
      'menu_name'         => __( 'Game categories' ),
    );

    $args = array(
      'hierarchical'      => true,
      'labels'            => $labels,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'rewrite'           => array( 'slug' => 'game_category' ),
    );

    register_taxonomy( 'game_categories', 'game', $args );

    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
      'name'                       => _x( 'Game Tags', 'taxonomy general name' ),
      'singular_name'              => _x( 'Game Tag', 'taxonomy singular name' ),
      'search_items'               => __( 'Search Game Tags' ),
      'popular_items'              => __( 'Popular Game Tags' ),
      'all_items'                  => __( 'All Game Tags' ),
      'parent_item'                => null,
      'parent_item_colon'          => null,
      'edit_item'                  => __( 'Edit Game Tag' ),
      'update_item'                => __( 'Update Game Tag' ),
      'add_new_item'               => __( 'Add New Game Tag' ),
      'new_item_name'              => __( 'New Writer Game Tag' ),
      'separate_items_with_commas' => __( 'Separate Game Tags with commas' ),
      'add_or_remove_items'        => __( 'Add or remove Game Tags' ),
      'choose_from_most_used'      => __( 'Choose from the most used Game Tags' ),
      'not_found'                  => __( 'No Game Tags found.' ),
      'menu_name'                  => __( 'Game Tags' ),
    );

    $args = array(
      'hierarchical'          => false,
      'labels'                => $labels,
      'show_ui'               => true,
      'show_admin_column'     => true,
      'update_count_callback' => '_update_post_term_count',
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'tag' ),
    );

    register_taxonomy( 'game_tags', 'game', $args );
}
?>