<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package 3T_Skeleton
 */

if ( ! is_active_sidebar( 'footer_widget_area' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'footer_widget_area' ); ?>
</aside><!-- #secondary -->
