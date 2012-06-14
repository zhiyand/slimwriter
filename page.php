<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<header>
	<h1><?php the_title();?></h1>
</header>
<article>
	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
	<ul><?php wp_list_pages("title_li=&child_of=".get_the_ID()); ?></ul>
</article>

<?php endwhile; else:?>

<h4>The content you're looking for does not exist.</h4>

<?php endif;?>
<?php comments_template();?>
<?php get_sidebar();?>


<?php get_footer();?>
