<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Gusto
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function gusto_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'gusto_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function gusto_jetpack_setup
add_action( 'after_setup_theme', 'gusto_jetpack_setup' );

function gusto_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', get_post_format() );
	}
} // end function gusto_infinite_scroll_render