<?php
/**
 * pelegrinroca functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pelegrinroca
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Setup wp.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Enqueue all scripts.
 */
require get_template_directory() . '/inc/enqueue-scripts.php';

/**
 * Register widgets.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Custom filters and actions for wp.
 */
require get_template_directory() . '/inc/custom-filters.php';

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
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Load Productos Shortcode.
 */
require get_template_directory(  ) . '/functions/productos.php';

/**
 * Load Reseñas Shortcode.
 */
require get_template_directory(  ) . '/functions/resenas.php';

/**
 * Modificación tablas producto.
 */
require get_template_directory(  ) . '/functions/woo-tables.php';

/**
 * Modificación tablas producto.
 */
// require get_template_directory(  ) . '/functions/acf-products.php';

/**
 * Listado de categorías.
 */
// require get_template_directory(  ) . '/functions/list-categories.php';
