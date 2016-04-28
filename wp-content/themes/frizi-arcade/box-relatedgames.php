<!-- #recent_games.thumbs-small-wrap -->
<?php $myterms = get_terms('game_categories', 'orderby=date&hide_empty'); $term = strtolower($myterms[0]->name); ?>
<?php is_single() ? $exclude_ids = array( get_the_ID() ): $exclude_ids = array(); ?>

<div id="recent_games" class="thumbs-small-wrap">
    <div class="header-st">
        <p>Juegos relacionados</p>
        <div class="snav">
            <div class="arr">
                <button class="l">&lt;</button>
                <button class="r">&gt;</button>
            </div>
            <a class="snbut" href="/<?php echo $term; ?>/">ver todo</a></div>
    </div>
    <div class="thumbs-small"
         data-action="juego_ajax_load_related"
         data-path="<?php echo get_site_url(); ?>/wp-admin/admin-ajax.php"
         data-taxonomy="game_categories"
         data-tag="<?php echo $term; ?>"
         data-page="1"
         data-display-posts="8"
         data-exclude="<?php echo implode (',',$exclude_ids); ?>"
      >
        <div class="reveal">
            <?php if (function_exists('get_related_games')) {
                $args = array('post_type' => 'game', 'posts_per_page' => 8, 'paged' => 1, 'game_categories' => $term, 'post__not_in' => $exclude_ids );
                get_related_games($args);
            }
            ?>
        </div>
    </div>
</div>
<!--/#recent_games.thumbs-small-wrap -->