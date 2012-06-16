<?php

/* Menu */
register_nav_menu( 'primary', 'Primary navigation on the top of the page' );

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
add_theme_support( 'automatic-feed-links' );

add_image_size('-slim-featured-big', 700, 450, true);
add_image_size('-slim-featured-small', 140, 90, true);

function _slim_enqueue()
{
	$theme_url = get_template_directory_uri(); //get_bloginfo('template_url');
	wp_register_style('-slim-reset', $theme_url . '/static/css/reset.css');
	wp_register_style('-slim-style', $theme_url . '/static/css/style.css');
	wp_register_style('-slim-icon-font', $theme_url . '/static/css/icon-font/style.css');
	wp_register_style('-slim-fonts', 'http://fonts.googleapis.com/css?family=Bilbo|Tienne:400,700,900');


	wp_enqueue_style('-slim-fonts');
	wp_enqueue_style('-slim-reset');
	wp_enqueue_style('-slim-style');
	wp_enqueue_style('-slim-icon-font');
}

function _slim_comment($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'slimwriter' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'slimwriter' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div class="vcard"> <?php echo get_avatar( $comment, 48 ); ?> </div>
				
			<div class="text">

					<?php if ( $comment->comment_approved == '0' ) : ?>
						<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'slimwriter' ); ?></em>
						<br />
					<?php endif; ?>
					<?php comment_text(); ?>

			</div>
			<div class="date">
				<?php
					/* translators: 1: comment author, 2: date and time */
					printf( __( '%1$s on %2$s ', 'slimwriter' ),
						sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
						sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							/* translators: 1: date, 2: time */
							sprintf( __( '%1$s at %2$s', 'slimwriter' ), get_comment_date(), get_comment_time() )
						)
					);
				?>
					, <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'slimwriter' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
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
add_action('wp_enqueue_scripts', '_slim_enqueue');

if ( !is_admin() ) wp_deregister_script('jquery');
?>
