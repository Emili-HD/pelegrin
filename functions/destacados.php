<?php
/**
 * pelegrinroca funciones destacados
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pelegrinroca
 */


 /*================================================================================
							SHORTCODE PRODUCTOS DESTACADOS
==================================================================================*/

add_shortcode( 'destacados', 'pele_destacados' );

function pele_destacados(){
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' =>	12,
		'post_status'	 =>	'publish',
		'tax_query'		 => array(array(
			'taxonomy'		=> 'product_visibility',
			'field'			=> 'name',
			'terms'			=> 'featured',
		))
	);

	$sale_product = new WP_Query( $args );

	if ($sale_product->have_posts(  )):

		ob_start();

		while ( $sale_product -> have_posts(  ) ) : $sale_product -> the_post(  );

			$product				= wc_get_product( $sale_product -> post -> ID);
			$post_thumbnail_id		= get_post_thumbnail_id(  );
			$product_thumbnail		= wp_get_attachment_image_src( $post_thumbnail_id, $size , 'shop_feature' );
			$product_thumbnail_alt 	= get_post_meta( $post_thumbnail_id, 'wp_attachment_image_alt', true );

			$antes		= get_post_meta( get_the_ID(  ), '_regular_price', true ); 	//precio regular
			$link		= get_permalink( $product->ID );	//link del producto
			
			?>
				<div class="producto" data-tilt   data-tilt-glare data-tilt-max-glare="0.8" data-tilt-perspective="500">
					<div class="producto-wishlist">
						<div class="producto-wishlist-caja">
							<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg" class="producto-wishlist-caja-icono">
                    			<path d="M5.06749 1.03442C8.05938 1.03441 9.25613 4.29345 9.25613 4.29345C9.25613 4.29345 11.0513 1.03442 14.0432 1.03442C17.0351 1.03442 19.4286 4.29345 17.6335 8.20428C15.8383 12.1151 9.25613 17.3296 9.25613 17.3296C9.25613 17.3296 2.67396 12.1151 0.878853 8.20428C-0.916254 4.29345 2.07559 1.03443 5.06749 1.03442Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"></path>
                			</svg>
						</div>
					</div>
					<h3 class="producto-titulo"><?php the_title();?></h3>
					<div class="producto-imagen" style="background-image: url(<?php echo $product_thumbnail[0];?>); background-position: center; background-size: cover;"></div>
					<div class="producto-inferior">
						<div class="producto-inferior-precios">
							desde
							<?php if( $product->is_type( 'variable' ) ){ ?>
							<div class="producto-inferior-precios-antes"><?php echo ($product->get_variation_sale_price()). "€";?></div>
							<?php }else{ ?>
							<div class="producto-inferior-precios-antes"><?php echo $antes. "€"; ?></div>
							<?php } ?>
						</div>
						<a href="<?php echo $link; ?>" class="producto-inferior-opciones">
							<p class="producto-inferior-opciones-parrafo">Ver producto</p>
							<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="producto-inferior-opciones-icono">
                        		<path d="M11.2006 3.95035H4.23371C3.70578 3.95035 3.19948 4.15845 2.82618 4.52886C2.45288 4.89928 2.24316 5.40167 2.24316 5.92552V19.7517C2.24316 20.2755 2.45288 20.7779 2.82618 21.1483C3.19948 21.5188 3.70578 21.7269 4.23371 21.7269H18.1675C18.6954 21.7269 19.2017 21.5188 19.575 21.1483C19.9483 20.7779 20.1581 20.2755 20.1581 19.7517V12.8386" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                        		<path d="M18.6652 2.46895C19.0611 2.07607 19.5982 1.85535 20.1581 1.85535C20.7181 1.85535 21.2551 2.07607 21.651 2.46895C22.047 2.86184 22.2694 3.3947 22.2694 3.95033C22.2694 4.50595 22.047 5.03882 21.651 5.4317L12.1959 14.8137L8.21484 15.8013L9.21012 11.851L18.6652 2.46895Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    		</svg>
						</a>
					</div>		
				</div>

			<?php
			
		endwhile;
	endif;

	wp_reset_query(  );

	return ob_get_clean();
		

}

/*================================================================================
							SHORTCODE PRODUCTOS RELACIONADOS
==================================================================================*/

add_shortcode( 'relacionados', 'pele_relacionados' );

