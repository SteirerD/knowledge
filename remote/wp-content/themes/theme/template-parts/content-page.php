<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wiki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('c-entry c-entry--page'); ?>>
	<header class="c-entry__header">
		<?php the_title( '<h1 class="c-entry__header-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<?php wiki_post_thumbnail(); ?>

	<div class="c-entry__content">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wiki' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="c-entry__footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Bearbeite <span class="screen-reader-text">%s</span>', 'wiki' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
