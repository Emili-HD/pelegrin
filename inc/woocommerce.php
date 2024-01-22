<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package pelegrinroca
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function pelegrin_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 1200,
			'single_image_width'    => 1200,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'pelegrin_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function pelegrin_woocommerce_scripts() {
	wp_enqueue_style( 'pelegrin-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'pelegrin-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'pelegrin_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function pelegrin_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'pelegrin_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function pelegrin_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'pelegrin_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'pelegrin_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function pelegrin_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="section site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'pelegrin_woocommerce_wrapper_before' );

if ( ! function_exists( 'pelegrin_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function pelegrin_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'pelegrin_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
 */

if ( function_exists( 'pelegrin_woocommerce_header_cart' ) ) {
	pelegrin_woocommerce_header_cart();
}


if ( ! function_exists( 'pelegrin_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function pelegrin_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		pelegrin_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'pelegrin_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'pelegrin_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function pelegrin_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'pelegrin' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'pelegrin' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'pelegrin_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function pelegrin_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php pelegrin_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}

// Remove breadcrumbs from shop & categories
/* add_filter( 'woocommerce_before_main_content', 'remove_breadcrumbs');
function remove_breadcrumbs() {
    if(!is_product()) {
        remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
    }
} */

function cambiar_tamano_imagen_producto($size) {
    return 'full';
}
add_filter('woocommerce_get_image_size_thumbnail', 'cambiar_tamano_imagen_producto');

add_action('wp_enqueue_scripts', 'quitar_zoom_producto');

function quitar_zoom_producto() {
    wp_dequeue_script('zoom');
    wp_dequeue_script('zoom-image');
}

add_filter( 'woocommerce_product_tabs', 'my_remove_product_tabs', 98 );
 
function my_remove_product_tabs( $tabs ) {
  unset( $tabs['additional_information'] ); // To remove the additional information tab
  return $tabs;
}

remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

/* Remove product meta */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


/**
 * @snippet       Edit SELECT OPTIONS Button - WordPress Shop
 */
 
 add_filter( 'woocommerce_product_add_to_cart_text', 'change_select_options_button_text', 9999, 2 );
 
 function change_select_options_button_text( $label, $product ) {
	if ( $product->is_type( 'variable' ) ) {
	   return 'Ver Producto';
	}
	return $label;
 }

/* ***************************************** */
/* Mover los productos relacionados dentro del variations form */
/* ***************************************** */
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
add_action('woocommerce_after_variations_form', 'woocommerce_output_related_products', 8);

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_add_to_cart_form', 'woocommerce_upsell_display', 10 );



// Remover breadcrumbs de su posición original
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// Añadir breadcrumbs al resumen del producto
add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 5 );

add_shortcode( 'cart_count', 'mb_cart_count' );
function mb_cart_count(){
	if( ! WC()->cart->is_empty() ) {
		return WC()->cart->get_cart_contents_count();
	}
	return '0';
}



// function wc_remove_quantity_field_from_cart( $return, $product ) {
// 	if ( is_cart() ) return true;
// }
// add_filter( 'woocommerce_is_sold_individually', 'wc_remove_quantity_field_from_cart', 10, 2 );


add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
remove_action( 'woocommerce_after_checkout_billing_form', 'woocommerce_checkout_shipping' );



/**
 * Plugin Name: Cambiar Precios de Variaciones
 */

 /* function cambiar_precios_por_porcentaje($price, $product) {
    // Definir el porcentaje de incremento
    $porcentaje = 0.10; // 10%

    if ($product->is_type('variable')) {
        // Obtener las variaciones del producto
        $variations = $product->get_available_variations();

        foreach ($variations as $variation) {
            // Obtener el precio de la variación
            $variation_price = $variation['display_price'];

            // Calcular el nuevo precio
            $new_price = $variation_price + ($variation_price * $porcentaje);

            // Establecer el nuevo precio
            $variation['display_price'] = $new_price;
        }
    }

    return $price;
}

add_filter('woocommerce_product_get_price', 'cambiar_precios_por_porcentaje', 10, 2);
add_filter('woocommerce_product_variation_get_price', 'cambiar_precios_por_porcentaje', 10, 2); */

/* function add_percentage_field_to_variations( $loop, $variation_data, $variation ) {
	$product_id = 320;

	if($variation->post_parent == $product_id) {
		woocommerce_wp_text_input( 
			array( 
				'id'          => 'price_percentage_increase[' . $loop . ']', 
				'label'       => __( 'Incremento porcentual de precios (%)', 'woocommerce' ), 
				'description' => __( 'Ingrese el porcentaje de aumento en precio.', 'woocommerce' ),
				'desc_tip'    => 'true',
				'value'       => get_post_meta( $variation->ID, 'price_percentage_increase', true )
			)
		);
	}
}
add_action( 'woocommerce_variation_options_pricing', 'add_percentage_field_to_variations', 10, 3 );


function save_price_percentage_increase_field( $variation_id, $i ) {
    $percentage_increase = $_POST['price_percentage_increase'][$i];
    
    if( isset( $percentage_increase ) ) {
        update_post_meta( $variation_id, 'price_percentage_increase', sanitize_text_field( $percentage_increase ) );
    }
}
add_action( 'woocommerce_save_product_variation', 'save_price_percentage_increase_field', 10, 2 );


function change_variation_price_based_on_percentage_increase( $price, $product ) {
    if( $product->is_type( 'variation' ) ) {
        $percentage_increase = get_post_meta( $product->get_id(), 'price_percentage_increase', true );

        if( $percentage_increase ) {
            $percentage = $percentage_increase / 100;
            $price = $price + ($price * $percentage);
        }
    }

    return $price;
}
add_filter( 'woocommerce_product_variation_get_price', 'change_variation_price_based_on_percentage_increase', 10, 2 ); */

/* function mostrar_campo_acf_en_producto() {
    global $product;

    // Obtén las opciones seleccionadas del campo ACF
    $opciones_seleccionadas = get_field('impresion', $product->get_id());

    // Muestra las opciones seleccionadas como botones de opción
    if ($opciones_seleccionadas) {
        echo '<div class="wpo-field wpo-field-radio">';
        foreach ($opciones_seleccionadas as $opcion) {
            echo '<input type="radio" id="'. $opcion .'" name="mi_campo_radio" value="'. $opcion .'">';
            echo '<label for="'. $opcion .'">'. $opcion .'</label><br>';
        }
        echo '</div>';
    }
}
add_action('woocommerce_after_add_to_cart_button', 'mostrar_campo_acf_en_producto'); */

function add_percentage_field_to_variations( $loop, $variation_data, $variation ) {
	$product_id = 320;

	if($variation->post_parent == $product_id) {
		woocommerce_wp_text_input( 
			array( 
				'id'          => 'price_percentage_increase[' . $loop . ']', 
				'label'       => __( 'Incremento porcentual de precios (%)', 'woocommerce' ), 
				'description' => __( 'Ingrese el porcentaje de aumento en precio.', 'woocommerce' ),
				'desc_tip'    => 'true',
				'value'       => get_post_meta( $variation->ID, 'price_percentage_increase', true )
			)
		);
	}
}
add_action( 'woocommerce_variation_options_pricing', 'add_percentage_field_to_variations', 10, 3 );


function save_price_percentage_increase_field( $variation_id, $i ) {
    $percentage_increase = $_POST['price_percentage_increase'][$i];
    
    if( isset( $percentage_increase ) ) {
        update_post_meta( $variation_id, 'price_percentage_increase', sanitize_text_field( $percentage_increase ) );
    }
}
add_action( 'woocommerce_save_product_variation', 'save_price_percentage_increase_field', 10, 2 );


function change_variation_price_based_on_percentage_increase( $price, $product ) {
    if( $product->is_type( 'variation' ) ) {
        $percentage_increase = get_post_meta( $product->get_id(), 'price_percentage_increase', true );

        if( $percentage_increase ) {
            $percentage = $percentage_increase / 100;
            $price = $price + ($price * $percentage);
        }
    }

    return $price;
}
add_filter( 'woocommerce_product_variation_get_price', 'change_variation_price_based_on_percentage_increase', 10, 2 );



add_filter( 'woocommerce_get_price_html', 'change_variable_products_price_display', 10, 2 );
function change_variable_products_price_display( $price, $product ) {

    // Only for variable products type
    if( ! $product->is_type('variable') ) return $price;

    $prices = $product->get_variation_prices( true );

    if ( empty( $prices['price'] ) )
        return apply_filters( 'woocommerce_variable_empty_price_html', '', $product );

    $min_price = current( $prices['price'] );
    $max_price = end( $prices['price'] );
    $prefix_html = '<span class="price-prefix">' . __('Desde:&nbsp;') . '</span>';

    $prefix = $min_price !== $max_price ? $prefix_html : ''; // HERE the prefix

    return apply_filters( 'woocommerce_variable_price_html', $prefix . wc_price( $min_price ) . $product->get_price_suffix(), $product );
}

// add_action('woocommerce_single_product_summary', 'move_single_product_price', 1);
// function move_single_product_price() {
//     remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
//     add_action('woocommerce_before_add_to_cart_quantity', 'woocommerce_template_single_price', 29);
// }


/* function action_woocommerce_single_product_summary() {
    global $product;
    
    // Getters
    $price = $product->get_price();
    $currency_symbol = get_woocommerce_currency_symbol();
    
    // let's setup our div
    echo sprintf('<div id="product_total_price" style="margin-bottom:20px;">%s %s</div>', __('Product Total:','woocommerce'), '<span class="price">' . $currency_symbol . $price . '</span>' );
    ?>
    <script>
    jQuery(function($) {
        // jQuery variables
        var price = <?php echo $price; ?>, 
            currency = '<?php echo $currency_symbol; ?>',
            quantity =  $( '[name=quantity]' ).val();
            
        // Code to run when the document is ready
        var product_total = parseFloat( price * quantity );
        $( '#product_total_price .price' ).html( currency + product_total.toFixed( 2 ) );
            
        // On change
        $( '[name=quantity]' ).change( function() {
            if ( ! ( this.value < 1 ) ) {
                product_total = parseFloat( price * this.value );

                $( '#product_total_price .price' ).html( currency + product_total.toFixed( 2 ) );
            }
        });
    });
    </script>
    <?php

}
// We are going to hook this on priority 31, so that it would display below add to cart button.
add_action( 'woocommerce_after_add_to_cart_quantity', 'action_woocommerce_single_product_summary', 31, 0 ); */
