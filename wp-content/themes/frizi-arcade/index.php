<?php
/*
  Template Name: Home page
 */

$i = 0;
$is_404 = is_404();
global $query_string, $game_post_type, $not_in_index;
if ($is_404){
    header("HTTP/1.0 404 Not Found");
    $fileextension = pathinfo($_SERVER["REQUEST_URI"], PATHINFO_EXTENSION );
      if (in_array($fileextension, array('jpg','png','bmp','gif','mov'))) {
    // If the requested resource does not have a .php extension, include the standard error doc and exit
    _e('File not found', 'frizi-arcade');
    exit;
  }

}  

get_header();




?>
<div class="temp">
                <?php

                if ((is_home() or is_front_page()) &&  ot_get_option('home_featured_thumbs','off') == 'on') {
                
                    
                    
                    $args = array(
                        'post_type' => $game_post_type,
                        'posts_per_page' => 5,
                        'meta_key' => '_is_ns_featured_post',
                        'meta_value' => 'yes',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => true,
                        );

                    $loop = new WP_Query($args);
                    ?>

                    <?php if ($loop->have_posts()) : ?>


                        <?php
                        while ($loop->have_posts()) : $loop->the_post();
                            // Include the template for the content.
                        get_template_part('inc/repeater-list', 'big');

                        $not_in_index [] = $post->ID;
                        endwhile;
                        ?>

                        <?php
                        else:
                            $args = array(
                                'post_type' => $game_post_type,
                                'posts_per_page' => 5,
                                'paged' => 1,
                                'meta_key' => 'ratings_average',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'post_status' => 'publish',
                                'ignore_sticky_posts' => true,
                                'meta_query' => array(
                                    array(
                                        'key' => 'ratings_average',
                                        'compare' => 'EXISTS'
                                        )
                                    )
                                );
                        $loop = new WP_Query($args);
                        ?>

                        <?php if ($loop->have_posts()) : ?>


                            <?php
                            while ($loop->have_posts()) : $loop->the_post();
                                // Include the template for the content.
                            get_template_part('inc/repeater-list', 'big');
                            $not_in_index [] = $post->ID;
                            endwhile;
                            ?>
                            ?>

                            <?php
                            endif;
                            endif;
                } // end if is home or front page
                
                ?>
                <?php wp_reset_query(); ?>



                <?php
                $ad_code = ot_get_option('rectangular_ad_code_');
                if (isset($ad_code) && !is_single()) {
                    ?>
                    <div class="box bann" id="ban1">
                        <div class="thumb-banner"><?php echo $ad_code ?></div>
                    </div>

                    <div class="box bann" id="ban2">
                        <div class="thumb-banner"><?php echo $ad_code ?></div>
                    </div>


                    <div class="box bann" id="ban3">
                        <div class="thumb-banner"><?php echo $ad_code ?></div>
                    </div>
                    <?php } ?>  
                </div><!-- end of .temp -->


<div class="pad"></div>


<div class="thumbs-wrap">
    <div class="thumbs" data-page="1"  data-query-string="<?php echo $query_string . $metakey; ?>">

        <?php
        if ($is_404 == true) {
            $query_string = 'post_type=' . $game_post_type;
            ?>
            <section class="error-404 not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php _e('Oops! That page can&rsquo;t be found.', 'frizi-arcade'); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content entry-content">
                    <p><?php _e('It looks like nothing was found at this location. Maybe try one of the games below or a search?', 'frizi-arcade'); ?></p>

                </div><!-- .page-content -->
            </section><!-- .error-404 -->
        <?php } ?>


        <?php
        if($is_404 == true){
            global $wp_query;
            $args = array_merge( $wp_query->query_vars, array( 'post_type' => $game_post_type, 'name' => '' , 'posts_per_page' => '84' ) );
            
            query_posts( $args );
            $is_404 = true;
        }
        global $wp_query;
        $args = array_merge( $wp_query->query_vars, array( 'post__not_in' => $not_in_index ) );

        query_posts( $args );
        // For CTR Plugin
        $loop = clone $wp_query;
        
        if($_SERVER['REQUEST_URI'] == '/'){
            if(function_exists('GetPostsCTRIndex')){
                $loop = GetPostsCTRIndex();
            }
        }
            
        if(is_category()){
            if(function_exists('GetPostsCTRCategory')){
                $loop = GetPostsCTRCategory();
            }
        }
        
        if(is_tag()){
            if(function_exists('GetPostsCTRTag')){
               $loop = GetPostsCTRTag();
            }   
        }
        // End CTR Plugin
        
        if ($loop->have_posts()) :
            ?>

            <?php
            while ($loop->have_posts()) : $loop->the_post();

                if ($i == 0) {
                    echo '<div class="box">';
                }
                $i++;
                ?>
                <?php get_template_part('inc/repeater-list', 'small') ?>

                <?php
                if ($i == 4 OR ( $wp_query->current_post + 1 == $wp_query->post_count)) {
                    echo '</div>';
                    $i = 0;
                }
                ?>

            <?php endwhile; ?>     



            <br class="clear">
            <d
                <?php
                else:
                    get_template_part('content', 'none');
                endif;
                ?>
            </div>
    <br class="clear">
</div>
<?php wp_reset_query(); ?>
    <?php if (is_home() or is_front_page()) { ?>
    <div class="preload" id="inifiniteLoader" ><img src="<?php echo get_template_directory_uri() ?>/images/preloader.gif" width="256" height="51" alt=""/></div>
        <?php
    } else {
        if ($is_404 == false){
            games_pagination();
        } 
    }
    ?>    
</div>





<?php get_footer(); ?>
