<?php
/**
 * Template part for displaying results in search pages
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
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	
			<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php din_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	</div><!-- .entry-text -->

</article><!-- #post-<?php the_ID(); ?> -->
