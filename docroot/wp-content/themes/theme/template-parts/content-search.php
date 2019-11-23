<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GLC
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('c-entry c-entry--search'); ?>>
	<header class="c-entry__header">
		<?php the_title( sprintf( '<h2 class="c-entry__header--title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="c-entry__header-meta">
			<?php
			glc_posted_on();
			glc_posted_by();
			?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php glc_post_thumbnail(); ?>

	<div class="c-entry__summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<footer class="c-entry__footer">
		<?php glc_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
