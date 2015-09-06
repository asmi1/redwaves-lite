<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package redwaves-lite
 */

/*-----------------------------------------------------------------------------------*/
/*  Meta information
/*-----------------------------------------------------------------------------------*/

//Prints HTML with meta information for the current post-date/time.
if ( ! function_exists( 'redwaves_posted' ) ) {
    function redwaves_posted() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}
		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
		$posted = sprintf(
			_x( '%s', 'post date', 'redwaves-lite' ),
			$time_string 
		);
		echo '<span class="posted"><i class="fa fa-clock-o"></i>' . $posted . '</span>';
	}
}

// Prints HTML with meta information for Author.
if ( ! function_exists( 'redwaves_entry_author' ) ) :
function redwaves_entry_author() {
    if ( 'post' == get_post_type() ) {
            $byline = sprintf(
		_x( '%s', 'post author', 'redwaves-lite' ),
		'<span class="author vcard"><span class="url fn"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span></span>'
	);
            echo '<span class="theauthor"><i class="fa fa-user"></i> ' . $byline . '</span>';
    }
}
endif;

// Prints HTML with meta information for Category.
if ( ! function_exists( 'redwaves_entry_category' ) ) {
	function redwaves_entry_category() { ?>
		<span class="thecategory">
			<?php     if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( '', 'redwaves-lite' ) );
		if ( $categories_list && redwaves_categorized_blog() ) {
			printf( '<div class="thecategory">' . __( '%1$s', 'redwaves-lite' ) . '</div>', $categories_list );
		}
    } ?>
		</span>
	<?php }
}

// Prints HTML with meta information for Tags.
if ( ! function_exists( 'redwaves_entry_tags' ) ) :
function redwaves_entry_tags() {
    if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'redwaves-lite' ) );
		if ( $tags_list ) {
			printf( '<span class="thetags"><i class="fa fa-tags"></i>' . __( '%1$s', 'redwaves-lite' ) . '</span>', $tags_list );
		}
    }
}
endif;

// Prints HTML with meta information for Comments number.
if ( ! function_exists( 'redwaves_entry_comments' ) ) :
function redwaves_entry_comments() {
	if ( 'post' == get_post_type() ) {
		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		if ( comments_open() ) {
			$write_comments =  $num_comments;
		} else {
			$write_comments = '0';
		}
		printf( '<span class="comments"><i class="fa fa-comments"></i>' . __( '%1$s', 'redwaves-lite' ) . '</span>', $write_comments );
	}
}
endif;

// Counts & Prints the number of post views.
function redwaves_post_views( $postID ){
    $count_key = 'post_views_count';
    $count = get_post_meta( $postID, $count_key, true );
    if( $count=='' ){
        delete_post_meta( $postID, $count_key );
         add_post_meta( $postID, $count_key, '0' );
        echo '<span class="views"><i class="fa fa-eye"></i> 0</span>';
    }
    echo '<span class="views"><i class="fa fa-eye"></i>'.$count.'</span>';
}

function redwaves_set_post_views($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	}else{
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( __( 'Category: %s', 'redwaves-lite' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag: %s', 'redwaves-lite' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( __( 'Author: %s', 'redwaves-lite' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'redwaves-lite' ), get_the_date( _x( 'Y', 'yearly archives date format', 'redwaves-lite' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'redwaves-lite' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'redwaves-lite' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'redwaves-lite' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'redwaves-lite' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'redwaves-lite' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'redwaves-lite' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( __( 'Archives: %s', 'redwaves-lite' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%1$s: %2$s', 'redwaves-lite' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = __( 'Archives', 'redwaves-lite' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function redwaves_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'redwaves_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'redwaves_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so redwaves_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so redwaves_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in redwaves_categorized_blog.
 */
function redwaves_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'redwaves_categories' );
}
add_action( 'edit_category', 'redwaves_category_transient_flusher' );
add_action( 'save_post',     'redwaves_category_transient_flusher' );