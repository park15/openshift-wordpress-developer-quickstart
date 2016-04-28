<?php
global $id;
?>


<div <?php post_class('thumb'); ?>  data-id="<?php echo $id; ?>" >
    <a href="<?php echo get_permalink($id) ?>" class="thumb-holder">
        <?php get_game_thumbnail('game-thumb', $class = '', $id) ?>
        <?php if (games_is_game_new($post->ID)) { ?><em class="new"><?php } ?></em>
    </a>
    <div class="metathumb">
        <a href="<?php echo get_permalink($id) ?>" class="thumb-title"><?php get_game_title(19, true, $id); ?></a>
        <?php if (function_exists('the_ratings') && (ot_get_option('show_rating','off') == 'on')) {the_ratings();} ?>
    </div>    
    <div class="over"></div>
    <div class="over-in"></div>
</div>