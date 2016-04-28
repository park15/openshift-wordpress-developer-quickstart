<div class="search-icon"></div>
<div class="search">
	<div class="search-over">
		<form method="get" role="search" action="<?php echo esc_url(home_url('/')); ?>" id="searchform">
			<input type="text"  id="s" class="in1" name="s" placeholder="<?php _e('Search...', 'frizi-arcade') ?>" value="<?php get_search_query(); ?>">
			<input type="submit" class="go" name="submit" value="">
		</form>
	</div>
</div>