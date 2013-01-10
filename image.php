<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post();
$_slimwriter_nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>

<header>
	<h1><?php the_title();?></h1>
</header>
<article>

<?php

$_slimwriter_attachments = array_values( get_children( array(
	'post_parent' => $post->post_parent,
	'post_status' => 'inherit',
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'order' => 'ASC',
	'orderby' => 'menu_order ID' ) ) );

foreach ( $_slimwriter_attachments as $k => $attachment ) { 
	if ( $attachment->ID == $post->ID )
		break;
}   
$k++;

if ( count( $_slimwriter_attachments ) > 1 ) { 
	if ( isset( $_slimwriter_attachments[ $k ] ) ){
		$_slimwriter_next_attachment_url = get_attachment_link( $_slimwriter_attachments[ $k ]->ID );
	}else{
		$_slimwriter_next_attachment_url = get_attachment_link( $_slimwriter_attachments[ 0 ]->ID );
	}
}else{
	$_slimwriter_next_attachment_url = wp_get_attachment_url();
}

?>
	<p><a href="<?php echo esc_url( $_slimwriter_next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
<?php

echo wp_get_attachment_image( $post->ID, array( 650, 1024 ) );

?>
</a></p>

	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimcoder' ) . '</span>', 'after' => '</div>' ) ); ?>
</article>
<aside class="article-meta">
	<div class="avatar"><?php echo get_avatar( get_the_author_meta('user_email'), 48); ?></div>
	<p><span class="icon-user"> Author</span> : <?php the_author_link();?>, <span class="icon-calendar"> Published at</span> : <?php the_date();?>, <?php  the_time();?></p>
	<div class="clear"></div>
</aside>
<nav class="pager">

	<div class="nav-prev"><?php previous_image_link( false, __( '&laquo; Previous' , 'slimwriter' ) ); ?></div>
	<div class="nav-next"><?php next_image_link( false, __('Next &raquo;', 'slimwriter' ) ); ?></div>
</nav>

<?php endwhile; else:?>

<h4><?php _e("The content you're looking for does not exist.", 'slimwriter');?></h4>

<?php endif;?>
<?php comments_template();?>

<?php get_sidebar();?>

<?php get_footer();?>
