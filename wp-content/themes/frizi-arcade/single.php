<?php
/**
 * The Template for displaying all single posts.
 *
 * @package games
 */
/* refirect to game template */
if (get_post_meta($post->ID, 'mabp_game_tag', true) or get_post_meta($post->ID, 'game_code', true) or get_post_meta($post->ID, 'mabp_swf_url', true)) {

    get_template_part('single', 'games');
    exit;
}

get_header(); ?>
<div class="pad"></div>
	<div id="primary" class="content-area center">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
            <div class="wrap2">
                <div class="page-content-wrapper">
                    <?php get_template_part( 'content' ); ?>
                  
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() ) :
						comments_template();
					endif;
				?>
            </div>   
            </div>    

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
