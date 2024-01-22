<?php /* Template Name: Nosotrospage */

// Fetch theme header template
get_header(); ?>

	<main id="nosotros" class="site-main section">

		<?php /* get_template_part('template-parts/content', 'page'); */ ?>
        <div class="about-title"><h1>¡Bienvenidos a Pelegrín, la papelería que marca la diferencia desde 1976!</h1></div>

        <?php if( have_rows('seccion_nosotros') ): ?>
			<?php while( have_rows('seccion_nosotros') ): the_row(); 
					$image = get_sub_field('imagen_nosotros');
			?>
			
				<section id="section-nosotros-<?php echo get_row_index(); ?>" class="section-nosotros">
				<?php if ($image): ?>
					<div class="about-image"><img class="imagen-nosotros" src="<?php echo $image; ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>"></div>
				<?php endif; ?>
					<div class="about-text"><?php the_sub_field('parrafo_nosotros'); ?></div>
				</section>
 
			<?php endwhile; ?>
		<?php endif; ?>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
