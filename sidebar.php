<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Diner
 */

if ( ! is_active_sidebar( 'main-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'main-sidebar' ); ?>
</aside><!-- #secondary -->
