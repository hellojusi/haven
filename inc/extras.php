<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Haven
 */


// Adds custom classes to the array of body classes.
function haven_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}

add_filter( 'body_class', 'haven_body_classes' );


// Adds custom class to first post on the homepage.
function haven_first_post_class( $classes ) {
  global $wp_query;
  $paged = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
  if ( $wp_query->current_post == 0 && $paged == 1 && is_home() ) {
    $classes[] = 'first-post';
  }
  return $classes;
}

add_filter( 'post_class', 'haven_first_post_class' );
