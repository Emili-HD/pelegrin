<?php 
/* Template Name: Homepage2 */

// Fetch theme header template
get_header(); ?>

	<main id="primary" class="site-main">

		<section class="section hero-heading grid-row">

			<!-- SWIPER SLIDER NESTED DE IMÁGENES DE CATEGORÍAS -->
			<div class="swiper mySwiper swiper-products">
			<div class="swiper-wrapper">
					<?php 
						$orderby = 'menu_order';
						$order = 'asc';
						$hide_empty = true;
						$cat_args = array(
							'orderby'    => $orderby,
							'order'      => $order,
							'hide_empty' => $hide_empty,
							'parent' 	 => 0,
						);
						
						$product_categories = get_terms( 'product_cat', $cat_args );
						
						if( !empty($product_categories) ){
							foreach ($product_categories as $key => $category) {
								echo '<div class="swiper-slide slide slide-product">';
								$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
								$image = wp_get_attachment_url($thumbnail_id);
								echo "<img src='{$image}' alt=''/>";
								echo '<a class="" href="'.get_term_link($category).'" >';
								// echo '<span class="arrow-text">';
								echo $category->name;
								// echo '</span>';
								echo '<span class="arrow arrow-right"></span></a>';
								echo '</div>';
							}
						}
					?>
				</div>
				<div class="swiper-navigation invert">
					<div class="swiper-button-next arrow-button"><span class="arrow arrow-right"></span></div>
					<div class="swiper-button-prev arrow-button"><span class="arrow arrow-left"></span></div>
				</div>
			</div>

			<div class="imagenes__fondo"></div>

			<!-- SWIPER SLIDER DE CATEGORÍAS -->
			<div class="swiper mySwiper swiper-categories">
				<div class="swiper-wrapper">
					<?php 
						$orderby = 'menu_order';
						$order = 'asc';
						$hide_empty = true;
						$cat_args = array(
							'orderby'    => $orderby,
							'order'      => $order,
							'hide_empty' => $hide_empty,
							'parent' 	 => 0,
						);
						
						$product_categories = get_terms( 'product_cat', $cat_args );
						
						if( !empty($product_categories) ){
							foreach ($product_categories as $key => $category) {
								$thumbnail_id = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );
								$image = wp_get_attachment_url($thumbnail_id);
								/* echo "<img src='{$image}' alt=''/>"; */
								echo "<div class='swiper-slide slide-cat' data-image='{$image}'' >";
								echo '<a class="arrow-button invert" href="'.get_term_link($category).'" >';
								echo '<span class="arrow-text">';
								echo $category->name;
								echo '</span>';
								echo '<span class="arrow arrow-right"></span></a>';
								echo '</div>';
							}
						}
					?>
				</div>
				<div class="swiper-navigation">
					<div class="swiper-button-next arrow-button"><span class="arrow arrow-right"></span></div>
					<div class="swiper-button-prev arrow-button"><span class="arrow arrow-left"></span></div>
				</div>
			</div>


		</section>
			

		<?php if( have_rows('secciones_home') ): ?>
			<?php while( have_rows('secciones_home') ): the_row(); ?>
			
				<section id="section-<?php echo get_row_index(); ?>" class="section hero-heading grid-row">
					<div class="section-descripcion">
						<div class="title">
							<h2 class="productos_destacados-titulo"><?php the_sub_field('titulo_seccion'); ?></h2>
						</div>
						<div class="text">
							<p><?php the_sub_field('texto_seccion'); ?></p>
						</div>
					</div>
					
					<div class="section-grid">
						<?php echo do_shortcode( get_sub_field('tipo_de_contenido') ) ?>
					</div>
				</section>
 
			<?php endwhile; ?>
		<?php endif; ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();

