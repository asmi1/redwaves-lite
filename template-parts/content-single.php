<?php
	/**
	* @package redwaves-lite
	*/
?>
<?php redwaves_set_post_views( get_the_ID() ); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#"><?php redwaves_breadcrumb(); ?></div>             			
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php redwaves_post_meta(); ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'redwaves-lite' ),
			'after'  => '</div>',
		) ); ?>
            	
	</div><!-- .entry-content -->
</article><!-- #post-## -->
<?php redwaves_related_posts(); ?>
<?php redwaves_next_prev_post(); ?>
<?php redwaves_author_box(); ?> 