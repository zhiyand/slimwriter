<div <?php post_class();?>>
<?php
$_slimwriter_nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>
<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>


<p class="meta">
<span class="icon-user"> <?php _e('Author', 'slimwriter');?></span> : <?php the_author_link();?>, 
<span class="icon-calendar"> <?php _e('Published at', 'slimwriter');?></span> : <?php the_date();?>, <?php  the_time();?></p>

<?php if($_slimwriter_nail):?>

<section class="featured-img"><?php echo $_slimwriter_nail; ?></section>

<?php endif; // nail ?>

<section>
	<?php the_content(__("Read More &raquo;", 'slimwriter'));?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
</section>
</div>
