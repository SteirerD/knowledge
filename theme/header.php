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
          <img class="c-main-header__logo-img"
               src="<?php echo get_template_directory_uri() ?>/assets/img/book-open-solid.svg">
          <div class="c-main-header__Title"><?php _e( 'Daniel´s Enzyklopädie des Wissens', 'wiki' ) ?></div>
        </a>
      </div><!-- .site-branding -->

      <div class="c-navbar-right">
        <div class="c-add-post">
          <svg class="c-add-post__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 232.14 240.6"><defs><style>.cls-1{fill:#f9f7f7;}.cls-2{fill:#020202;}</style></defs><title>new0</title><g id="Ebene_2" data-name="Ebene 2"><g id="Ebene_1-2" data-name="Ebene 1"><path d="M192.15,193.85,231.63,85.39a8.22,8.22,0,0,0-4.92-10.57L120.82,36.28A33,33,0,0,0,78.55,56L41,159.29a33,33,0,0,0,19.71,42.27L166.55,240.1a8.23,8.23,0,0,0,10.57-4.93L179,230a8.29,8.29,0,0,0-.68-7.08c.45-5.47,5.61-19.64,8.78-24.12a8.19,8.19,0,0,0,5.05-5ZM115.41,83.3a2.07,2.07,0,0,1,2.64-1.24L186.49,107a2.08,2.08,0,0,1,1.23,2.65l-2.35,6.45a2.06,2.06,0,0,1-2.64,1.23L114.29,92.4a2.07,2.07,0,0,1-1.23-2.65ZM107.89,104a2.06,2.06,0,0,1,2.64-1.23L179,127.63a2.08,2.08,0,0,1,1.23,2.65l-2.35,6.45a2.06,2.06,0,0,1-2.64,1.23l-68.44-24.9a2.07,2.07,0,0,1-1.23-2.65Zm52.43,110.47L68.18,180.9a11,11,0,1,1,7.52-20.66l92.14,33.53A122.71,122.71,0,0,0,160.32,214.43Z"/><rect class="cls-1" x="46.77" y="-1.6" width="28.35" height="121.89" transform="translate(1.6 120.29) rotate(-90)"/><rect class="cls-1" x="46.39" width="28.82" height="46.59" transform="translate(121.6 46.59) rotate(-180)"/><rect class="cls-1" x="46.39" y="72.1" width="28.82" height="46.59" transform="translate(121.6 190.79) rotate(-180)"/><rect class="cls-2" x="1.27" y="46.59" width="119.06" height="25.51"/><rect x="48.04" y="1.99" width="25.51" height="44.6"/><rect x="48.19" y="72.1" width="25.51" height="44.6"/></g></g></svg>
          <a class="c-add-post__link" href="#new"></a>
          <div class="c-add-post__tooltip">
            <div class="c-user-name"><?php _e('Neues Wissen einreichen','wiki')?> </div>
          </div>
        </div>
        <div class="c-user-login">
          <?php if( ! is_user_logged_in()) : ?>
            <svg class="c-user-login__svg is-not-logged-in" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-in-alt"
                 role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor"
                    d="M416 448h-84c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h84c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32h-84c-6.6 0-12-5.4-12-12V76c0-6.6 5.4-12 12-12h84c53 0 96 43 96 96v192c0 53-43 96-96 96zm-47-201L201 79c-15-15-41-4.5-41 17v96H24c-13.3 0-24 10.7-24 24v96c0 13.3 10.7 24 24 24h136v96c0 21.5 26 32 41 17l168-168c9.3-9.4 9.3-24.6 0-34z"></path>
            </svg>
            <div class="c-user-login__tooltip-login"><a href="#login">einloggen</a></div>
            <a class="c-user-login__link" href="#login"></a>
          <?php
          else : ?>
            <svg class="c-user-logout__svg is-logged-in" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sign-out-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path></svg>
            <div class="c-user-login__tooltip-logout"><div class="c-user-name">Ausloggen. <br>Aktueller User: <?php echo wp_get_current_user()->display_name ?></div></div>
            <form class="c-user-logout__data">
              <input type="hidden" name="action" value="usersignout">
              <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'usersignout-nonce' ); ?>">
            </form>
           
          <?php endif; ?>
        </div>
        

        <div class="c-main-header__nav-trigger-wrapper">
          <div class="c-main-header__nav-trigger">
            <div class="c-main-header__nav-trigger-bar"></div>
            <div class="c-main-header__nav-trigger-bar"></div>
            <div class="c-main-header__nav-trigger-bar"></div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="c-search-form">
      <?php get_search_form(); ?>
    </div>


	</header>

	<div id="content" class="c-main-site__content">
