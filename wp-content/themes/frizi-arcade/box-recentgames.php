<?php
/**
 * The template for displaying most recent games.
 *
 * @package games
 */
global $game_post_type;
?> 
<div class="block1">
    <div class="header">
        <h3><?php _e('Most Played', 'frizi-arcade') ?></h3>
        <div class="header-bar"><a href="#" class="back">&lt;</a> <a href="#" class="next">&gt;</a></div>
    </div>
    <div id="most_played_games" class="thumbs-small-wrap ">

        <div class="small-thumbs-wrap"  
             data-action="juego_ajax_load_mostplayed"
             data-path="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php"
             data-page="1"
             data-display-posts="8"
             data-range="<?php echo $boxTimeRange; ?>">
            <div class="small-thumbs">
                <?php
                $args = array();
                // - Set up our variables
                $numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 8;
                $page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;

                $args = array(
                    'post_type' => $game_post_type,
                    'posts_per_page' => $numPosts,
                    'paged' => $page,
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'post_status' => 'publish',
                    'ignore_sticky_posts' => true,
                );
                $loop = new WP_Query($args);
                if ($loop->have_posts()) :

                    while ($loop->have_posts()) : $loop->the_post();
                        // Include the template for the content.
                        get_template_part('inc/repeater-list', $template);
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>