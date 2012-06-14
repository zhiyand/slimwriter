<?php

/* Sidebar */

$args = array(
	'name'          => 'Left Sidebar',
	'id'            => 'sidebar-left',
	'description'   => 'The sidebar on the left part of the page.',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h4 class="widgettitle">',
	'after_title'   => '</h4>' );

register_sidebar($args);

$args = array(
	'name'          => 'Right Sidebar',
	'id'            => 'sidebar-right',
	'description'   => 'The sidebar on the right part of the page.',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h4 class="widgettitle">',
	'after_title'   => '</h4>' );

register_sidebar($args);

add_theme_support( 'post-thumbnails' );
add_image_size('featured-big', 700, 450, true);
add_image_size('featured-small', 140, 90, true);

function _slim_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div class="vcard"> <?php echo get_avatar( $comment, 48 ); ?> </div>
				
			<div class="text">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
						<br />
					<?php endif; ?>
					<?php comment_text(); ?>

			</div>
			<div class="date">
				<?php
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s on %2$s ', 'twentyeleven' ),
						sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
						sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
						)
					);
				?>
					, <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div>
			<div class="clear"></div>
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
function _slim_comment_fields($fields)
{
	$fields = array(
		'<p class="field"><input placeholder="Name" id="author" name="author" type="text" value="" size="30" aria-required="true" /><span class="required">*</span><small>Name</small></p>',
		'<p class="field"><input placeholder="Email" id="email" name="email" type="text" value="" size="30" aria-required="true" /><span class="required">*</span><small>Email</small></p>',
		'<p class="field"><input id="url" name="url" type="text" value="" size="30" placeholder="Website" /><small>Website</small></p>',
	);

	return $fields;
}

add_filter('comment_form_default_fields','_slim_comment_fields');
add_filter('show_admin_bar', '__return_false');
if ( !is_admin() ) wp_deregister_script('jquery');
?>
