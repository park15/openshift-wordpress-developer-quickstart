<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package games
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$comenttype = ot_get_option( 'comments',  'normal' ); 
?>
<?php if ($comenttype == 'facebook'): ?>
	
<div class="fb-comments facebook-box">
    <div class="fb-comments" data-href="<?php the_permalink() ?>" data-width="100%" data-numposts="5" data-colorscheme="<?php echo ot_get_option( 'background_style',  'light' ) ?>"></div>
</div>
<div class="clear"></div>
<?php else: ?>
<div id="comments" class="comments-area">
	
	<?php // You can start editing here -- including this comment! ?>
    <div class="options"> <span class="f"><?php _e('Comments:', 'frizi-arcade')	?></span> </div>
	
		<?php
	$comments_args = array(
            // change the title of send button 
            'label_submit'=>__('Add comment','frizi-arcade'),
            'comment_notes_before' => '',
            // remove "Text or HTML to be displayed after the set of comment fields"
            'comment_notes_after' => '',
            // redefine your own textarea (the comment body)
            'title_reply' => '',
            'comment_field' => '<div class="textarea"><div><textarea id="comment" name="comment" placeholder="'.__('Comment','frizi-arcade').'"></textarea></div></div>',        
            'fields' => array(
				'author' => '<div class="input"><div><input class="field name" id="author" name="author" type="text" value="" placeholder="'.__('Your name*','frizi-arcade').'" /></div></div>',
				'email' => '<div class="input"><div><input class="field email" id="email" name="email" type="text" value="" placeholder="'.__('Your email*','frizi-arcade').'" /></div></div>',
				'url' => '<div class="input"><div><input class="field website" id="url" name="url" type="text" value=""  placeholder="'.__('Your website','frizi-arcade').'"  /></div></div>' 
			),
    );
    echo '<div class="com-wrap">';
        comment_form($comments_args);
    echo '</div>';
    ?>
	
	<?php if ( have_comments() ) : ?>
		

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
            <div class="options"><?php _e( 'Comment navigation', 'frizi-arcade' ); ?><div>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'frizi-arcade' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'frizi-arcade' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'short_ping' => true,
					'callback' => 'games_custom_comment'
				) );
			?>
		</ul><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<div class="options"><?php _e( 'Comment navigation', 'frizi-arcade' ); ?></div>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'frizi-arcade' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'frizi-arcade' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'frizi-arcade' ); ?></p>
	<?php endif; ?>

	

</div><!-- #comments -->
<?php endif; ?>