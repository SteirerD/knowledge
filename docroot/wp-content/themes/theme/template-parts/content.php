<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wiki
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('c-entry c-entry--generic'); ?>>
	<header class="c-entry__header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="c-entry__header-title">', '</h1>' );
		else :
			the_title( '<h2 class="c-entry__header-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="c-entry__header-meta">
				<?php
				wiki_posted_on();
				wiki_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php wiki_post_thumbnail(); ?>

	<div class="c-entry__content">
		<?php
		the_content( __('Weiterlesen') );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Seiten:', 'wiki' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<footer class="c-entry__footer">
		<?php wiki_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
