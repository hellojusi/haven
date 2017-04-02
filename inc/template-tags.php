<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Haven
 */


/**
 * Display navigation to next/previous set of posts when applicable.
 */
if ( ! function_exists( 'haven_pagination' ) ) :

function haven_pagination() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation posts-navigation" role="navigation">
		<div class="nav-links">
			<?php
				global $wp_query;
				$total = $wp_query->max_num_pages;
				// only bother with the rest if we have more than 1 page!
				if ( $total > 1 )  {
					// get the current page
					if ( !$current_page = get_query_var('paged') )
						$current_page = 1;
					// structure of "format" depends on whether we're using pretty permalinks
					if( get_option('permalink_structure') ) {
						$format = 'page/%#%/';
					} else {
						$format = '&paged=%#%';
					}
					echo paginate_links(array(
						'base'      => get_pagenum_link(1) . '%_%',
						'format'    => $format,
						'current'   => $current_page,
						'total'     => $total,
						'mid_size'  => 4,
						'prev_text' => __('&laquo;', 'haven'),
						'next_text' => __('&raquo;', 'haven'),
						'type'      => 'plain'
					));
				}
			?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;



/**
 * Display navigation to next/previous post when applicable.
 */
if ( ! function_exists( 'haven_post_nav' ) ) :

function haven_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'haven' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&laquo; Previous Post</span> %title', 'Previous post link', 'haven' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '<span class="meta-nav">Next Post &raquo;</span> %title', 'Next post link',     'haven' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;



/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'haven_posted_on' ) ) :

function haven_posted_on() {
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

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'haven' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	if ( false == get_theme_mod( 'hvn_hide_date', false ) ) {
		echo '<span class="posted-on">' . $posted_on . '</span>';
	}

	if ( false == get_theme_mod( 'hvn_hide_comment_number', false ) ) {
		echo '<span class="divider"> &middot; </span>';
		echo '<span class="comments"><a href="' . get_permalink() . '#comments">';
				comments_number( '0 Comments', '1 Comment', '% Comments' );
		echo '</a></span>';
	}

}
endif;

if ( ! function_exists( 'haven_entry_footer' ) ) :
function haven_entry_footer() {
	// Hide tag text for pages and archives
	if ( 'post' === get_post_type() && is_singular() && false == get_theme_mod( 'hvn_hide_tags', false ) ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' ', 'haven' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( '%1$s', 'haven' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() ) {
		$string = get_theme_mod('hvn_read_more_text', 'Continue reading');

		echo '<a href="' . get_permalink() . '#more" class="entry-more-link">' . $string . '</a>';
	}

	?>

	<?php if ( false == get_theme_mod( 'hvn_hide_share_icons', false )) : ?>
	
		<div class="post-share">
			<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
			<a href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php the_title(); ?>%20-%20<?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
			<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a>
			<?php global $post; $pin_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); ?>
			<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $pin_image; ?>&amp;description=<?php the_title(); ?>"><i class="fa fa-pinterest"></i></a>
		</div>

		<?php

	endif;

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function haven_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'haven_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'haven_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so haven_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so haven_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in haven_categorized_blog.
 */
function haven_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'haven_categories' );
}
add_action( 'edit_category', 'haven_category_transient_flusher' );
add_action( 'save_post',     'haven_category_transient_flusher' );



/**
 * Check for Custom Logo support and display site title accordingly
 */

function haven_theme_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}




function haven_related_posts() {

	if ( false == get_theme_mod( 'wbs_hide_related_posts', false )) :
		$category = get_the_category(); 
		$currentID = get_the_ID();
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => 3,
			'cat' => $category[0]->cat_ID,
			'post__not_in' => array($currentID),
			'orderby' => 'rand'
		);

		$related_posts = new WP_Query( $args );
		if ( $related_posts->have_posts() ) : ?>

			<div class="related-posts post-section">
				<h3 class="section-title"><?php _e('You might also like', 'haven'); ?></h3>

				<div class="related-posts-wrap">
					<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
							    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							        <?php the_post_thumbnail('featured'); ?>
							    </a>
							<?php endif; ?>
							<header class="entry-header">
								<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
							</header><!-- .entry-header -->

						</article><!-- #post-## -->

					<?php endwhile; ?>
				</div>

			</div><!-- /related-posts -->

		<?php endif; wp_reset_postdata(); ?>

	<?php endif;
}


function haven_gallery_format_slideshow($size) {

		$images = get_posts( array(
			'post_parent' => get_the_ID(),
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_mime_type' => 'image',
			'order' => 'DESC'
		) );

	?>

	<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-slides="img.gallery-item" data-timeout="0">
		<div class="cycle-pager"></div>

		<?php foreach ($images as $image) : ?>

			<?php $the_image = wp_get_attachment_image_src( $image->ID, $size ); ?> 
			<img src="<?php echo $the_image[0]; ?>" class="gallery-item" />
			
		<?php endforeach; ?>

	</div>

	<?php 

}