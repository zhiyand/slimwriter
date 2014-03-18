<?php
$classes = get_post_class();
$classes = array_merge($classes, array('concavebox'));
$_slimwriter_nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>

<div class="<?php echo join(' ', $classes);?>">
<?php if($_slimwriter_nail):?>
    <div class="featured-img"><?php echo $_slimwriter_nail; ?></div>
<?php endif; // nail ?>
    <div class="entry-header">
        <?php if(is_singular()):?>
        <h1><?php the_title();?></h1>
        <?php else: ?>
        <h1><a href="<?php the_permalink();?>"><?php the_title();?></a></h1>
        <?php endif; ?>

        <p class="byline"><?php the_author_link(); ?> - <?php the_date(); ?> -
        <?php comments_popup_link( __('No comments', 'slimwriter'),
         __('One comment', 'slimwriter'),
         __('% comments', 'slimwriter'),
         'comments-link',
         __('Comments off', 'slimwriter') ); ?>
        </p>
    </div>
    <div class="entry">


	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>

    </div><!-- .entry -->
    <div class="entry-footer">
        <p><?php _e('Categories', 'slimwriter');?></span> : <?php the_category(', ');?></p>
        <p><?php the_tags(sprintf('%s : ', __('Tags', 'slimwriter')));?></p>
    </div>
</div><!-- .concavebox -->

<?php comments_template();?>
