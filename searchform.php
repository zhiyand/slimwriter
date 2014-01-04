<form role="search" method="get" id="searchform" action="<?php echo home_url();?>">
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" style="width: 120px;" placeholder="<?php _e('Search', 'slimwriter');?>...">
	<input type="submit" id="searchsubmit" value="<?php _e('Go', 'slimwriter');?>">
</form>
