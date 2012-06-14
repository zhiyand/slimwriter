<?php get_header();?>
		<header>
			<h1><?php bloginfo('name');?></h1>
		</header>
		<aside class="article-meta">
			<p><?php bloginfo('description');?></p>
		</aside>
		<article>
<?php if(have_posts()): while(have_posts()) : the_post(); ?>

<?php get_template_part('content', get_post_type());?>

<?php endwhile; else:?>
<?php endif;?>
		</article>
		<nav class="pager">

<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<div class="nav-prev"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'twentyten' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'twentyten' ) ); ?></div>
<?php endif;?>
		</nav>
<?php get_sidebar();?>
<?php get_footer();?>
