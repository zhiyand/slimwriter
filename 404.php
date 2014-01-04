<?php get_header();?>

<header>
	<h1><?php _e('404 - Nothing Found', 'slimwriter');?></h1>
</header>
<article>
	<p><?php _e("The content you're looking for is probably deleted or does not exist. Sorry, buddy.", 'slimwriter');?></p>
	<p><?php _e('Maybe you can try to search the site using the following form.', 'slimwriter');?></p>

	<?php get_search_form();?>
</article>

<?php get_sidebar();?>

<?php get_footer();?>
