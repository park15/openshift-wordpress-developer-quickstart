<?php
/**
 * The template for displaying most played games.
 *
 * @package games
 */
global $game_post_type;
?>
<div class="block1"  id="most_played_games" >
    <div class="header">
        <h3><?php _e('Most Played', 'frizi-arcade') ?></h3>
        <?php
        $args = array();
        // - Set up our variables
        $numPosts = (isset($_GET['numPosts'])) ? $_GET['numPosts'] : 12;
        $page = (isset($_GET['pageNumber'])) ? $_GET['pageNumber'] : 1;

        $args = array(
            'post_type' => $game_post_type,
            'posts_per_page' => $numPosts,
            'paged' => $page,
            'meta_key' => 'played',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'meta_query' => array(
                
                array(
                    'key' => 'played',
                    'compare' => 'EXISTS'
                )
            )
        );
        $loop = new WP_Query($args);
        if ($loop->have_posts()) :
            ?>

            <div class="header-bar"
                 data-action="games_ajax_load_mostplayed"
                 data-page="1"
                 data-post_per_page="<?php echo $numPosts ?>"
                 data-nonce="<?php echo wp_create_nonce("games_ajax_load_more_nonce"); ?>">
                <a href="#" class="back inactive ajaxbutton">&lt;</a> 
                <a href="#" class="next ajaxbutton <?php if ($loop->max_num_pages < 2) echo' inactive ' ?>">&gt;</a>
            </div>
<?php endif; ?>	
    </div>
    <div class="thumbs-small-wrap ">

        <div class="small-thumbs-wrap">
            <div class="small-thumbs">
                <?php
                if ($loop->have_posts()) :

                    while ($loop->have_posts()) : $loop->the_post();
                        // Include the template for the content.
                        get_template_part('inc/repeater-list', 'small');
                    endwhile;

                endif;
                ?>
            </div>
        </div>
    </div>
</div>	
