<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

<header>
	<h1><?php the_title();?></h1>
</header>
<aside class="article-meta">
	<p>Author : <?php the_author_link();?>, Published at : <?php the_date();?>, <?php  the_time();?></p>
	<p>Categories : <?php the_category(', ');?></p>
	<p><?php the_tags();?></p>
</aside>
<article>
	<?php the_content();?>
</article>

<?php endwhile; else:?>

<h4>The content you're looking for does not exist.</h4>

<?php endif;?>
<?php get_sidebar();?>

<?php comments_template();?>

<?php get_footer();?>
