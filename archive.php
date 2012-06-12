<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

			<?php if ( have_posts() ) : ?>

				<header>
					<h1>
						<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: %s', 'twentyeleven' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
						<?php elseif( is_category() ) :?>
							<?php _e( 'Category - '. single_cat_title('', false ) , 'twentyeleven' ); ?>
						<?php elseif( is_tag() ) :?>
							<?php _e( 'Tag - '. single_cat_title('', false ) , 'twentyeleven' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'twentyeleven' ); ?>
						<?php endif; ?>
					</h1>
				</header>


<article>
				<?php while ( have_posts() ) : the_post(); ?>

			<section>
				<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>

				<p><?php the_excerpt();?></p>

			</section>

				<?php endwhile; ?>
</article>


			<?php else : ?>

					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->
				<article>

						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
				</article><!-- #post-0 -->

			<?php endif; ?>


<?php get_sidebar(); ?>
<?php get_footer(); ?>
