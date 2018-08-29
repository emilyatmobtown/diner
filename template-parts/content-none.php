<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Diner
 */

?>

<section class="no-results not-found">
	<header class="page-header row">
		<h1 class="page-title col"><?php esc_html_e( 'Nothing Found', 'diner' ); ?></h1>
	</header><!-- .page-header -->

	<div class=" row">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p class="col">' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'diner' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="col"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'diner' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p class="col"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'diner' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
