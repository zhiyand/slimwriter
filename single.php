<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php get_template_part('content', 'post'); ?>

<nav class="pager">
	<div class="nav-prev"><?php next_post_link( '%link', __( '<span class="meta-nav">&laquo;</span> Previous Post', 'slimwriter' ) ); ?></div>
	<div class="nav-next"><?php previous_post_link( '%link', __( 'Next Post <span class="meta-nav">&raquo;</span>', 'slimwriter' ) ); ?></div>
</nav>

<?php endwhile; else:?>

<h4><?php _e("The content you're looking for does not exist.", 'slimwriter');?></h4>

<?php endif;?>

<?php get_sidebar();?>

<?php get_footer();?>
