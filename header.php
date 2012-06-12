<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<title><?php wp_title('&laquo;', true, 'right'); bloginfo('name'); ?></title>
	<?php $theme_url = get_bloginfo('template_url');?>

	<link href='http://fonts.googleapis.com/css?family=Bilbo|Tienne:400,700,900' rel='stylesheet' type='text/css' />
	<link href="<?php echo $theme_url;?>/static/css/reset.css" rel="stylesheet" type="text/css" />

	<?php wp_head();?>

	<link href="<?php echo $theme_url;?>/static/css/style.css" rel="stylesheet" type="text/css" />

	<!--[if lt IE 9]>
	<script src="<?php echo $theme_url;?>/static/js/html5shiv.js"></script>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>

	<style type="text/css">
		.comment-form small{ visibility:visible; }
	</style>

	<![endif]-->
</head>
<body>
	<div id="wrap">
		<div id="nav"><nav>
			<a id="logo" href="<?php echo $theme_url;?>"><img src="<?php echo $theme_url;?>/static/images/logo.png" /></a>
			<ul>
				<?php wp_list_pages('title_li=');?>
				<li><a href="<?php bloginfo('url');?>">Home</a></li>
			</ul>
		</nav></div>
