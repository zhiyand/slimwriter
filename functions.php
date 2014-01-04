<?php

include( get_template_directory() . '/lib/agent.php' );

/* Menu */
register_nav_menu( 'primary', 'Primary navigation on the top of the page' );

if(!isset($content_width)) $content_width = '700';

class zd_SlimWriterTheme{


	function __construct(){
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );

		add_image_size('-slimwriter-featured-big', 700, 450, true);
		add_image_size('-slimwriter-featured-small', 140, 90, true);

		add_filter('comment_form_default_fields', array( &$this, 'comment_fields') );
		add_filter('the_title', array(&$this, 'title_filter'));
		add_filter('wp_title', array(&$this, 'wp_title_filter'), 10, 3);
		add_filter('embed_defaults', array(&$this, 'embed_defaults'));
		add_filter('img_caption_shortcode_width', array($this, 'img_caption_shortcode_width'), 10, 3);

		add_action('wp_enqueue_scripts', array(&$this, 'enqueue'));
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_action('admin_init', array(&$this, 'register_setting'));
		add_action('after_setup_theme', array(&$this, 'after_setup_theme'));
	}
	function after_setup_theme(){
		load_theme_textdomain('slimwriter', get_template_directory() . '/languages');
	}

	function img_caption_shortcode_width($caption_width, $atts, $content){
		return $caption_width -10;
	}
	function title_filter($title){
		if(trim($title) == ''){
			return '(No Title)';
		}
		return $title;
	}
	function wp_title_filter($title, $sep = '', $position = ''){
		if(is_single() && trim($title) == ''){
			$title = '(No Title)';
		}

		if( is_category() ) $type = 'Category';
		elseif( is_tag() ) $type = 'Tag';
		elseif( is_author() ) $type . 'Author';
		elseif( is_date() || is_archive() ) $type = 'Archives';
		else $type = false;

		if( get_query_var( 'paged' ) ) {
			$page_num = 'Page ' . get_query_var( 'paged' ); // on index
		}elseif( get_query_var( 'page' ) ) {
			$page_num = 'Page ' . get_query_var( 'page' ); // on single
		}else { $page_num = false; }

		$title = trim( str_replace( $sep, '', $title ) );

		if( $position == 'right' ){
			$parts = array( $title, $page_num, $type, get_bloginfo( 'name' ) );
		}else{
			$parts = array( get_bloginfo( 'name' ), $type, $title, $page_num );
		}

		$parts = array_filter( $parts );

		return implode( ' ' . $sep . ' ', $parts );
	}

	function enqueue()
	{
		$theme_url = get_template_directory_uri(); //get_bloginfo('template_url');
		wp_register_style('-slimwriter-reset', $theme_url . '/static/css/reset.css');
		wp_register_style('-slimwriter-style', $theme_url . '/static/css/style.css');
		wp_register_style('-slimwriter-icon-font', $theme_url . '/static/css/icon-font/style.css');
		wp_register_style('-slimwriter-fonts', 'http://fonts.googleapis.com/css?family=Raleway:300|Merriweather:300,700,300italic,700italic');

		wp_enqueue_style('-slimwriter-fonts');
		wp_enqueue_style('-slimwriter-reset');
		wp_enqueue_style('-slimwriter-style');
		wp_enqueue_style('-slimwriter-icon-font');

		$browser = zd_slimwriter_parseUserAgent($_SERVER['HTTP_USER_AGENT']);

		if($browser[0] == 'MSIE' && $browser[1] < 9){
			wp_register_style('-slimwriter-lt-ie9', $theme_url . '/static/css/lt-ie9.css');
			wp_enqueue_style('-slimwriter-lt-ie9');

			wp_register_script('-slimwriter-lt-ie9-html5', $theme_url . '/static/js/html5shiv.js');
			wp_register_script('-slimwriter-lt-ie9-css3', $theme_url . '/static/js/css3-mediaqueries.js');
			wp_enqueue_script('-slimwriter-lt-ie9-html5');
			wp_enqueue_script('-slimwriter-lt-ie9-css3');
		}

		if ( is_admin_bar_showing() ){
			wp_register_style('-slimwriter-admin-bar', $theme_url . '/static/css/admin-bar.css');
			wp_enqueue_style('-slimwriter-admin-bar');
		}
	}

	function comment($comment, $args, $depth)
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
	function comment_fields($fields)
	{
		$fields = array(
			sprintf('<p class="field"><input placeholder="%s" id="author" name="author" type="text" value="" size="30" aria-required="true" /><span class="required">*</span><small>%s</small></p>', __('Name', 'slimwriter'), __('Name', 'slimwriter') ),
			sprintf('<p class="field"><input placeholder="%s" id="email" name="email" type="text" value="" size="30" aria-required="true" /><span class="required">*</span><small>%s</small></p>', __('Email', 'slimwriter'), __('Email', 'slimwriter')),
			sprintf('<p class="field"><input id="url" name="url" type="text" value="" size="30" placeholder="%s" /><small>%s</small></p>', __('Website', 'slimwriter'), __('Website', 'slimwriter')),
		);

		return $fields;
	}

	function admin_menu(){
		add_theme_page( __('SlimWriter Options', 'slimwriter'),
			__('SlimWriter Options', 'slimwriter'),
			'edit_theme_options',
			'slimwriter',
			array(&$this, 'options_page'));
	}
	function options_page(){
		$setting = get_option('_slimwriter_', array(
			'logo' => get_template_directory_uri() . '/static/images/logo.png',
		));
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<h2>SlimWriter Theme Settings</h2>
	<?php settings_errors(); ?>  
<div id="slimwriter">
	<form method="post" action="options.php">
	<?php settings_fields( 'slimwriter' );?>
<table class="form-table">
	<tr>
		<th scope="row">Logo URL</th>
		<td><input type="text" name="_slimwriter_[logo]" value="<?php esc_attr_e($setting['logo'])?>" class="regular-text" />
		<p class="description">Recommended resolution: 160x40, with transparent background.</p>
		</td>
	</tr>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary"	 value="<?php _e('Save Changes', 'slimwriter'); ?>" />
	</form>
</div>
</div><!-- #wrap -->
<?php
	}

	function register_setting(){
		register_setting('slimwriter', '_slimwriter_', array(&$this, 'sanitize_setting'));
	}
	function sanitize_setting($input){
		$setting = get_option('_slimwriter_');

		$input['logo'] = esc_url_raw($input['logo'], array('http', 'https'));

		return $input;
	}

	function embed_defaults($size){
		$size['width'] = 652;
		$size['height'] = 652 * .75;
		return $size;
	}

	static $SIDEBARS = array(
	array(
		'name'          => 'Left Sidebar',
		'id'            => 'sidebar-left',
		'description'   => 'The sidebar on the left part of the page.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>' ),

	array(
		'name'          => 'Right Sidebar',
		'id'            => 'sidebar-right',
		'description'   => 'The sidebar on the right part of the page.',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>' ),
	);

};

$zd_slimwriter = new zd_SlimWriterTheme();

/* Sidebar */

foreach(zd_SlimWriterTheme::$SIDEBARS as $sidebar){
	register_sidebar($sidebar);
}

?>
