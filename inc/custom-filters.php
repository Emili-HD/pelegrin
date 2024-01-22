<?php
add_filter('wpcf7_form_elements', function($content) {
    $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

    return $content;
});

add_filter('wpcf7_autop_or_not', '__return_false');

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

add_filter( 'edit_post_link', '__return_empty_string' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function pelegrin_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'pelegrin_content_width', 640 );
}
add_action( 'after_setup_theme', 'pelegrin_content_width', 0 );


/**
 * Mostrar todas las categorías de woocommerce. También se muestran las vacías
 */
add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );

/**
 * Full tamaño imagenes categorias
 */
function custom_category_image_size( $size ) {
    return 'full';
}
add_filter( 'woocommerce_category_image_size', 'custom_category_image_size' );

/**
 * Srcset eliminar
 */
function remove_image_srcset( $sources, $size_array, $image_src, $image_meta, $attachment_id ) {
    return '';
}
add_filter( 'wp_calculate_image_srcset', 'remove_image_srcset', 10, 5 );
