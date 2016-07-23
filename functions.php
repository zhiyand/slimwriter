<?php

include( get_template_directory() . '/lib/agent.php' );
include( get_template_directory() . '/lib/SlimWriterOptions.class.php' );

if(!isset($content_width)) $content_width = '700';

class SlimWriterTheme{
    private $_actions = array(
        'after_setup_theme',
        'wp_enqueue_scripts',
    );
    private $_filters = array(
        'wp_title',
        'comment_form_default_fields',
        'comment_form_field_comment',
        'the_password_form',
        array('embed_oembed_html', 10, 4),
        'video_embed_html',
        array('img_caption_shortcode_width', 10, 3),
        array('post_gallery', 10, 2),
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
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'automatic-feed-links' );
        add_image_size('-slimwriter-featured-big', 700, 250, true);
        add_image_size('-slimwriter-featured-small', 140, 90, true);
        add_image_size('-slimwriter-gallery-full', 660, 408, true);
        add_image_size('-slimwriter-gallery-medium', 330, 204, true);
        add_image_size('-slimwriter-gallery-small', 220, 136, true);

        $args = array(
            'width'         => 320,
            'height'        => 90,
            'default-image' => get_template_directory_uri() . '/static/images/logo.png',
            'header-text'   => false,
            'uploads'       => true,
        );
        add_theme_support( 'custom-header', $args );

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
        global $wp_styles;

        $theme_url = get_template_directory_uri();
        wp_register_style('-slimwriter-bootstrap', $theme_url . '/static/css/bootstrap.min.css');
        wp_register_style('-slimwriter-style', $theme_url . '/static/css/style.css');
        wp_register_style('-slimwriter-fonts', '//fonts.googleapis.com/css?family=Raleway:300');

        wp_enqueue_style('-slimwriter-fonts');
        wp_enqueue_style('-slimwriter-bootstrap');
        wp_enqueue_style('-slimwriter-style');

        wp_register_style('-slimwriter-ie8', $theme_url . '/static/css/lt-ie9.css');
        wp_enqueue_style('-slimwriter-ie8');
        $wp_styles->add_data( '-slimwriter-ie8', 'conditional', 'lte IE 8' );

        $browser = zd_slimwriter_parseUserAgent($_SERVER['HTTP_USER_AGENT']);

        if($browser[0] == 'MSIE' && $browser[1] < 9){
            wp_register_script('-slimwriter-ie8-html5', $theme_url . '/static/js/html5shiv.js');
            wp_register_script('-slimwriter-ie8-css3', $theme_url . '/static/js/css3-mediaqueries.js');
            wp_enqueue_script('-slimwriter-ie8-html5');
            wp_enqueue_script('-slimwriter-ie8-css3');
        }

