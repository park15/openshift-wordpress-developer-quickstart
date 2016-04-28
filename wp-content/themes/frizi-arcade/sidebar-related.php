<?php
/**
 * The Sidebar containing related games
 *
 * @package games
 */

global $game_post_type, $game_custom_cat, $game_custom_tag;
wp_reset_query();
$exclude_ids = array(get_the_ID());
$related = get_related_games_posts_ids( $post->ID, 8 );


$args = array('post_type' => $game_post_type, 'posts_per_page' => 8, 'paged' => 1,'post__in' => $related, 'orderby' => 'post__in' , 'post__not_in' => array($post->ID), 'ignore_sticky_posts' => TRUE);


$loop = new WP_Query($args);
if ($loop->have_posts()) :
	?>
<h3><?php _e('Similar', 'frizi-arcade') ?></h3>
<div class="thumbs-game" id="smilar-games" >
	<?php
	while ($loop->have_posts()) : $loop->the_post();
                            // Include the template for the content.
	get_template_part('inc/repeater-list', 'small');
	endwhile;
	?>
</div>
<?php endif; ?>