<?php if ( post_password_required() ) : ?>
<div id="comments" class="comments concavebox pane">
    <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'slimwriter' ); ?></p>
</div> <!-- .comments -->
<?php
        /* Stop the rest of comments.php from being processed,
         * but don't kill the script entirely -- we still have
         * to fully load the template.
         */
        return;
    endif;
?>

<?php if ( have_comments() ) : ?>
<div id="comments" class="comments concavebox clearfix pane">
<h3 class="pane-title"><?php _e('Discussions', 'slimwriter');?></h3>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <div class="comment-nav">
        <?php paginate_comments_links(); ?>
    </div>
    <?php endif; // check for comment navigation ?>

    <ol class="commentlist">
        <?php
            wp_list_comments( array( 'callback' => 'SlimWriterTheme::comment') );
        ?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
    <div class="comment-nav">
        <?php paginate_comments_links(); ?>
    </div>
    <?php endif; // check for comment navigation ?>
</div> <!-- .comments -->
<?php
    /* If there are no comments and comments are closed, let's leave a little note, shall we?
     * But we don't want the note on pages or post types that do not support comments.
     */
    elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
?>
<div id="comments" class="comments concavebox clearfix pane">
    <p class="nocomments"><?php _e( 'Comments are closed.', 'slimwriter' ); ?></p>
</div> <!-- .comments -->
<?php else:?>
    <!--<p class="nocomments"><?php _e( 'No comments', 'slimwriter' ); ?></p> -->
<?php endif; ?>


<?php if ( comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :?>
<div class="concavebox clearfix pane"><div class="form-horizontal">
<?php comment_form(array(
    'title_reply' => __('Join the discussion', 'slimwriter'),
    'comment_notes_after' => '',
)); ?>
</div></div>
<?php endif;?>
