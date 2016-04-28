<?php
global $post;
global $countbig;
$countbig++;
?>
<div class="box" id="bt<?php echo $countbig ?>">
    <div <?php post_class('big-thumb'); ?> ><a href="<?php echo get_permalink($id) ?>">
        <?php get_game_thumbnail('big-game-thumb', $class = '', $id) ?><span class="big-title">
            <?php get_game_title(20, true, $id); ?></span></a>
        <div class="over"></div>
        <div class="over-in"></div>
    </div>
</div>