<?php
	/**
	* @package redwaves-lite
	*/
?>

	<?php
		$display = get_theme_mod( 'display', 'excerpt_smallfeatured' );
		if ( $display == 'excerpt_smallfeatured' ) {  ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('post-box small-post-box'); ?>>  
				<div class="post-img small-post-img">		
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<img width="298" height="248" src="<?php echo redwaves_get_thumbnail( 'smallfeatured' ); ?>" class="attachment-featured wp-post-image" alt="<?php the_title_attribute(); ?>">
						<div class="post-format"><i class="fa fa-file-text"></i></div>
					</a>
					<?php 
					$archives_meta = get_theme_mod( 'archives_post_meta', '1' );
					if ( $archives_meta == '1' ) {
						$category = get_the_category();
						if ($category) {
							echo '<span class="category-box"><a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( "View all posts in %s", "redwaves-lite" ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a></span>';
						} 
					} ?>
				</div>
				<div class="post-data small-post-data">
					<div class="post-data-container">
						<header class="entry-header">
							<div class="entry-meta post-info">
								<?php the_title( sprintf( '<h2 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
								$archives_post_meta = get_theme_mod( 'archives_post_meta', '1' );	
								if ( $archives_post_meta ) { ?>
								<div class="entry-meta post-info"><?php
									redwaves_entry_author();
									redwaves_posted();
									redwaves_entry_comments(); ?>		   
								</div><!-- .entry-meta -->
								<?php } ?>
							</div><!-- .entry-meta -->
						</header><!-- .entry-header -->
						<div class="entry-content post-excerpt">
							<?php archives_excerpt(); ?>
						</div><!-- .entry-content -->
						<div class="readmore">
							<a href="<?php echo get_permalink(); ?>"><?php esc_attr_e('Read More', 'redwaves-lite'); ?></a>
						</div>			
					</div><!-- .post-data-container -->
				</div><!-- .post-data -->
			</article><!-- #post-## -->
		<?php } else { ?>  
		<article id="post-<?php the_ID(); ?>" <?php post_class('post-box big-post-box'); ?>>
			<div class="post-data-container">
				<div class="single-featured">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<img width="666" height="333" src="<?php echo redwaves_get_thumbnail( 'big' ); ?>" class="attachment-featured wp-post-image" alt="<?php the_title_attribute(); ?>">
						<div class="post-format"><i class="fa fa-file-text"></i></div>
					</a>
				</div>
				<header class="entry-header">
					<div class="entry-meta post-info">
						<?php the_title( sprintf( '<h2 class="entry-title post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
						$archives_post_meta = get_theme_mod( 'archives_post_meta', '1' );	
						if ( $archives_post_meta ) {
							redwaves_entry_category();
							redwaves_entry_author();
							redwaves_posted();
							redwaves_entry_comments(); ?>
						<?php } ?>	             
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->
				<div class="entry-content post-excerpt">
					<?php archives_excerpt(); ?>
				</div><!-- .entry-content -->
				<div class="readmore">
					<a href="<?php echo get_permalink(); ?>"><?php esc_attr_e('Read More', 'redwaves-lite'); ?></a>
				</div>
			</div><!-- .post-data-container -->
		</article><!-- #post-## -->		
	<?php } ?>