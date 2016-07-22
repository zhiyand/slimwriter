<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?php wp_title('&laquo;', true, 'right'); ?></title>
<?php
$slimwriter_logo = get_header_image();
    $slimwriter_logo = $slimwriter_logo
    ? ('<img src="'. esc_url($slimwriter_logo). '" />' )
    : get_bloginfo('name');
?>

    <?php
        if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
        wp_head();
    ?>
</head>
<body <?php body_class();?>>
    <div id="mobile-nav">
        <?php wp_nav_menu( $slimwriter_primary_menu ); ?>
    </div>

    <div id="wrap">
        <div id="branding">
            <a id="logo" href="<?php echo esc_url(home_url());?>"><?php echo $slimwriter_logo; ?></a>
            <button id="btn-mobile-menu-toggle"></button>
        </div>
        <div id="nav"><nav class="main">
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
