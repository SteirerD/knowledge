<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wiki
 */

?>

<section class="no-results not-found">
	<header class="c-page-header">
		<h1 class="c-page-header__title"><?php esc_html_e( 'Leider konnte nichts gefunden werden', 'wiki' ); ?></h1>
	</header><!-- .page-header -->

	<div class="c-page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Bereit einen Eintrag zu schreiben? <a href="%1$s">Starte hier</a>.', 'wiki' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p><?php esc_html_e( 'Leider konnte nichts mit dem angegebenen Suchbegriff gefunden werden.', 'wiki' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p><?php esc_html_e( 'Leider konnte hier nichts gefunden werden.', 'wiki' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
