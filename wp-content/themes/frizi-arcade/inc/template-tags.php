<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package games
 */
if (!function_exists('games_paging_nav')) :

/**
 * Display navigation to next/previous set of posts when applicable.
 */
function games_paging_nav() {
// Don't print empty markup if there's only one page.
if ($GLOBALS['wp_query']->max_num_pages < 2) {
return;
}
?>
<nav class="navigation paging-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e('Posts navigation', 'frizi-arcade'); ?></h1>
    <div class="nav-links">

        <?php if (get_next_posts_link()) : ?>
        <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', 'frizi-arcade')); ?></div>
        <?php endif; ?>

        <?php if (get_previous_posts_link()) : ?>
        <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', 'frizi-arcade')); ?></div>
        <?php endif; ?>

    </div><!-- .nav-links -->
</nav><!-- .navigation -->
<?php
}

endif;

if (!function_exists('games_post_nav')) :

/**
 * Display navigation to next/previous post when applicable.
 */
function games_post_nav() {
// Don't print empty markup if there's nowhere to navigate.
$previous = ( is_attachment() ) ? get_post(get_post()->post_parent) : get_adjacent_post(false, '', true);
$next = get_adjacent_post(false, '', false);

if (!$next &&!$previous) {
return;
}
?>
<nav class="navigation post-navigation" role="navigation">
    <h1 class="screen-reader-text"><?php _e('Post navigation', 'frizi-arcade'); ?></h1>
    <div class="nav-links">
        <?php
        previous_post_link('<div class="nav-previous">%link</div>', _x('<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'frizi-arcade'));
        next_post_link('<div class="nav-next">%link</div>', _x('%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'frizi-arcade'));
        ?>
    </div><!-- .nav-links -->
</nav><!-- .navigation -->
<?php
}

endif;

if (!function_exists('games_posted_on')) :

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function games_posted_on() {
$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
if (get_the_time('U') !== get_the_modified_time('U')) {
$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
}

$time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
);

$posted_on = sprintf(
_x('Posted on %s', 'post date', 'frizi-arcade'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
);

$byline = sprintf(
_x('by %s', 'post author', 'frizi-arcade'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
);

echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function games_categorized_blog() {
if (false === ( $all_the_cool_cats = get_transient('games_categories') )) {
// Create an array of all the categories that are attached to posts.
$all_the_cool_cats = get_categories(array(
'fields' => 'ids',
 'hide_empty' => 1,
 // We only need to know if there is more than one category.
'number' => 2,
));

// Count the number of categories that are attached to the posts.
$all_the_cool_cats = count($all_the_cool_cats);

set_transient('games_categories', $all_the_cool_cats);
}

if ($all_the_cool_cats > 1) {
// This blog has more than 1 category so games_categorized_blog should return true.
return true;
} else {
// This blog has only 1 category so games_categorized_blog should return false.
return false;
}
}

/**
 * Flush out the transients used in games_categorized_blog.
 */
function games_category_transient_flusher() {
// Like, beat it. Dig?
delete_transient('games_categories');
}

add_action('edit_category', 'games_category_transient_flusher');
add_action('save_post', 'games_category_transient_flusher');

/**
 * Get game width
 */
function get_game_width($echo = false) {
global $post;
$width = get_post_meta($post->ID, 'mabp_width', true);
if (empty($width) ||!is_numeric($width))
return false;
if ($echo)
echo $width;
else
return $width;
}

/**
 * Get game height
 */
function get_game_height($echo = false) {
global $post;
$height = get_post_meta($post->ID, 'mabp_height', true);
if (empty($height) ||!is_numeric($height))
return false;
if ($echo)
echo $height;
else
return $height;
}

/**
 * Get game ratio
 */
function get_game_ratio($echo = false) {
$return = get_game_width() / get_game_height();
if ($echo)
echo $return;
else
return $return;
}

/**
 * Get game description
 */
function get_game_description($echo = false, $id = '') {
global $post;
$ID = !empty($id) ? $id : $post->ID;
$description = get_post_meta($ID, 'mabp_description', true);
if (empty($description))
return false;

if ($echo)
echo $description;
else
return $description;
}

/**
 * Get game description
 */
function get_game_instructions($echo = false, $id = '') {

global $post;
$ID = !empty($id) ? $id : $post->ID;
$instructions = get_post_meta($ID, 'mabp_instructions', true);
//if ( empty($instructions) ) return false;
if ($echo)
echo $instructions;
else
return $instructions;
}

/**
 * Get game image
 */
function get_game_thumbnail($thumbsize = 'game-thumb', $class = '', $id = '', $echo = true) {
global $post;
$img = '';

$class = !empty($id) ? 'class="' . $class . ' thumbnailimage center-cropped' : 'thumbnailimage center-cropped';
$ID = !empty($id) ? $id : $post->ID;



$thumb_id = get_post_thumbnail_id();
if ($thumb_id) {
$thumb_url_array = wp_get_attachment_image_src($thumb_id, $thumbsize, true);
$thumbnail = $thumb_url_array[0];
} else {
$thumbnail = get_post_meta($ID, "mabp_thumbnail_url", true);
}


if (preg_match('|^(http).*|i', $thumbnail) == 0) {
// No Thumbail available.. get the default thumb
$thumbnail = get_template_directory_uri() . '/images/def_thumb.png';
}

$args = array('before' => '', 'after' => '', 'echo' => false);
$img = '<span style="background-image: url(' . $thumbnail . ')" '. $class . ' alt="' . the_title_attribute($args) . '" /></span>';

if ($echo)
echo $img;
else
return $img;
}

/**
 * Get game excerpt
 */
function get_game_excerpt($length = 55, $id = '', $echo = true) {
$data = get_game_description(false, $id);
$text = strip_shortcodes($data);
$text = wp_trim_words($text, $length, '...');

if ($echo)
echo $text;
else
return $text;
}

/**
 * Get game title trimed
 */
function get_game_title($chars = 0, $echo = false, $id = '') {
global $post;
$ID = !empty($id) ? $id : $post->ID;

$es_title = get_post_meta($ID, '_juego_game_title_es', true);
$title = !empty($es_title) ? $es_title : get_the_title($ID);
$title = strip_tags($title);

if ($chars > 0) {
if ((strlen($title) > $chars)) {
$title = mb_substr($title, 0, $chars);
//$title = mb_substr($title, 0, -strlen(strrchr($title, ' '))); // Wordwrap

if (strlen($title) < 4) {
$title = mb_substr(the_title('', '', false), 0, $chars);
}
$title .= '..';
}
}

if ($echo)
echo $title;
else
return $title;
}

if (!function_exists('games_pagination')) :

function games_pagination() {
global $wp_query;

if ($GLOBALS['wp_query']->max_num_pages < 2) {
return;
}

$big = 999999999; // need an unlikely integer
echo "<div class='pagination'>";
echo paginate_links(array(
'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
 'format' => '?paged=%#%',
 'current' => max(1, get_query_var('paged')),
 'total' => $wp_query->max_num_pages,
 'type' => 'list',
 'next_text' => '>>',
 'prev_text' => '<<',
));
echo "</div>";
}

endif;

if (!function_exists('custom_get_game')) :

function custom_get_game($game_id = false) {
$padding = '';

$height = get_post_meta($game_id, 'mabp_height', true);
$width = get_post_meta($game_id, 'mabp_width', true);

if($height && $width){
$padding = ($height/$width) *100;
}
?>
<div class="game <?php
if ('on' == ot_get_option('game_border', 'off')) {
echo 'border';
}
?>" >    
    <div class="gamewrapper" style="padding-bottom: <?php echo $padding ?>%">
        <a href="#" id="close-fullscreen" class="but1"><span></span><?php _e('Close', 'arcade-puls') ?></a>
        <?php
        $fullcreentopbannere = ot_get_option( 'full_screen_top_code_');
        if($fullcreentopbannere){
            echo '<div class="fullscreen-top" >'.$fullcreentopbannere.'</div>';
        }

        $customcode = get_post_meta($game_id, 'game_code', true);
        if ($customcode &&!empty($customcode)) {
            echo $customcode;
        } else {
               if (function_exists('get_game')) {
                    /* mypostid global is needed for MyScoresPresenter */
                    echo myarcade_get_leaderboard_code();
                    echo get_game($game_id);
                } else {
                    $file = get_post_meta($game_id, 'mabp_swf_url', true);
                    $filetype = wp_check_filetype($file);
                    if ($filetype['ext'] == 'swf'){
                    ?>
                    <embed src="<?php echo get_post_meta($game_id, 'mabp_swf_url', true) ?>" wmode="direct" menu="false" quality="high"  allowscriptaccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                    <?php } elseif ($filetype['ext'] == 'unity' or $filetype['ext'] == 'unity3d'){ ?>

                    <script type="text/javascript" src="http://webplayer.unity3d.com/download_webplayer-3.x/3.0/uo/UnityObject.js"></script>
                    <script type="text/javascript">

                        function GetUnity() {
                            if (typeof unityObject != "undefined") {
                                return unityObject.getObjectById("unityPlayer");
                            }
                            return null;
                        }
                        if (typeof unityObject != "undefined") {
                            unityObject.embedUnity("unityPlayer", "<?php echo $file ?>", '100%', '100%');

                        }

                    </script>
                    <div class="content">
                        <div id="unityPlayer">
                            <div class="missing">
                                <a href="http://unity3d.com/webplayer/" title="Unity Web Player. Install now!" class="instalplayer">
                                    <img alt="Unity Web Player. Install now!" src="http://webplayer.unity3d.com/installation/getunity.png" width="193" height="63" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <?php 
                    } elseif ($filetype['ext'] == 'dcr'){
                    ?>


                    <OBJECT classid="clsid:166B1BCA-3F9C-11CF-8075-444553540000"
                            codebase="http://download.macromedia.com/pub/shockwave/cabs/director/sw.cab#version=8,5,1,0"
                            ID=esc_apps_intro_001 WIDTH=100% HEIGHT=100% VIEWASTEXT>
                        <param name=src value="<?php echo $file ?>">
                        <PARAM NAME=swStretchStyle VALUE=none>

                        <EMBED SRC="<?php echo $file ?>" bgColor=#303D5D WIDTH=100% HEIGHT=100% swRemote="swSaveEnabled='false' swVolume='false' swRestart='false' swPausePlay='false' swFastForward='false' swContextMenu='false' " swStretchStyle=none
                               TYPE="application/x-director" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/"></EMBED>
                    </OBJECT>

                <?php } 

            } 
        } 

        $fullcreenbottombannere = ot_get_option( 'full_screen_bottom_code_');
        if($fullcreenbottombannere){
        echo '<div class="fullscreen-bottom" >'.$fullcreenbottombannere.'</div>';
        }
        ?> 


    </div>
    <a href="#" class="report-but" data-id='<?php echo $game_id ?>'><?php _e( 'Report Broken', 'frizi-arcade' ) ?></a>        
</div>
<?php
}





endif;
