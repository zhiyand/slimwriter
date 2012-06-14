<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title><?php wp_title('&laquo;', true, 'right'); bloginfo('name'); ?></title>
	<?php $theme_url = get_bloginfo('template_url');?>

	<link href='http://fonts.googleapis.com/css?family=Bilbo|Tienne:400,700,900' rel='stylesheet' type='text/css' />
	<link href="<?php echo $theme_url;?>/static/css/reset.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $theme_url;?>/static/css/style.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $theme_url;?>/static/css/icon-font/style.css" rel="stylesheet" type="text/css" />

	<!--[if lt IE 9]>
	<script src="<?php echo $theme_url;?>/static/js/html5shiv.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

	<style type="text/css">
		.comment-form small{ visibility:visible; }
	</style>

	<![endif]-->
	<?php wp_head();?>
</head>
<body <?php body_class();?>>
	<div id="wrap">
		<div id="nav"><nav>
			<a id="logo" href="<?php echo home_url();?>"><img src="<?php echo $theme_url;?>/static/images/logo.png" /></a>
<?php
$primary_menu = array(
'theme_location'  => 'primary',
'container'       => false, //'ul', 
'container_class' => 'menu-{menu slug}-container', 
'menu_class'      => 'menu', 
'items_wrap'      => '<ul id=\"%1$s\" class=\"%2$s\">%3$s</ul>',
'depth'           => 0,
'fallback_cb' => ''
);

wp_nav_menu( $primary_menu ); ?>

		</nav></div>
