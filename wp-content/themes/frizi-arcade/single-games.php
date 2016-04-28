<?php
/**
 * The Template for displaying games single posts.
 *
 * @package games
 */
global $game_post_type, $game_custom_cat, $game_custom_tag;
$game_preloader = ot_get_option('show_game_preloader', 'on');
$how_to_play_auto = ot_get_option('how_to_play_auto', 'on');
$ad_position = ot_get_option('singleadds','left');
get_header();



?>



<div class="pad"></div>
<div class="center">
    <div class="main-banner group">
        <?php $big_ad_code = ot_get_option('big_ad_code_');
            if (isset($big_ad_code)) {?>
                <div class="mb"><?php echo $big_ad_code ?></div>
            <?php } ?>
                
        <?php $ad_code = ot_get_option('rectangular_ad_code_');
            if (isset($ad_code)) {?>
                <div class="two-banner">
                    
                    
                </div>
                
            <?php } ?>        
        
    </div>
    <div class="play-wrap"  <?php if ($game_preloader == 'on') echo 'style="display: none;"' ?> id="game-window" >
        <?php custom_get_game($post->ID); ?>
        <div class="opt-box">
            <p><?php _e('Lights', 'frizi-arcade') ?></p>
            <div class="cheker"></div>
        </div>
        <div class="opt-box opt-box2">
            <p><?php _e('Fullscreen', 'frizi-arcade') ?></p>
            <a href="#" class="full-screen"></a> </div>
        <br class="clear">
    </div>
    <?php if (ot_get_option('how_to_play', 'on') == 'on') { ?>    
        <div id="how-to-play" class="how-to-play-box" style="display: none;" >


            <?php
            $customcode = ot_get_option('custom_how_to_play_code');


            if ($customcode && !empty($customcode)) {
                echo str_replace("##game_name##", $post->post_title, $customcode);
            } else {
                ?>
                <div class="codewrapper" style="position:relative;">
                    <script type="text/javascript" id="veediInit">
                        var _v, settings = {
                            game: "<?php echo $post->post_title ?>", // Game name (Variable)
                            publisherId: 74653833, // Publisher ID (provided by our side)
                            onVideoFound: function () { 	// perform an action if video found
                                jQuery('.but1.how-to-play').show();
        <?php if ($game_preloader == 'off' && $how_to_play_auto == 'on') { ?>
                                    jQuery('#how-to-play').show();
        <?php } ?>
                            },
                            onVideoNotFound: function () { 	// perform an action if video NOT found
                                jQuery('.but1.how-to-play').hide();
                                jQuery('#how-to-play').remove();
                            },
                            width: 728				// Veedi player width
                        };
                        (function (settings) {
                            var vScript = document.createElement('script');
                            vScript.type = 'text/javascript';
                            vScript.async = true;
                            vScript.src = 'http://www.veedi.com/player/embed/veediEmbed.js';
                            vScript.onload = function () {
                                _v = new VeediEmbed(settings);
                            };
                            var veedi = document.getElementById('veediInit');
                            veedi.parentNode.insertBefore(vScript, veedi);
                        })(settings);
                    </script>
                </div>  
    <?php }
    ?>
        </div>     
                <?php } ?>

    <div class="wrap2">
        <div class="game-box <?php if($ad_position == 'left'){ echo 'game-box2';}?>">
            <?php if($ad_position == 'left'){?>
                <div class="right">
                    <?php get_sidebar( 'adds' ); ?>
                </div>
            <?php } else { ?>
                <div class="left">
                   <?php get_sidebar( 'related' ); ?>
                </div>
            <?php } ?>
            <?php wp_reset_query(); ?>
            <div class="middle">
                <h2><?php the_title() ?></h2>
                <div class="game-buttons"> 
            <?php if ($game_preloader == 'on') { // check if preloaderis on   ?>
                    <div id="loader" class="loading play-but "></div> 
                    <script type="text/javascript">
                        var counter = 1;
                        var speedindex = 5;
                        var $loader = jQuery('#loader'),
                                $progressbar = jQuery('<div id="progressbarloadbg"/>'),
                                $progressstatus = jQuery('<span id="progressstatus"/>'),
                                $progresstext = jQuery('<span id="progresstext"/>').append('Loading'),
                                $loaded = jQuery('<a href="#" id="play" class="" />').html('<?php _e('Play', 'frizi-arcade') ?>');

                        $loader.append($progressbar, $progressstatus, $progresstext);

                        function loadgame(wait_time) {

                            if (counter < wait_time) {
                                counter = counter + 1;
                                var percentage = Math.round(counter / wait_time * 100);
                                $progressbar.width(percentage + '%');
                                $progressstatus.html(percentage + '% ');
                                window.setTimeout("loadgame('" + wait_time + "')", speedindex);
                            }
                            else {
                                counter = 1;
                                $loader.removeClass('loading').html($loaded).addClass('loaded');
                                jQuery('#loader.loaded').on("click", function (event) {
                                    

                                    jQuery('#game-window').slideToggle(1000);
                                    <?php if ($how_to_play_auto == 'on') { ?>
                                        jQuery('#how-to-play').slideToggle(1000);
                                     <?php } ?>

                                    event.preventDefault();
                                });
                            }
                        }
                        jQuery(document).ready(function () {
                            setTimeout('loadgame(5*100)', 1000);



                        });

                        jQuery('#loader a').on("click", function (event) {
                            event.preventDefault();
                        });
                    </script>
                <?php } ?>
                
                    
                    <?php if (ot_get_option('how_to_play', 'on') == 'on') {?>      
                        <a href="#how-to-play" class="but1 how-to-play howto-report" style="<?php if (!$customcode or empty($customcode)){     echo "display:none;"; }?>"  data-id='<?php echo $post->ID ?>'><span></span><?php _e('How to play?', 'arcade-puls') ?></a>
                    <?php } ?>    
                    
                </div>
