<?php
/**
 * Template part for displaying post content
 *
 * @package Diner
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row hentry' ); ?>>

	<div class="entry-thumbnail col-12 col-lg-8">
		<?php din_post_thumbnail(); ?>
	</div><!-- .entry-thumbnail -->

	
	<div class="entry-text col-12 col-lg-4">
		<header class="entry-header">
			<?php
			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<?php din_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php 
			endif; 
			
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>
		</header><!-- .entry-header -->
	
		<div class="entry-content">
			<?php
			if( is_singular() ) :
				the_content();
			else :
				the_excerpt();
			endif;
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-text -->
	
</article><!-- #post-<?php the_ID(); ?> -->
