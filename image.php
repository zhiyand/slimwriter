<?php get_header();?>

<?php if(have_posts()) : while(have_posts()) : the_post();
$nail = get_the_post_thumbnail( get_the_ID(),  '-slimwriter-featured-big');
?>

<header>
	<h1><?php the_title();?></h1>
</header>
<article>

<?php

$attachments = array_values( get_children( array(
	'post_parent' => $post->post_parent,
	'post_status' => 'inherit',
	'post_type' => 'attachment',
	'post_mime_type' => 'image',
	'order' => 'ASC',
	'orderby' => 'menu_order ID' ) ) );

foreach ( $attachments as $k => $attachment ) { 
	if ( $attachment->ID == $post->ID )
		break;
}   
$k++;

if ( count( $attachments ) > 1 ) { 
	if ( isset( $attachments[ $k ] ) ){
		$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
	}else{
		$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
	}
}else{
	$next_attachment_url = wp_get_attachment_url();
}

?>
	<p><a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
<?php

echo wp_get_attachment_image( $post->ID, array( 650, 1024 ) );

?>
</a></p>

	<?php the_content();?>
	<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'slimwriter' ) . '</span>', 'after' => '</div>' ) ); ?>
</article>
<aside class="article-meta">
	<div class="avatar"><?php echo get_avatar( get_the_author_meta('user_email'), 48); ?></div>
	<p><span class="icon-user"> <?php _e('Author', 'slimwriter');?></span> : <?php the_author_link();?>, <span class="icon-calendar"> <?php _e('Published at', 'slimwriter');?></span> : <?php the_date();?>, <?php  the_time();?></p>
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
