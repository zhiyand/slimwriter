<div <?php post_class();?>>
<?php
$title = get_the_title(); $title = trim($title) == '' ? '(No Title)' : $title;
$nail = get_the_post_thumbnail( get_the_ID(),  '-slim-featured-big');
?>
<h2><a href="<?php the_permalink();?>"><?php echo $title;?></a></h2>


<p class="meta"><span class="icon-user"> Author</span> : <?php the_author_link();?>, <span class="icon-calendar"> Published at</span> : <?php the_date();?>, <?php  the_time();?></p>

<?php if($nail):?>

<section class="featured-img"><?php echo $nail; ?></section>

<?php endif; // nail ?>

<section>
	<?php the_content("Read More &raquo;");?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
</section>
</div>
