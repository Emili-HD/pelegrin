<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package pelegrinroca
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Permissions-Policy" content="interest-cohort=()">

	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
	<link href="https://fonts.cdnfonts.com/css/satoshi" rel="stylesheet">
                
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'pelegrin' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<div class="logo-wrapper">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$pelegrin_description = get_bloginfo( 'description', 'display' );
				if ( $pelegrin_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $pelegrin_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div>

			<nav id="site-navigation" class="main-navigation">
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'pelegrin' ); ?></button> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
			<div class="user__navigation">
				<ul>
					<!-- <li> -->
						<!-- <img src="/wp-content/uploads/2023/05/Search.svg" width="24" height="24" /> -->
						<?php /* aws_get_search_form( true ); */ ?>
					<!-- </li> -->
					<li><img src="/wp-content/uploads/2023/05/User.svg" width="24" height="24" /></li>
					<li>
						<a href="/carrito">
							<img src="/wp-content/uploads/2023/05/Cart.svg" width="24" height="24" />
							<span class="counter"><?php echo do_shortcode( '[cart_count]' ); ?></span>
						</a>
					</li>
					<li class="menu-toggle"><span class="linea linea1"></span><span class="linea linea2"></span></li>
				</ul>
			</div>
		</div><!-- .site-branding -->

		<div class="menu-mobile section">
			<nav id="mobile-navigation" class="mobile-navigation">
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'pelegrin' ); ?></button> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'mobile',
						'menu_id'        => 'mobile-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>

		<div class="menu-categorias section">
			<div id="categorias-iconos"></div>
			<a class="categorias-button arrow-button invert" href="#" >
			<span class="arrow arrow-left"></span><span class="arrow-text">CERRAR CATEGORÍAS</span>
			</a>
			<nav id="categorias-navigation" class="categorias-navigation">
				<!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'pelegrin' ); ?></button> -->
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'categorias',
						'menu_id'        => 'categorias-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>

	</header><!-- #masthead -->

	<div id="smooth-wrapper">
    	<div id="smooth-content">
