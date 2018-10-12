<?php
	/**
	* The template for displaying comments.
	*
	* The area of the page that contains both current comments
	* and the comment form.
	*
	* @package redwaves-lite
	*/
	
	/*
	* If the current post is protected by a password and
	* the visitor has not yet entered the password we will
	* return early without loading the comments.
	*/
	
	if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','redwaves-lite'); ?></p>
	<?php
		return;
	}
?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
<div id="comments">
	<h3 class="total-comments"><?php comments_number(__('No Comments','redwaves-lite'), __('One Comment','redwaves-lite'),  __('% Comments','redwaves-lite') );?></h3>
	<ol class="commentlist clearfix">
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
		<?php wp_list_comments('type=comment&callback=redwaves_custom_comments'); ?>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
	</ol>
</div>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"></p>
<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
<div id="commentsAdd">
		<?php global $aria_req; $comments_args = array(
			'title_reply'=> __('Add a Comment','redwaves-lite') ,
			'comment_notes_after' => '',
			'label_submit' => __( 'Add Comment', 'redwaves-lite' ),
			'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
			'fields' => apply_filters( 'comment_form_default_fields',
			array(
			'author' => '<p class="comment-form-author">'
			.'<label style="display:none" for="author">'. __( 'Name', 'redwaves-lite' ).'<span class="required"></span></label>'
			.( $req ? '' : '' ).'<input id="author" name="author" type="text" placeholder="'.__('Name','redwaves-lite').'" value="'.esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
			'email' => '<p class="comment-form-email"><label style="display:none" for="email">' . __( 'Email', 'redwaves-lite' ) . '<span class="required"></span></label>'
			.($req ? '' : '' ) . '<input id="email" name="email" type="text" placeholder="'.__('Email','redwaves-lite').'" value="' . esc_attr(  $commenter['comment_author_email'] ).'" size="30"'.$aria_req.' /></p>',
			'url' => '<p class="comment-form-url"><label style="display:none" for="url">' . __( 'Website', 'redwaves-lite' ).'</label>' . 
			'<input id="url" name="url" type="text" placeholder="'.__('Website','redwaves-lite').'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
			) )
			); 
		comment_form($comments_args); ?>
</div>
<?php endif; ?>