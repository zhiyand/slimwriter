<?php get_header(); ?>

			<?php if ( have_posts() ) : ?>

				<header>
					<h1>
						<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: %s', 'slimwriter' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: %s', 'slimwriter' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'slimwriter' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: %s', 'slimwriter' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'slimwriter' ) ) . '</span>' ); ?>
						<?php elseif( is_category() ) :?>
							<?php _e( 'Category - '. single_cat_title('', false ) , 'slimwriter' ); ?>
						<?php elseif( is_tag() ) :?>
							<?php _e( 'Tag - '. single_cat_title('', false ) , 'slimwriter' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'slimwriter' ); ?>
						<?php endif; ?>
					</h1>
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
		<nav class="pager">

<?php if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<div class="nav-prev"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'slimwriter' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&raquo;</span>', 'slimwriter' ) ); ?></div>
<?php endif;?>
		</nav>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
