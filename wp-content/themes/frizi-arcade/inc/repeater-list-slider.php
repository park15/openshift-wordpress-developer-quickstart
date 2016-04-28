<?php
global $id;
?>

<li>
	<div href="<?php echo get_permalink($id) ?>" class="thumb-slider">
		<a href="<?php echo get_permalink($id) ?>" class="ts-over">
			<strong></strong></a><a href="#"><?php  if(has_post_thumbnail()) get_game_thumbnail($width = 168, $height = 140, $class = '', $id) ?>
				<span><?php get_game_title(20, true, $id); ?></span></a>
	</div>
</li>