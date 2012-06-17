<div <?php post_class();?>>
<?php
$nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>
<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>


<p class="meta"><span class="icon-user"> Author</span> : <?php the_author_link();?>, <span class="icon-calendar"> Published at</span> : <?php the_date();?>, <?php  the_time();?></p>

<?php if($nail):?>

<section class="featured-img"><?php echo $nail; ?></section>

<?php endif; // nail ?>

<section>
	<?php the_content("Read More &raquo;");?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
</section>
</div>
