<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'slimwriter' ); ?></p>
	</div><!-- #comments -->
	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h5 id="comments-title"><div class="icon"></div>
			<?php
				printf( _n( 'There\'s one comment on this post.', 'There\'re %1$s comments on this post.', get_comments_number(), 'slimwriter' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h5>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav class="comment-nav">
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'slimwriter' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'slimwriter' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<ol class="commentlist">
			<?php
			global $zd_slimwriter;
			wp_list_comments( array( 'callback' => array($zd_slimwriter, 'comment') ) );
			?>
		</ol>


	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'slimwriter' ); ?></p>
	<?php endif; ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav class="comment-nav">
			<div class="nav-previous"><?php previous_comments_link( __( '&laquo; Older Comments', 'slimwriter' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &raquo;', 'slimwriter' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

	<?php comment_form(array(
<<<<<<< HEAD
		'comment_field' => '<p class="comment-f field"><textarea placeholder="'. __('Comment', 'slimwriter') .'" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea><span class="required">*</span></p>',
		'comment_notes_after' => '<p style="color:#000;"><strong>'. __('NOTE - You can user these HTML tags and attributes', 'slimwriter'). ':</strong></p>
=======
		'comment_field' => sprintf('<p class="comment-f field"><textarea placeholder="%s" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea><span class="required">*</span></p>', __('Comment', 'slimwriter')),
		'comment_notes_after' => sprintf('<p style="color:#000;"><strong>%s</strong></p>
>>>>>>> 9fafb01471adcf1a5334c6e306e5155dbc9940a5
		<code>&lt;a href=&quot;&quot; title=&quot;&quot;&gt; &lt;abbr title=&quot;&quot;&gt; &lt;acronym title=&quot;&quot;&gt; &lt;b&gt; &lt;blockquote cite=&quot;&quot;&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=&quot;&quot;&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=&quot;&quot;&gt; &lt;strike&gt; &lt;strong&gt; </code> ',
			__('NOTE - You can use these HTML tags and attributes:', 'slimwriter') ),
	)); ?>

</div><!-- #comments -->
