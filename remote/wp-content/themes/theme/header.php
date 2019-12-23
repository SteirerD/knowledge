<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wiki
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
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Zum Inhalt springen', 'wiki' ); ?></a>

	<header id="masthead" class="c-main-header">
    <div class="l-container c-main-header__wrapper">
      <div class="c-main-header__logo">
        <a class="c-main-header__link-wrapper" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <img class="c-main-header__logo-img" src="<?php echo get_template_directory_uri()?>/assets/img/book-open-solid.svg">
          <div class="c-main-header__Title"><?php _e('Daniel´s Enzyklopädie des Wissens' ,'wiki') ?></div>
        </a>
      </div><!-- .site-branding -->

      <div class="c-main-header__nav-trigger-wrapper">
        <div class="c-main-header__nav-trigger">
          <div class="c-main-header__nav-trigger-bar"></div>
          <div class="c-main-header__nav-trigger-bar"></div>
          <div class="c-main-header__nav-trigger-bar"></div>
        </div>
      </div>
    </div>

<!--      <nav id="site-navigation" class="c-main-navigation">-->
<!--        --><?php
//          wp_nav_menu( array(
//                         'theme_location'   => 'mainmenu',
//                         'menu_id'          => 'primary-menu',
//                         'container_class'  => 'c-main-navigation__menu-container',
//                         'menu_class'       => 'c-main-navigation__menu'
//                       ) );
//        ?>
<!--      </nav>
    </div>

	</header><!-- #masthead -->

	<div id="content" class="c-main-site__content">
