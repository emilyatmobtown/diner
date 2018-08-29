<?php
/**
 * Diner functions and definitions
 *
 * @package Diner
 */

if ( ! function_exists( 'din_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function din_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'diner', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'din_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary-menu' => esc_html__( 'Primary Menu', 'diner' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
	}
endif;
add_action( 'after_setup_theme', 'din_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function din_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'din_content_width', 640 );
}
add_action( 'after_setup_theme', 'din_content_width', 0 );


/**
 * Register widget area.
 */
function din_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'diner' ),
		'id'            => 'main-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'diner' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'din_widgets_init' );


/**
 * Enqueue scripts and styles.
 */
function din_scripts() {
	wp_enqueue_style( 'main-css', get_stylesheet_uri() );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/scripts.min.js', array( 'jquery' ), '20180827', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'din_scripts' );


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';


/**
 * Replaces the excerpt "Read More" text by a link
 */
function din_excerpt_more( $more ) {
       global $post;
	return '<p><a class="more-link" href="'. get_permalink($post->ID) . '"> Read More</a></p>';
}
add_filter( 'excerpt_more', 'din_excerpt_more' );


/**
 * Generates custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML
 */
function din_get_search_form( $form ) {
    $form = 
    	'<form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
			<label>
		        <span class="screen-reader-text">' . esc_html_x( 'Search for:', 'label', 'diner' ) . '</span>
		        <input type="search" class="search-field"
		            placeholder="' . esc_attr_x( 'e.g. delicious sandwiches', 'placeholder', 'diner' ) .'"
		            value="' . get_search_query() . '" name="s"
		            title="' . esc_attr_x( 'Search for:', 'label', 'diner' ) .'" />
		    </label>
		    <input type="submit" class="search-submit"
		        value="' . esc_attr_x( 'Search', 'submit button', 'diner' ) . '" />
		</form>';
 
    return $form;
}
add_filter( 'get_search_form', 'din_get_search_form' );