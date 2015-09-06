<?php
	/**
	* Redwaves Lite functions and definitions
	*
	* @package redwaves-lite
	*/
	
	/*-----------------------------------------------------------------------------------*/
	/*  Set the content width based on the theme's design and stylesheet.
	/*-----------------------------------------------------------------------------------*/
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* Sets up theme defaults and registers support for various WordPress features.
	/*-----------------------------------------------------------------------------------*/
	if ( ! function_exists( 'redwaves_setup' ) ) :
	function redwaves_setup() {
		
		// Make theme available for translation.
		load_theme_textdomain( 'redwaves-lite', get_template_directory() . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'redwaves-lite' ),
		'mobile-menu' => __( 'Mobile Menu', 'redwaves-lite' )
		) );
		
		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
		) );

	}
	endif; // redwaves_setup
	add_action( 'after_setup_theme', 'redwaves_setup' );	
	
	/*-----------------------------------------------------------------------------------*/
	/*  Register Sidebar & Widget-areas 
	/*-----------------------------------------------------------------------------------*/

	function redwaves_widgets_init() {

		//Register the Sidebar	
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'redwaves-lite' ),
			'id'            => 'sidebar',
			'description'   => 'Main Sidebar widget area.',
			'before_widget' => '<aside id="%1$s" class="widget sidebar-widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		
		//Register Header Widget-area	
		register_sidebar( array(
			'name'          => __( 'Header Widget-area', 'redwaves-lite' ),
			'id'            => 'header-area',
			'description'   => 'Top header widget area.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'redwaves_widgets_init' );
	
	/*-----------------------------------------------------------------------------------*/
	/*  Enqueue scripts and styles.
	/*-----------------------------------------------------------------------------------*/
	
	function redwaves_scripts() {
		global $redwaves;
		wp_enqueue_style( 'redwaves-style', get_stylesheet_uri() );
		
		// Loading jQuery
		wp_enqueue_script( 'jquery' );
		
		// Loading FontAwesome
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', null, '4.3.0' );

		// Loading Google's font "Roboto"
        wp_enqueue_style( 'roboto_google_font', '//fonts.googleapis.com/css?family=Roboto:400italic,300,700,400', false, null, 'all' );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

        // Loading jquery.pin.min.js only if the "sticky_menu" option is enabled
		$sticky_menu = get_theme_mod( 'sticky_menu' );
		if ( $sticky_menu ) {
			wp_enqueue_script( 'jquery-pin',  get_template_directory_uri() . '/js/jquery.pin.js', array( 'jquery' ), null, true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'redwaves_scripts' );
	
	/*-----------------------------------------------------------------------------------*/
	/*  Loading theme widgets.
	/*-----------------------------------------------------------------------------------*/
	
	// Add the Social Widget
	include("functions/widget-socialicons.php");

	// Add Recent Posts Widget
	include("functions/widget-recentposts.php");
	
	// Add Popular Posts Widget
	include("functions/widget-popularposts.php");

	// Add Facebook Like box Widget
	include("functions/widget-fblikebox.php");
	
	/*-----------------------------------------------------------------------------------*/
	/*  Custom template tags for this theme.
	/*-----------------------------------------------------------------------------------*/
	require get_template_directory() . '/inc/template-tags.php';
	
	/*-----------------------------------------------------------------------------------*/
	/*  Custom functions that act independently of the theme templates.
	/*-----------------------------------------------------------------------------------*/
	require get_template_directory() . '/inc/extras.php';
	
	/*-----------------------------------------------------------------------------------*/
	/*  Load Jetpack compatibility file.
	/*-----------------------------------------------------------------------------------*/
	require get_template_directory() . '/inc/jetpack.php';

	/*-----------------------------------------------------------------------------------*/
	/*  Add Post Thumbnail Support
	/*-----------------------------------------------------------------------------------*/
	if ( function_exists( 'add_theme_support' ) ) { 
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'big', 666, 333, true ); //big featured
		add_image_size( 'smallfeatured', 298, 248, true ); //small featured
		add_image_size( 'small', 120, 120, true ); //small thumb
		add_image_size( 'tiny', 70, 70, true ); //tiny thumb
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Common Functions
	/*-----------------------------------------------------------------------------------*/

	// Print Thumbnail/Featured image
	if (!function_exists('redwaves_get_thumbnail')) {
		function redwaves_get_thumbnail( $size = 'featured' ) {
			global $post;
			
			// This variable will be used only if the post has no featured image already set.
			$images = get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );			
			if ( $size == 'big' ) {

				if (has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
					$image = $image[0];
				}
				// use first attached image if no featured image was already set.
				elseif ( !empty($images) ) {
					$image = reset($images);
					$image = wp_get_attachment_image_src( $image->ID, $size );
					$image = $image[0];
				} else {
					$image = get_template_directory_uri() . '/images/nothumb-666x333.png';
				}

			} elseif ( $size == 'smallfeatured' ) {

				if (has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
					$image = $image[0];
				}
				// use first attached image if no featured image was already set.
				elseif ( !empty($images) ) {
					$image = reset($images);
					$image = wp_get_attachment_image_src( $image->ID, $size );
					$image = $image[0];
				} else {
					$image = get_template_directory_uri() . '/images/nothumb-298x248.png';
				}
			
			} elseif ( $size == 'small' ) {

				if (has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
					$image = $image[0];
				}
				// use first attached image if no featured image was already set.
				elseif ( !empty($images) ) {
					$image = reset($images);
					$image = wp_get_attachment_image_src( $image->ID, $size );
					$image = $image[0];
				} else {
					$image = get_template_directory_uri() . '/images/nothumb-120x120.png';
				}

			} else {

				if (has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
					$image = $image[0];
				}
				// use first attached image if no featured image was already set.
				elseif ( !empty($images) ) {
					$image = reset($images);
					$image = wp_get_attachment_image_src( $image->ID, $size );
					$image = $image[0];
				} else {
					$image = get_template_directory_uri() . '/images/nothumb-70x70.png';
				}

			}
			return $image;
		}
	}

	// Truncate string to x letters/words.
	function redwaves_truncate( $str, $length = 40, $units = 'letters', $ellipsis = '&nbsp;&hellip;' ) {
		if ( $units == 'letters' ) {
			if ( mb_strlen( $str ) > $length ) {
				return mb_substr( $str, 0, $length ) . $ellipsis;
				} else {
				return $str;
			}
			} else {
			$words = explode( ' ', $str );
			if ( count( $words ) > $length ) {
				return implode( " ", array_slice( $words, 0, $length ) ) . $ellipsis;
				} else {
				return $str;
			}
		}
	}	
	
	/*-----------------------------------------------------------------------------------*/
	/*  Breadcrumbs
	/*-----------------------------------------------------------------------------------*/
	if (!function_exists('redwaves_breadcrumb')) {
		function redwaves_breadcrumb() {
			echo '<div><i class="fa fa-home"></i></div> <div typeof="v:Breadcrumb" class="root"><a rel="v:url" property="v:title" href="';
			echo home_url();
			echo '">'.sprintf( __( "Home","redwaves-lite"));
			echo '</a></div><div>'.__('<i class="fa fa-caret-right"></i>','redwaves-lite').'</div>';
			if (is_category() || is_single()) {
				$categories = get_the_category();
				$output = '';
				if($categories){
					echo '<div typeof="v:Breadcrumb"><a href="'.get_category_link( $categories[0]->term_id ).'" rel="v:url" property="v:title">'.$categories[0]->cat_name.'</a></div><div>'.__('<i class="fa fa-caret-right"></i>','redwaves-lite').'</div>';
				}
				if (is_single()) {
					echo "<div typeof='v:Breadcrumb'><span property='v:title'>";
					the_title();
					echo "</span></div>";
				}
				} elseif (is_page()) {
				echo "<div typeof='v:Breadcrumb'><span property='v:title'>";
				the_title();
				echo "</span></div>";
			}
		}
	}
	
	/*-----------------------------------------------------------------------------------*/
	/*  Pagination (for WP 4.0 and earlier versions)
	/*-----------------------------------------------------------------------------------*/
	if (!function_exists('redwaves_pagination')) {
		function redwaves_pagination($pages = '', $range = 3) { 
			$showitems = ($range * 3)+1;
			global $paged; if(empty($paged)) $paged = 1;
			if($pages == '') {
				global $wp_query; $pages = $wp_query->max_num_pages; 
				if(!$pages){ $pages = 1; } 
			}
			if(1 != $pages) { 
				echo "<div class='pagination'><ul>";
				if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
				echo "<li><a rel='nofollow' href='".get_pagenum_link(1)."'><i class='fa fa-chevron-left'></i> ".__('First','redwaves-lite')."</a></li>";
				if($paged > 1 && $showitems < $pages) 
				echo "<li><a rel='nofollow' href='".get_pagenum_link($paged - 1)."' class='inactive'>&lsaquo; ".__('Previous','redwaves-lite')."</a></li>";
				for ($i=1; $i <= $pages; $i++){ 
					if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) { 
						echo ($paged == $i)? "<li class='current'><span class='currenttext'>".$i."</span></li>":"<li><a rel='nofollow' href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
					} 
				} 
				if ($paged < $pages && $showitems < $pages) 
				echo "<li><a rel='nofollow' href='".get_pagenum_link($paged + 1)."' class='inactive'>".__('Next','redwaves-lite')." &rsaquo;</a></li>";
				if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
				echo "<li><a rel='nofollow' class='inactive' href='".get_pagenum_link($pages)."'>".__('Last','redwaves-lite')." &raquo;</a></li>";
				echo "</ul></div>"; 
			}
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Excerpt
	/*-----------------------------------------------------------------------------------*/

	// Remove [...] & shortcodes.
	function redwaves_custom_excerpt( $output ) {
		return preg_replace( '/\[[^\]]*]/', '', $output );
	}
	add_filter( 'get_the_excerpt', 'redwaves_custom_excerpt' );
	remove_filter('the_excerpt', 'wpautop');
	
	//Edit the Excerpt lenth.
	function redwaves_custom_excerpt_length( $length ) {
		return 120;
	}
	add_filter( 'excerpt_length', 'redwaves_custom_excerpt_length', 999 );
	
	if ( ! function_exists( 'redwaves_excerpt' ) ) {
		function redwaves_excerpt( $limit = 30 ) {
			return redwaves_truncate( get_the_excerpt(), $limit, 'words' );
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/*   Header Area
	/*-----------------------------------------------------------------------------------*/

	// Move theme 28px to the bottom if admin bar is shown.
	function redwaves_prefix_move_theme_down() {
		if ( is_admin_bar_showing() ) {
		?>
		<style type="text/css" media="screen">
			html, .secondary-navigation { margin-top: 28px; }
			.header-container { margin-bottom: -28px; }
			#mobile-menu-wrapper { margin-top: 46px; }
			@media screen and (max-width: 600px) {
			#mobile-menu-wrapper { margin-top: 0; }
			}
		</style>
		<?php
		}
	}
	add_action( 'wp_head', 'redwaves_prefix_move_theme_down' );
	
	// Display favicon if set.
	if ( ! function_exists( 'redwaves_favicon' ) ) {
		function redwaves_favicon() {
			$favicon_image = get_theme_mod( 'favicon_image', get_template_directory_uri() .'/images/favicon.gif' );
			if ( isset( $favicon_image ) ) { ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url( $favicon_image ); ?>" /> 
			<?php }  
		}
	}
	
	// Display logo.
	if ( ! function_exists( 'redwaves_logo' ) ) {
		function redwaves_logo() {
			$logo_image = get_theme_mod( 'logo_image', get_template_directory_uri() .'/images/logo.png' );
			if ( $logo_image ) { ?>
			<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" rel="nofollow"><img src="<?php echo esc_url( $logo_image ); ?>" alt="<?php bloginfo('name'); echo ' - '; bloginfo('description'); ?>" /></a>
			<?php } else { ?>
			<span><a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></span>
			<p><?php bloginfo('description'); ?></p>
		<?php } 
		}
	}
	
	//Display header widget area
	if ( ! function_exists( 'redwaves_header_area' ) ) {
		function redwaves_header_area() { ?>
		<div class="header_area">
			<?php dynamic_sidebar( 'header-area' ); ?>
		</div><!-- .header_area -->
		<?php }
	}
	
	//Display small search bar in the mobile menu.
	if ( ! function_exists( 'redwaves_small_search_bar' ) ) {
		function redwaves_small_search_bar() {  ?>
         	<a href="javascript:void(0);" class="searchtoggle"><div><i class="fa fa-search"></i></div></a>
         	<div class="mobile_search">
				<?php get_search_form(); ?>
			</div>
         	<?php }  
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Homepage & Archives Settings
	/*-----------------------------------------------------------------------------------*/
	
	//Display the Excerpt.
	if ( ! function_exists( 'archives_excerpt' ) ) {
		function archives_excerpt() {
			$length = get_theme_mod( 'excerpt_length', 20 );
			if ( $length && intval( $length ) >= 5 && intval( $length ) <= 120  ) { 
			echo redwaves_excerpt( $length );
			}                                    
		}
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Single Post Settings
	/*-----------------------------------------------------------------------------------*/
	
	//Display meta info if enabled.
	if ( ! function_exists( 'redwaves_post_meta' ) ) {
		function redwaves_post_meta() {
			$post_meta = get_theme_mod( 'post_meta', '1' );
			if ( $post_meta ) { ?>
			<div class="entry-meta post-info"><?php	
				redwaves_entry_category(); 
				redwaves_entry_author();
				redwaves_posted();
				redwaves_entry_comments();
				echo '<br>';
				redwaves_entry_tags(); ?>		   
			</div><!-- .entry-meta -->
			<?php }                                    
		}
	}
	
	//Display related posts if enabled.
	if ( ! function_exists( 'redwaves_related_posts' ) ) {
		function redwaves_related_posts() {	
		$related_posts = get_theme_mod( 'related_posts', '1' );
		$related_posts_number = get_theme_mod( 'related_posts_number', '4' );				
		$related_posts_query = get_theme_mod( 'related_posts_query', 'tags' );
		$related_posts_excerpt = get_theme_mod( 'related_posts_excerpt', '10' );
			if ( $related_posts == true && intval( $related_posts_number ) > 0 && intval( $related_posts_number ) <= 6 ) {
				if ( $related_posts_query && $related_posts_query == 'tags') {
					// Query type: Tags
					global $post;
					$orig_post = $post;
					$tags = wp_get_post_tags($post->ID);
					if ($tags) {
						$tag_ids = array();
						foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
						$args=array(
						'tag__in' => $tag_ids,
						'post__not_in' => array($post->ID),
						'posts_per_page'=> $related_posts_number, // Number of related posts that will be displayed.
						'ignore_sticky_posts'=>1,
						'orderby'=>'rand' // Randomize the posts
						);
						$my_query = new wp_query( $args );
						if( $my_query->have_posts() ) { ?>
							<div id="related_posts" class="related-posts"><h3><?php _e("Related Posts", "redwaves-lite") ?></h3><ul>
							<?php while( $my_query->have_posts() ) {
							$my_query->the_post(); ?>
							<li>
								<div class="horizontal-container">
									<div class="relatedthumb">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<img width="120" height="120" src="<?php echo redwaves_get_thumbnail( 'small' ); ?>" class="attachment-featured wp-post-image" alt="<?php the_title_attribute(); ?>">
											<div class="post-format"><i class="fa fa-file-text"></i></div>
										</a>
									</div>
									<div class="post-data-container">
										<div class="post-title">
											<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
										</div>
										<div class="post-info">
											<div class="meta-info">
												<?php 
												redwaves_posted();
												redwaves_entry_comments();
												?>
											</div>
										</div>
										<div class="widget-post-excerpt">
											<?php if ( $related_posts_excerpt && intval( $related_posts_excerpt ) > 0 && intval( $related_posts_excerpt ) <= 40 ) {
												echo redwaves_excerpt( $related_posts_excerpt );
											} ?>
										</div>
									</div>
								</div>
							</li>
							<?php }
							echo '</ul></div>';
						} 
					}
					
					$post = $orig_post;
					wp_reset_query();
				
				} else {
					// Query type: Categories
					global $post;
					$orig_post = $post;
					$categories = get_the_category($post->ID);
					if ($categories) {
						$category_ids = array();
						foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
						$args=array(
						'category__in' => $category_ids,
						'post__not_in' => array($post->ID),
						'posts_per_page'=> $related_posts_number, // Number of related posts that will be displayed.
						'ignore_sticky_posts'=>1,
						'orderby'=>'rand' // Randomize the posts
						);
						$my_query = new wp_query( $args );
						if( $my_query->have_posts() ) { ?>
							<div id="related_posts" class="related-posts"><h3><?php _e("Related Posts", "redwaves-lite") ?></h3><ul>
							<?php while( $my_query->have_posts() ) {
							$my_query->the_post(); ?>
							<li>
								<div class="horizontal-container">
									<div class="relatedthumb">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<img width="120" height="120" src="<?php echo redwaves_get_thumbnail( 'small' ); ?>" class="attachment-featured wp-post-image" alt="<?php the_title_attribute(); ?>">
											<div class="post-format"><i class="fa fa-file-text"></i></div>
										</a>
									</div>
									<div class="post-data-container">
										<div class="post-title">
											<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
										</div>
										<div class="post-info">
											<div class="meta-info">
												<?php 
												redwaves_posted();
												redwaves_entry_comments();
												?>
											</div>
										</div>
										<div class="widget-post-excerpt">
											<?php if ( $related_posts_excerpt && intval( $related_posts_excerpt ) > 0 && intval( $related_posts_excerpt ) <= 40 ) {
												echo redwaves_excerpt( $related_posts_excerpt );
											} ?>
										</div>
									</div>
								</div>
							</li>
							<?php }
							echo '</ul></div>';
						}
					}
					$post = $orig_post;
					wp_reset_query();
				}
			}     
		}
	}
	
	//Display Post Next/Prev buttons if enabled.
	if ( ! function_exists( 'redwaves_next_prev_post' ) ) {
		function redwaves_next_prev_post() {
			$next_prev_post = get_theme_mod( 'next_prev_post', '1' ); ?>
			<div class="next_prev_post">
				<?php 
					if ( $next_prev_post ) {
						previous_post_link( '<div class="left-button">'.__('<i class="fa fa-chevron-left"></i>  %link','redwaves-lite').'</div>', __('Previous Post','redwaves-lite') );
						next_post_link( '<div class="right-button">'.__('%link <i class="fa fa-chevron-right"></i>','redwaves-lite').'</div>', __('Next Post','redwaves-lite') );
					} ?>
			</div><!-- .next_prev_post -->
			<?php 
		}                 
	}
		
	//Display Author box if enabled.
	if ( ! function_exists( 'redwaves_author_box' ) ) {
		function redwaves_author_box() {
			$author_box = get_theme_mod( 'author_box', '1' );
			if ( $author_box ) { ?>
			<div class="postauthor">
				<h3><?php _e('About The Author', 'redwaves-lite'); ?></h3>
				<div class="author-box">
					<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '110' );  } ?>
					<div class="author-box-content">
						<div class="vcard clearfix">
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="nofollow" class="fn"><i class="fa fa-user"></i><?php the_author_meta( 'nickname' ); ?></a>
						</div>
						<?php if( get_the_author_meta( 'description' ) ) { ?>
							<p><?php the_author_meta('description') ?></p>
						<?php }?>
					</div>
				</div>
			</div>	
			<?php }	
		}                 
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Custom Comments template
	/*-----------------------------------------------------------------------------------*/
	function redwaves_custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-box">
            <div class="comment-author vcard clearfix">
                <?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
				<?php global $post;
				global $redwaves;
				$author_comment = $redwaves['author_comment'];
				if ( $author_comment == true ) {
				// Highlight author Comments.
					if( $comment->user_id === $post->post_author ) {
						printf(__('<span class="fn">%s</span><span class="commenter_is_author">Author</span>', 'redwaves-lite'), get_comment_author_link());
					} else {
						printf(__('<span class="fn">%s</span>', 'redwaves-lite'), get_comment_author_link());
					} 
				} else {
					printf(__('<span class="fn">%s</span>', 'redwaves-lite'), get_comment_author_link());
				} ?> 
				<span class="ago">
					<?php comment_date(get_option( 'date_format' )); ?>
				</span>
                <span class="comment-meta">
                    <?php edit_comment_link(__('(Edit)', 'redwaves-lite'),'  ',''); ?>
                    <?php
						$args['reply_text'] = '<i class="fa fa-mail-forward"></i> '. __('Reply', 'redwaves-lite');
						comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'])));
					?>
				</span>
			</div>
            <?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.', 'redwaves-lite') ?></em>
			<br />
            <?php endif; ?>
            <div class="commentmetadata">
                <?php comment_text() ?>
			</div>
		</div>
	</li>
	<?php }

	if ( ! function_exists( 'redwaves_copyrights' ) ) {
		function redwaves_copyrights() { ?>
		<div id="copyright-note">
			<div class="site-info">
				<?php $footer_left = get_theme_mod( 'footer_left', 'Proudly powered by <a href="http://wordpress.org/" rel="generator">WordPress</a>' );
				echo $footer_left; ?>
			</div><!-- .site-info -->
			<div class="right">
				<?php _e( 'RedWaves theme by <a href="http://themient.com">Themient</a>', 'redwaves-lite' );?>
			</div>
		</div>
		<?php }
	}
		
	/*-----------------------------------------------------------------------------------*/
	/*   Remove query string from static files (for better performance)
	/*-----------------------------------------------------------------------------------*/

	function redwaves_remove_cssjs_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
		$src = esc_url( remove_query_arg( 'ver', $src ) );
		return $src;
	}
	add_filter( 'style_loader_src', 'redwaves_remove_cssjs_ver', 10, 2 );
	add_filter( 'script_loader_src', 'redwaves_remove_cssjs_ver', 10, 2 );				
		
	/*-----------------------------------------------------------------------------------*/
	/*  Load WP Customizer & Options Panel
	/*-----------------------------------------------------------------------------------*/

	require get_template_directory() . '/inc/customizer.php';

	/*-----------------------------------------------------------------------------------*/
	/*  That's All, Bye!
	/*-----------------------------------------------------------------------------------*/
?>