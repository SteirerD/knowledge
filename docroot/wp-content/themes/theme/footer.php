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
    <div class="l-container">
      <div class="c-main-footer__nav">
        <?php
          wp_nav_menu( array(
                         'theme_location' => 'main-footer',
                         'container' => false,
                         'menu_class' => 'c-main-footer__nav-ul',
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
