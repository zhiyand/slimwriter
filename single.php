<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post();
$nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>

<header>
	<h1><?php the_title();?></h1>
</header>
<article>
	<?php if($nail):?>

	<section class="featured-img"><?php echo $nail; ?></section>

	<?php endif; // nail ?>

	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
</article>
<aside class="article-meta">
	<div class="avatar"><?php echo get_avatar( get_the_author_meta('user_email'), 48); ?></div>
	<p><span class="icon-user"> <?php _e('Author', 'slimwriter');?></span> : <?php the_author_link();?>, <span class="icon-calendar"> <?php _e('Published at', 'slimwriter');?></span> : <?php the_date();?>, <?php  the_time();?></p>
	<p><span class="icon-tag"> <?php _e('Categories', 'slimwriter');?></span> : <?php the_category(', ');?></p>
	<p><?php the_tags("<span class='icon-tag'> ". __('Tags', 'slimwriter') ."</span> : ");?></p>
	<div class="clear"></div>
</aside>
<nav class="pager">

	<div class="nav-prev"><?php next_post_link( '%link', __( '<span class="meta-nav">&laquo;</span> Previous Post', 'slimwriter' ) ); ?></div>
	<div class="nav-next"><?php previous_post_link( '%link', __( 'Next Post <span class="meta-nav">&raquo;</span>', 'slimwriter' ) ); ?></div>
</nav>

<?php endwhile; else:?>

<h4><?php _e("The content you're looking for does not exist.", 'slimwriter');?></h4>

<?php endif;?>
<?php comments_template();?>

<?php get_sidebar();?>

<?php get_footer();?>