        wp_register_script('-slimwriter-menu', $theme_url . '/static/js/menu.js');
        wp_enqueue_script('-slimwriter-menu');
    }

    /* Filters */
    function wp_title($title, $sep = '|', $seplocation = 'left')
    {
        return $title . get_bloginfo('name');
    }

    function comment_form_default_fields($fields)
    {
        $fields = array(
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-author">'._x('Name','comment-form','slimwriter' ).' <span class="required">*</span></label><div class="col-sm-10"><input class="form-control" placeholder="'._x('Name', 'comment-form', 'slimwriter').'" id="reply-author" name="author" type="text" value="" size="30" aria-required="true" /></div></div>',
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-email">'._x('Email', 'comment-form', 'slimwriter').' <span class="required">*</span></label><div class="col-sm-10"><input class="form-control" placeholder="'._x('Email', 'comment-form', 'slimwriter').'" id="reply-email" name="email" type="text" value="" size="30" aria-required="true" /></div></div>',
            '<div class="form-group"><label class="col-sm-2 control-label" for="reply-url">'._x('Website', 'comment-form', 'slimwriter').'</label><div class="col-sm-10"><input id="reply-url" class="form-control" name="url" type="text" value="" size="30" placeholder="'._x('http://', 'comment-form', 'slimwriter').'" /></div></div>',
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
        <input type="submit" class="btn btn-success" value="%3$s" />
        </div>
        </div>', $label, __('Your comment here...', 'slimwriter'), __('Submit', 'slimwriter'));
    }
    function the_password_form(){
        global $post;
            $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
            $o = '<form class="form form-horizontal" action="' . get_option('siteurl') . '/wp-pass.php" method="post"><p>'
                . __( "This content is password protected. To view it please enter your password below.", 'slimwriter' ) . '</p><div class="input-group">' .
            '<span class="input-group-addon" for="'.$label.'">'. __("Password", 'slimwriter').'</span>'.
            '<input name="post_password" id="' . $label . '" type="password" class="form-control" />'.
            '<span class="input-group-btn"><input type="submit" name="Submit" class="btn btn-default" value="' . esc_attr__( "Submit", 'slimwriter' ) . '" /></span>'.
            '</div></form>';
            return $o;
    }

    function embed_oembed_html($html, $url, $attr, $post_ID){
        list($proto, $extra) = explode('//', $url);
        list($domain, $uri) = explode('/', $extra);

        if(in_array($domain, array('twitter.com'))){
            return $html;
        }

        return $this->_video_embed($html);
    }
    function video_embed_html($html){
        return $this->_video_embed($html);
    }
    function _video_embed($html){
        return '<div class="video-container">' . $html . '</div>';
    }
    function img_caption_shortcode_width($caption_width, $atts, $content){
        return $caption_width -10;
    }
    /**
     * The Gallery shortcode.
     *
     * This implements the functionality of the Gallery Shortcode for displaying
     * WordPress images on a post.
     *
     * @param array $attr Attributes of the shortcode.
     * @return string HTML content to display gallery.
     */
    function post_gallery($output, $attr) {

        $post = get_post();

        static $instance = 0;
        $instance++;

        if ( ! empty( $attr['ids'] ) ) {
            // 'ids' is explicitly ordered, unless you specify otherwise.
            if ( empty( $attr['orderby'] ) )
                $attr['orderby'] = 'post__in';
            $attr['include'] = $attr['ids'];
        }

        // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
        if ( isset( $attr['orderby'] ) ) {
            $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
            if ( !$attr['orderby'] )
                unset( $attr['orderby'] );
        }

        extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id'         => $post ? $post->ID : 0,
            'itemtag'    => 'div',
            'icontag'    => 'div',
            'captiontag' => 'p',
            'columns'    => 3,
            'size'       => '-slimwriter-gallery-small',
            'include'    => '',
            'exclude'    => '',
            'link'       => ''
        ), $attr, 'gallery'));

        $columns = intval($columns);
        $span = 6;
        switch($columns){
            case 1:
                $span = 12;
            $size = '-slimwriter-gallery-full'; break;
            case 2:
                $span = 6;
            $size = '-slimwriter-gallery-medium'; break;
            case 3:
                $span = 4;
            $size = '-slimwriter-gallery-small'; break;
            case 4:
            default:
                $span = 4;
            $columns = 3;
            $size = '-slimwriter-gallery-small'; break;

        }

        $id = intval($id);
        if ( 'RAND' == $order )
            $orderby = 'none';

        if ( !empty($include) ) {
            $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

            $attachments = array();
            foreach ( $_attachments as $key => $val ) {
                $attachments[$val->ID] = $_attachments[$key];
            }
        } elseif ( !empty($exclude) ) {
            $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        } else {
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        }

        if ( empty($attachments) )
            return '';

        if ( is_feed() ) {
            $output = "\n";
            foreach ( $attachments as $att_id => $attachment )
                $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
            return $output;
        }

        $itemtag = tag_escape($itemtag);
        $captiontag = tag_escape($captiontag);
        $icontag = tag_escape($icontag);
        $valid_tags = wp_kses_allowed_html( 'post' );
        if ( ! isset( $valid_tags[ $itemtag ] ) )
            $itemtag = 'dl';
        if ( ! isset( $valid_tags[ $captiontag ] ) )
            $captiontag = 'dd';
        if ( ! isset( $valid_tags[ $icontag ] ) )
            $icontag = 'dt';

        $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
        $float = is_rtl() ? 'right' : 'left';

        $selector = "gallery-$instance";

        $gallery_style = $gallery_div = '';

        $size_class = sanitize_html_class( $size );
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

        $output = $gallery_div;

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {

            if ( $columns > 0 && $i % $columns == 0 )
                $output .= '<div class="row">';

            if ( ! empty( $link ) && 'file' === $link )
                $image_output = wp_get_attachment_link( $id, $size, false, false );
            elseif ( ! empty( $link ) && 'none' === $link )
                $image_output = wp_get_attachment_image( $id, $size, false );
            else
                $image_output = wp_get_attachment_link( $id, $size, true, false );

            $image_meta  = wp_get_attachment_metadata( $id );

            $orientation = '';
            if ( isset( $image_meta['height'], $image_meta['width'] ) )
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';

            $output .= "<{$itemtag} class='gallery-item col-md-{$span}'>";
            $output .= "
                <{$icontag} class='gallery-icon {$orientation}'>
                    $image_output
                </{$icontag}>";
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
            if ( $columns > 0 && ++$i % $columns == 0 ){
                $output .= '</div><!-- .row -->';
            }
        }
        if($i % $columns != 0){
                $output .= '</div><!-- .row -->';
        }

        $output .= "
            </div>\n";

        return $output;
    }

    static $SIDEBARS = array(
    array(
        'name'          => 'Left Sidebar',
        'id'            => 'sidebar-left',
        'description'   => 'The sidebar on the left part of the page.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>' ),

    array(
        'name'          => 'Right Sidebar',
        'id'            => 'sidebar-right',
        'description'   => 'The sidebar on the right part of the page.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>' ),
    );

    /* Only open & display comment
     * don't close the tag 'cause WordPress will do it automatically. */
    static function comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><i class="glyphicon glyphicon-share"></i> <?php _e( 'Pingback', 'slimwriter' ); ?>: <?php comment_author_link(); ?>
<?php edit_comment_link( '<i class="glyphicon glyphicon-pencil"></i>', ' <span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
                <div class="vcard"> <?php echo get_avatar( $comment, 48 ); ?> </div>

                <div class="text">
                <div class="date"><p>
<?php printf( '<span class="fn">%s</span> ', get_comment_author_link() ); ?>
<?php printf( '<time pubdate datetime="%1$s">%2$s</time> ',
    get_comment_time( 'c' ),
    get_comment_date(  ));?>
 <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'slimwriter' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
 <?php edit_comment_link( __( 'Edit', 'slimwriter' ), '', '' ); ?></p>
                </div>

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'slimwriter' ); ?></em>
                        <?php endif; ?>
                        <?php comment_text(); ?>

                </div>
                <div class="clearfix"></div>

        <?php
                break;
        endswitch;
    }
};

$slimwriter = new SlimWriterTheme();

/**
 * To compensate for the dumb Theme Check plugin.
 *
 * Apparently, dynamic registration in the constructor
 * does not work, with the Theme Check plugin complaining
 * register_sidebar() must be called in a hook of the
 * action 'widgets_init'.
 */
add_action('widgets_init', array($slimwriter, 'widgets_init'));
