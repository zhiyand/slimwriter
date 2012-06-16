<?php get_header(); ?>

			<?php if ( have_posts() ) : ?>

				<header>
					<h1><?php _e("Search results for : ", 'slimwriter'); ?><?php the_search_query(); ?></h1>
				</header>


<article>
				<?php while ( have_posts() ) : the_post(); ?>
<?php get_template_part('content', get_post_type()); ?>
				<?php endwhile; ?>
</article>


			<?php else : ?>

					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'slimwriter' ); ?></h1>
					</header><!-- .entry-header -->
				<article>

						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'slimwriter' ); ?></p>
						<?php get_search_form(); ?>
				</article><!-- #post-0 -->

			<?php endif; ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
