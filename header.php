<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title><?php wp_title(' &laquo; ', true, 'right'); ?></title>
<?php
$slimwriter_setting = get_option('_slimwriter_');
$slimwriter_theme_url = get_template_directory_uri();

$slimwriter_setting['logo'] = $slimwriter_setting['logo'] ? $slimwriter_setting['logo'] : ($slimwriter_theme_url . '/static/images/logo.png');
?>

	<?php
		if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>
<body <?php body_class();?>>
	<div id="wrap">
		<div id="nav"><nav>
			<a id="logo" href="<?php echo home_url();?>"><img src="<?php echo esc_url($slimwriter_setting['logo']) ?>" /></a>
<?php
$slimwriter_primary_menu = array(

'theme_location'  => 'primary',
'container'       => false, //'ul', 
'container_class' => 'menu-{menu slug}-container', 
'menu_class'      => 'menu', 
'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
'depth'           => 0,
'fallback_cb' => ''
);

wp_nav_menu( $slimwriter_primary_menu ); ?>


		</nav></div>
