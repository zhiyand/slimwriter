<?php

include( get_template_directory() . '/lib/agent.php' );


if(!isset($content_width)) $content_width = '700';

class SlimWriterTheme{
    private $_actions = array(
        'after_setup_theme',
        'widgets_init',
        'wp_enqueue_scripts',
    );
    private $_filters = array(
        'comment_form_default_fields',
        'comment_form_field_comment',
        'the_password_form',
        'embed_oembed_html',
        'video_embed_html',
    );

    function __construct(){
        load_theme_textdomain('slimwriter', get_template_directory() . '/languages');

        foreach($this->_actions as $action){
            if(is_array($action)){
                add_action($action[0], array($this, $action[0]), $action[1], $action[2]);
            }else{
                add_action($action, array($this, $action));
            }
        }
        foreach($this->_filters as $filter){
            if(is_array($filter)){
                add_filter($filter[0], array($this, $filter[0]), $filter[1], $filter[2]);
            }else{
                add_filter($filter, array($this, $filter));
            }
        }
    }
    /* Actions */
    function after_setup_theme(){
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_image_size('-slimwriter-featured-big', 700, 250, true);
        add_image_size('-slimwriter-featured-small', 140, 90, true);

        load_theme_textdomain('slimwriter', get_template_directory() . '/languages');

        register_nav_menu( 'primary', 'Primary' );
    }
    function widgets_init(){
        foreach(self::$SIDEBARS as $sidebar){
            register_sidebar($sidebar);
        }
    }
    function wp_enqueue_scripts()
    {
        $theme_url = get_template_directory_uri(); //get_bloginfo('template_url');
        wp_register_style('-slimwriter-bootstrap', $theme_url . '/static/css/bootstrap.min.css');
        wp_register_style('-slimwriter-style', $theme_url . '/static/css/style.css');
        //wp_register_style('-slimwriter-icon-font', $theme_url . '/static/css/icon-font/style.css');
        wp_register_style('-slimwriter-fonts', 'http://fonts.googleapis.com/css?family=Raleway:300|Merriweather:300,700,300italic,700italic');

        wp_enqueue_style('-slimwriter-fonts');
        wp_enqueue_style('-slimwriter-bootstrap');
        wp_enqueue_style('-slimwriter-style');
        //wp_enqueue_style('-slimwriter-icon-font');

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

    /* Filters */
    function comment_form_default_fields($fields)
    {
        $fields = array(
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-author">'._x('Name','comment-form','slim' ).' <span class="required">*</span></label><div class="col-sm-10"><input class="form-control" placeholder="'._x('Name', 'comment-form', 'slim').'" id="reply-author" name="author" type="text" value="" size="30" aria-required="true" /></div></div>',
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-email">'._x('Email', 'comment-form', 'slim').' <span class="required">*</span></label><div class="col-sm-10"><input class="form-control" placeholder="'._x('Email', 'comment-form', 'slim').'" id="reply-email" name="email" type="text" value="" size="30" aria-required="true" /></div></div>',
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-url">'._x('Website', 'comment-form', 'slim').'</label><div class="col-sm-10"><input id="reply-url" class="form-control" name="url" type="text" value="" size="30" placeholder="'._x('http://', 'comment-form', 'slim').'" /></div></div>',
        );

        return $fields;
    }
    function comment_form_field_comment(){
        $current_user = wp_get_current_user();
        if ( ($current_user instanceof WP_User) ) {
            $id = $current_user->ID;
            $avatar = get_avatar( $current_user->user_email, 75 );
        }
        $label = $id > 0 ? $avatar : '<span class="required">*</span>';'</span>';

        return sprintf('<div class="form-group">
        <label class="col-sm-2 control-label">%1$s</label>
        <div class="col-sm-10">
        <textarea placeholder="%2$s" id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div></div>
        <div class="form-group">
        <label class="col-sm-2"></label>
        <div class="col-sm-10">
        <input type="submit" class="btn btn-success" value="Submit" />
        </div>
        </div>', $label, __('Your comment here...', 'slim'));
    }
    function the_password_form(){
        global $post;
            $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
            $o = '<form class="form form-horizontal" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><p>'
                . __( "This content is password protected. To view it please enter your password below.", 'slim' ) . '</p><div class="input-group">' .
            '<span class="input-group-addon" for="'.$label.'">'. __("Password", 'slim').'</span>'.
            '<input name="post_password" id="' . $label . '" type="password" class="form-control" />'.
            '<span class="input-group-btn"><input type="submit" name="Submit" class="btn btn-default" value="' . esc_attr__( "Submit" ) . '" /></span>'.
            '</div></form>';
            return $o;
    }

    function embed_oembed_html($html){
        return $this->_video_embed($html);
    }
    function video_embed_html($html){
        return $this->_video_embed($html);
    }
    function _video_embed($html){
        return '<div class="video-container">' . $html . '</div>';
    }

    static $SIDEBARS = array(
    array(
        'name'          => 'Left Sidebar',
        'id'            => 'sidebar-left',
        'description'   => 'The sidebar on the left part of the page.',
        'before_widget' => '<div id="%1$s" class="widget %2$s pane pane-dark">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="pane-title">',
        'after_title'   => '</h3>' ),

    array(
        'name'          => 'Right Sidebar',
        'id'            => 'sidebar-right',
        'description'   => 'The sidebar on the right part of the page.',
        'before_widget' => '<div id="%1$s" class="widget %2$s pane pane-dark">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="pane-title">',
        'after_title'   => '</h3>' ),
    );

    static function comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><i class="glyphicon glyphicon-share"></i> <?php _e( 'Pingback', 'slim' ); ?>: <?php comment_author_link(); ?>
<?php edit_comment_link( '<i class="glyphicon glyphicon-pencil"></i>', ' <span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <div class="vcard"> <?php echo get_avatar( $comment, 48 ); ?> </div>

                <div class="text">
                <div class="date">
<?php printf( '<span class="fn">%s</span> ', get_comment_author_link() ); ?>
<?php printf( '<time pubdate datetime="%1$s">%2$s</time> ',
    get_comment_time( 'c' ),
    get_comment_date(  ));?>
 <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'slim' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
 <?php edit_comment_link( __( 'Edit', 'slim' ), '', '' ); ?></p>
                </div>

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'slim' ); ?></em>
                        <?php endif; ?>
                        <?php comment_text(); ?>

                </div>
                <div class="clearfix"></div>
            </li><!-- #comment-## -->

        <?php
                break;
        endswitch;
    }
};

$slimwriter = new SlimWriterTheme();


?>
