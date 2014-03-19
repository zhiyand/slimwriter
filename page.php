<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<?php get_template_part('content', 'page'); ?>

<?php endwhile; else:?>

<h4><?php _e("The content you're looking for does not exist.", 'slimwriter');?></h4>

<?php endif;?>

<?php get_sidebar();?>

<?php get_footer();?>
