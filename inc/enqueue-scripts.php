<?php
/**
 * Enqueue scripts and styles.
 */

/** * Completely Remove jQuery From WordPress Admin Dashboard */

function pelegrin_scripts() {
	wp_enqueue_style( 'pelegrin-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'swiper-style', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'font-awesome-free', '//use.fontawesome.com/releases/v5.6.3/css/all.css' );
	wp_style_add_data( 'pelegrin-style', 'rtl', 'replace' );

	wp_enqueue_script( 'pelegrin-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'gsap-js', get_template_directory_uri() . '/js/gsap.min.js', array(), false, true );
	wp_enqueue_script( 'gsap-st', get_template_directory_uri() . '/js/ScrollTrigger.min.js', array('gsap-js'), false, true );
	wp_enqueue_script( 'gsap-sm', get_template_directory_uri() . '/js/ScrollSmoother.min.js', array('gsap-js'), false, true );
	wp_enqueue_script( 'gsap-sc', get_template_directory_uri() . '/js/ScrollToPlugin.min.js', array('gsap-js'), false, true );
	wp_enqueue_script( 'gsap-sp', get_template_directory_uri() . '/js/SplitText.min.js', array('gsap-js'), false, true );
	
	wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js', array(), false, true );

	wp_enqueue_script( 'plg-sc', get_stylesheet_directory_uri() . '/js/app.js', array('gsap-js'), false, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'pelegrin_scripts' );

// Eliminamos los estilos de woocommerce
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* //Eliminamos jQuery Migrate
function remove_jquery_Migrate( $scripts ) {
	if ( ! is_admin(  ) && isset( $scripts->registered['jquery'] ) ) {
		 $script = $scripts->registered['jquery'];
		if ( $script->deps ) {
		// Check whether the script has any dependencies
			$script->deps = array_diff( $script->deps, array( 'jquery-Migrate' ) );
		}
	}
}
add_action( 'wp_default_scripts', 'remove_jquery_Migrate' ); */
 
/* function deregister_polyfill(){

	wp_deregister_script( 'wp-polyfill' );
	wp_deregister_script( 'regenerator-runtime' );
  
}
add_action( 'wp_enqueue_scripts', 'deregister_polyfill'); */


/* function smartwp_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 ); */

/* function mytheme_block_assets() {
	wp_deregister_style( 'wp-block-library' );
	wp_register_style( 'wp-block-library', '' );
	wp_deregister_style('wp-edit-blocks');
	wp_register_style('wp-edit-blocks', '');
}
add_action( 'enqueue_block_assets', 'mytheme_block_assets' ); */
