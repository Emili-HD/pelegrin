<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pelegrinroca
 */

?>

	<footer id="colophon" class="site-footer">
		<section class="footer-contenedor-info">
			<div class="footer-contenedor-info_iz">
				<aside id="footer-2" class="widget-area">
				<?php dynamic_sidebar( 'footer-logo' ); ?>
				<ul class="social">
						<li><img src="/wp-content/uploads/2023/06/Facebook.svg" width="24" height="24" /></li>
						<li><img src="/wp-content/uploads/2023/06/Instagram.svg" width="24" height="24" /></li>
						<li><img src="/wp-content/uploads/2023/06/Linkedin.svg" width="24" height="24" /></li>
						<li><img src="/wp-content/uploads/2023/06/Twiter.svg" width="24" height="24" /></li>
				</ul>
				<div class="footer-contenedor-copyright">Copyright 2023 - Pelegrin Roca</div>
				</aside>
				<aside id="footer-1" class="widget-area">
				<?php dynamic_sidebar( 'footer-newsletter' ); ?>
				<div class="newsletter_input">
					<input type="text" placeholder="correo@correo.com...">
					<input type="submit" value="SUSCRIBIRTE">
				</div>
				</aside>
				
			</div>
			<div class="footer-contenedor-info_der">
				<aside id="footer-3" class="widget-area">
				<?php dynamic_sidebar( 'footer-general' ); ?>
				</aside>
				<aside id="footer-4" class="widget-area">
				<?php dynamic_sidebar( 'footer-legal' ); ?>
				</aside>
				<aside id="footer-5" class="widget-area">
				<?php dynamic_sidebar( 'footer-contacto' ); ?>
				</aside>
				<aside id="footer-6" class="widget-area">
				<?php dynamic_sidebar( 'footer-kitdigital' ); ?>
				</aside>
			</div>
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->
</div><!-- #smooth-content -->
</div><!-- #smooth-wrapper -->

<?php wp_footer(); ?>

</body>
</html>
