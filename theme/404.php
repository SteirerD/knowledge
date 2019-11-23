<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package GLC
 */

get_header();
?>

  <main class="c-main-site__content-area c-main-site__content-area--error-404">

    <section class="c-error-404">
      <div class="l-container l-container--no-padding">
        <h1 class="c-error-404__headline"><?php _e('Die gesuchte Seite wurde leider nicht gefunden.', 'glc'); ?></h1>
      </div>
    </section>

  </main><!-- #main -->

<?php
get_footer();
