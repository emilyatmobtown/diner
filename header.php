<?php
/**
 * The header for Diner
 *
 * This is the template that displays all of the <head> section and everything 
 * up until <div id="content">
 *
 * @package Diner
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class( 'no-sidebar' ); ?>>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_x( 'Skip to content', 'skip', 'diner' ); ?></a>
	
		<header id="masthead" class="site-header">
			<div class="container">
				<div class="row align-items-center">
					<nav id="site-navigation" class="col main-navigation">
						<button class="button-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="screen-reader-text"><?php esc_html_x( 'Primary Menu', 'menu', 'diner' ); ?></span></button>
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary-menu',
							'menu_id'        => 'primary-menu',
						) );
						?>
					</nav><!-- #site-navigation -->
					
					<div class="col col-lg-2 order-lg-first pl-0 site-branding">
						<?php
						if( has_custom_logo() ) :
							the_custom_logo();
						else : 
							?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_template_directory_uri() ) . '/img/logo.svg' ?>" alt="<?php bloginfo( 'name' ); ?>" class="site-logo"></a>
							<?php 
						endif;
						
						if ( is_front_page() && is_home() ) :
							?>
							<h1 class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php
						else :
							?>
							<p class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
							<?php
						endif;
						?>
					</div><!-- .site-branding -->
			
					<div id="search" class="col col-lg-1 site-search">
						<button class="button-toggle search-toggle"><span class="screen-reader-text"><?php esc_html_x( 'Search', 'label', 'diner' ); ?></span></button>
						<?php get_search_form(); ?>
					</div><!-- #search -->
				</div>
			</div>
		</header><!-- #masthead -->
	
		<div id="content" class="container site-content">