<?php
$mabp_description = get_post_meta(get_the_ID(), 'mabp_description', true);
// check if the custom field has a value
if (!empty($mabp_description)) {
    ?>
                    <div class="desc"> <span><?php _e('Description:', 'frizi-arcade') ?></span> <?php echo $mabp_description; ?></div>
                    <?php } ?>

                <?php echo get_the_term_list($post->ID, $game_custom_cat, '<div class="options"> <span class="f">'.__('Category:', 'frizi-arcade').'</span> ', ', ', '</div>'); ?>
                 <?php echo get_the_term_list($post->ID, $game_custom_tag, '<div class="options"> <span class="f">'. __('Tags:', 'frizi-arcade').'</span>', ', ', '</div>'); ?>
                
                <div class="options"> <span class="f"><?php _e('Rating:', 'frizi-arcade') ?></span>
                    <?php
                        the_ratings('div', get_the_ID());
                    ?>
                </div>
                
                <div class="options">
                    <div class="soc-box">
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style">
                            <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                            <a class="addthis_button_tweet"></a>
                            <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        </div>
                        <script type="text/javascript">var addthis_config = {"data_track_addressbar": false};</script>
                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5034af7e16a1807b"></script>
                        <!-- AddThis Button END -->
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="hidden-banner"></div>
                <?php
                    $myterms = get_terms($game_custom_cat, 'orderby=count&hide_empty&order=DESC');
                    $term = strtolower($myterms[0]->name);
                    $exclude_ids = array(get_the_ID());

                    $link = get_term_link(intval($myterms[0]->term_id), $game_custom_cat);
                    $link = is_wp_error($link) ? '#' : $link;

                    $args = array('post_type' => $game_post_type, 'posts_per_page' => 8, 'paged' => 1, $game_custom_cat => $term, 'post__not_in' => $exclude_ids, 'ignore_sticky_posts' => TRUE);

                    $loop = new WP_Query($args);
                    if ($loop->have_posts()) : ?>
                <div class="similar">
                    <h4>Similar</h4>
                    <div class="sim-thumbs">
                         <?php
                        while ($loop->have_posts()) : $loop->the_post();
                            // Include the template for the content.
                            get_template_part('inc/repeater-list', 'small');
                        endwhile;
                        ?>
                        <br class="clear">
                    </div>
                </div>
                <?php endif; ?>
                <div class="line-x"></div>
<?php
// If comments are open or we have at least one comment, load up the comment template
wp_reset_query();
if (comments_open() || '0' != get_comments_number()) :
    comments_template();
endif;
?>


            </div>
          
                <?php if($ad_position == 'left'){?>
                    <div class="left">
                        <?php get_sidebar( 'related' ); ?>
                    </div>
                <?php } else { ?>
                    <div class="right">
                        <?php get_sidebar( 'adds' ); ?>
                    </div>    
                <?php } ?>     
                 
                
                    
            
        </div>
    </div>
</div>

</div>
<div class="clear"></div>
<?php get_footer(); ?>
