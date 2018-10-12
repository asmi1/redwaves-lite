<?php
	/**
	* The template for displaying search results pages.
	*
	* @package redwaves-lite
	*/
	
get_header(); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		
		<?php if ( have_posts() ) : ?>
		
		<header class="page-header">
			<h1 class="page-title">
				<?php printf( __( 'Search Results for: %s', 'redwaves-lite' ), '<span>' . get_search_query() . '</span>' ); ?>
			</h1>
		</header><!-- .page-header -->
		
		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>
		
		<?php
			/**
				* Run the loop for the search to output the results.
				* If you want to overload this in a child theme then include a file
				* called content-search.php and that will be used instead.
			*/
			get_template_part( 'template-parts/content', get_post_format() );
		?>
		<?php endwhile; ?>
		
		<?php // if WP version 4.1.0 or above use the_posts_pagination() built in function.
		if (4.1 <= floatval(get_bloginfo('version'))):?>                    
		<?php the_posts_pagination( array(
			'mid_size' => 1,
			'prev_text' => __( '&#8249; Previous', 'redwaves-lite' ),
			'next_text' => __( 'Next &#8250;', 'redwaves-lite' ),
		) ); ?>
		<?php else : ?>
		<?php redwaves_pagination(); ?>
		<?php endif; ?>
		
		<?php else : ?>
		
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
		
		<?php endif; ?>
		
	</main><!-- #main -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
		