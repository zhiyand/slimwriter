<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post();
$_slimwriter_nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>

<header>
	<h1><?php the_title();?></h1>
</header>
<article>
	<?php if($_slimwriter_nail):?>

	<section class="featured-img"><?php echo $_slimwriter_nail; ?></section>

	<?php endif; // nail ?>
	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimwriter' ) . '</span>', 'after' => '</div>' ) ); ?>
	<ul><?php wp_list_pages("title_li=&child_of=".get_the_ID()); ?></ul>
	<div class="clear"></div>
</article>

<?php endwhile; else:?>

<h4><?php _e("The content you're looking for does not exist.", 'slimwriter');?></h4>

<?php endif;?>
<?php comments_template();?>
<?php get_sidebar();?>


<?php get_footer();?>
