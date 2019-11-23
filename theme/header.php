<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GLC
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="c-main-site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Zum Inhalt springen', 'glc' ); ?></a>

	<header id="masthead" class="c-main-header">
		<div class="c-main-header__logo">
			<?php the_custom_logo(); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="c-main-navigation">
			<?php
        wp_nav_menu( array(
                       'theme_location'   => 'mainmenu',
                       'menu_id'          => 'primary-menu',
                       'container_class'  => 'c-main-navigation__menu-container',
                       'menu_class'       => 'c-main-navigation__menu'
                     ) );
			?>
      <button class="c-main-navigation__togle" aria-controls="primary-menu" aria-expanded="false">
        <?php esc_html_e( 'Hauptmenü', 'glc' ); ?>
      </button>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="c-main-site__content">
