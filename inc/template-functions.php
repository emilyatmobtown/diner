<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Diner
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function din_body_classes( $classes ) {
	global $post;
	
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) :
		$classes[] = 'hfeed';
	endif;

	// Adds a class with the post ID 
	if ( isset( $post ) ) :
		$classes[] = $post->post_type . '-' . $post->ID;
	endif;
	    
	// Adds a class for the theme slug 
    $classes[] = 'diner';
	 
	return $classes;
}
add_filter( 'body_class', 'din_body_classes' );


/**
 * Adds a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function din_pingback_header() {
	if ( is_singular() && pings_open() ) :
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	endif;
}
add_action( 'wp_head', 'din_pingback_header' );


/** 
 * Links custom fonts in <head>
 */
function din_link_fonts() {
	if( ! is_admin() ) :
		echo '<link href="https://fonts.googleapis.com/css?family=Raleway:400,400i,700,700i" rel="stylesheet">';
	endif;
}
add_action( 'wp_head', 'din_link_fonts' );