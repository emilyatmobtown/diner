<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package Diner
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'row hentry' ); ?>>
	<div class="entry-thumbnail col-12">
		<?php din_post_thumbnail(); ?>
	</div><!-- .entry-thumbnail -->

	<div class="entry-text col-12">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php
			the_content();
	
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'diner' ),
				'after'  => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-text -->


	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'diner' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