function pele_relacionados(){
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' =>	4,
		'post_status'	 =>	'publish',
		'order_by'		 => 'rand',
	);

	$sale_product = new WP_Query( $args );

	if ($sale_product->have_posts(  )):

		ob_start();

		while ( $sale_product -> have_posts(  ) ) : $sale_product -> the_post(  );

			$product				= wc_get_product( $sale_product -> post -> ID);
			$post_thumbnail_id		= get_post_thumbnail_id(  );
			$product_thumbnail		= wp_get_attachment_image_src( $post_thumbnail_id, $size , 'shop_feature' );
			$product_thumbnail_alt 	= get_post_meta( $post_thumbnail_id, 'wp_attachment_image_alt', true );

			$antes		= get_post_meta( get_the_ID(  ), '_regular_price', true ); 	//precio regular
			$link		= get_permalink( $product->ID );	//link del producto
			
			?>
				<div class="product">
					<div class="wishlist">
						<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    		<path d="M5.06749 1.03442C8.05938 1.03441 9.25613 4.29345 9.25613 4.29345C9.25613 4.29345 11.0513 1.03442 14.0432 1.03442C17.0351 1.03442 19.4286 4.29345 17.6335 8.20428C15.8383 12.1151 9.25613 17.3296 9.25613 17.3296C9.25613 17.3296 2.67396 12.1151 0.878853 8.20428C-0.916254 4.29345 2.07559 1.03443 5.06749 1.03442Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"></path>
                		</svg>
					</div>
					<h3 class="titulo"><?php the_title();?></h3>
					<div class="product-image" style="background-image: url(<?php echo $product_thumbnail[0];?>)"></div>
					<div class="precios">
						<?php if( $product->is_type( 'variable' ) ){ ?>
						<div class="antes"><?php echo ($product->get_variation_sale_price()). "€";?></div>
						<?php }else{ ?>
						<div class="antes"><?php echo $antes. "€"; ?></div>
						<?php } ?>
					</div>
					<a href="<?php echo $link; ?>" class="mas_opciones">
					Ver producto
					<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2006 3.95035H4.23371C3.70578 3.95035 3.19948 4.15845 2.82618 4.52886C2.45288 4.89928 2.24316 5.40167 2.24316 5.92552V19.7517C2.24316 20.2755 2.45288 20.7779 2.82618 21.1483C3.19948 21.5188 3.70578 21.7269 4.23371 21.7269H18.1675C18.6954 21.7269 19.2017 21.5188 19.575 21.1483C19.9483 20.7779 20.1581 20.2755 20.1581 19.7517V12.8386" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.6652 2.46895C19.0611 2.07607 19.5982 1.85535 20.1581 1.85535C20.7181 1.85535 21.2551 2.07607 21.651 2.46895C22.047 2.86184 22.2694 3.3947 22.2694 3.95033C22.2694 4.50595 22.047 5.03882 21.651 5.4317L12.1959 14.8137L8.21484 15.8013L9.21012 11.851L18.6652 2.46895Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
					</a>
				</div>

			<?php
			
		endwhile;
	endif;

	wp_reset_query(  );

	return ob_get_clean();
		

}

/*================================================================================
							SHORTCODE PRODUCTOS NUEVOS
==================================================================================*/

add_shortcode( 'nuevos', 'pele_nuevos' );

function pele_nuevos(){
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' =>	8,
		'post_status'	 =>	'publish',
		'order_by'		 => 'date',
    	'order' 		 => 'DESC',
	);

	$sale_product = new WP_Query( $args );

	if ($sale_product->have_posts(  )):

		ob_start();

		while ( $sale_product -> have_posts(  ) ) : $sale_product -> the_post(  );

			$product				= wc_get_product( $sale_product -> post -> ID);
			$post_thumbnail_id		= get_post_thumbnail_id(  );
			$product_thumbnail		= wp_get_attachment_image_src( $post_thumbnail_id, $size , 'shop_feature' );
			$product_thumbnail_alt 	= get_post_meta( $post_thumbnail_id, 'wp_attachment_image_alt', true );

			$antes		= get_post_meta( get_the_ID(  ), '_regular_price', true ); 	//precio regular
			$link		= get_permalink( $product->ID );	//link del producto
			
			?>
				<div class="product">
					<div class="wishlist">
						<svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    		<path d="M5.06749 1.03442C8.05938 1.03441 9.25613 4.29345 9.25613 4.29345C9.25613 4.29345 11.0513 1.03442 14.0432 1.03442C17.0351 1.03442 19.4286 4.29345 17.6335 8.20428C15.8383 12.1151 9.25613 17.3296 9.25613 17.3296C9.25613 17.3296 2.67396 12.1151 0.878853 8.20428C-0.916254 4.29345 2.07559 1.03443 5.06749 1.03442Z" stroke="black" stroke-width="0.5" stroke-linejoin="round"></path>
                		</svg>
						<div class="nuevo">Nuevo</div>
					</div>
					<h3 class="titulo"><?php the_title();?></h3>
					<div class="product-image" style="background-image: url(<?php echo $product_thumbnail[0];?>)"></div>
					<div class="precios">
						<?php if( $product->is_type( 'variable' ) ){ ?>
						<div class="antes"><?php echo ($product->get_variation_sale_price()). "€";?></div>
						<?php }else{ ?>
						<div class="antes"><?php echo $antes. "€"; ?></div>
						<?php } ?>
					</div>
					<a href="<?php echo $link; ?>" class="mas_opciones">
					Ver producto
					<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2006 3.95035H4.23371C3.70578 3.95035 3.19948 4.15845 2.82618 4.52886C2.45288 4.89928 2.24316 5.40167 2.24316 5.92552V19.7517C2.24316 20.2755 2.45288 20.7779 2.82618 21.1483C3.19948 21.5188 3.70578 21.7269 4.23371 21.7269H18.1675C18.6954 21.7269 19.2017 21.5188 19.575 21.1483C19.9483 20.7779 20.1581 20.2755 20.1581 19.7517V12.8386" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M18.6652 2.46895C19.0611 2.07607 19.5982 1.85535 20.1581 1.85535C20.7181 1.85535 21.2551 2.07607 21.651 2.46895C22.047 2.86184 22.2694 3.3947 22.2694 3.95033C22.2694 4.50595 22.047 5.03882 21.651 5.4317L12.1959 14.8137L8.21484 15.8013L9.21012 11.851L18.6652 2.46895Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
					</a>
				</div>

			<?php
			
		endwhile;
	endif;

	wp_reset_query(  );

	return ob_get_clean();
		

}
