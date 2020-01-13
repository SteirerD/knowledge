<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wiki
 */

?>

	</div><!-- #content -->

  <footer class="c-main-footer">
    <div class="l-container c-main-footer__wrapper">
      <div class="c-main-header__logo">
        <a class="c-main-header__link-wrapper" href="<?php echo esc_url( home_url( '/' ) ); ?>">
          <img class="c-main-header__logo-img"
               src="<?php echo get_template_directory_uri() ?>/assets/img/book-open-solid-white.svg">
          <div class="c-main-header__Title"><?php _e( 'Daniel´s Enzyklopädie des Wissens', 'wiki' ) ?></div>
        </a>
      </div>
      <div class="c-main-footer__nav ">
        <?php
          wp_nav_menu( array(
                         'theme_location' => 'footermenu',
                         'container' => false,
                         'menu_class' => 'c-main-footer__nav-ul list-item-white',
                         'depth' => 1,
                       ) );
        ?>
      </div>
    </div>
  </footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
