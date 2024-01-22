<?php /* Template Name: Contactpage */

// Fetch theme header template
get_header(); ?>

	<main id="contact" class="site-main section">

		<?php get_template_part('template-parts/content', 'page'); ?>
        <h1>Contacta con nosotros</h1>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil porro quas fugit eaque odio, obcaecati cupiditate, deserunt officiis quibusdam voluptas, hic iusto! Saepe sint autem recusandae explicabo, optio laborum dolor.</p>
        <div class="formulario">
            <?php echo do_shortcode( '[contact-form-7 id="82" title="Formulario de contacto 1"]' ); ?>
        </div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();