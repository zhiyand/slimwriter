<?php get_header();?>
<div class="pane-primary concavebox">
    <h1 class="pane-title"><?php bloginfo('name');?></h1>
    <div class="pane-content">
        <p><?php bloginfo('description');?></p>
    </div>
</div>
<?php if(have_posts()): while(have_posts()) : the_post(); ?>

<?php get_template_part('content', get_post_type());?>

<?php endwhile; else:?>
<?php endif;?>

<ul class="pager">
    <li class="previous"><?php next_posts_link('&laquo; '. _x('Older Posts', 'post navigation', 'slimwriter')); ?></li>
    <li class="next"><?php previous_posts_link(_x('Newer Posts', 'post navigation', 'slimwriter') . ' &raquo;' ); ?></li>
</ul>

<?php get_sidebar();?>
<?php get_footer();?>
