<?php get_header();?>
		<header>
			<h1><?php bloginfo('name');?></h1>
		</header>
		<aside class="article-meta">
			<p><?php bloginfo('description');?></p>
		</aside>
		<article>
<?php if(have_posts()): while(have_posts()) : the_post(); ?>
			<section>
				<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

				<p><?php the_excerpt();?></p>

			</section>
<?php endwhile; else:?>
<?php endif;?>
		</article>
		<nav class="pager">

<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<div class="nav-prev"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyten' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
<?php endif;?>
		</nav>
<?php get_sidebar();?>
<?php get_footer();?>
