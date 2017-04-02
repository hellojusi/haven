<?php
/**
 * Template part for displaying posts.
 *
 * @package Haven
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( false == get_theme_mod( 'hvn_hide_category', false )) : ?>
			<span class="cat"><?php the_category(', '); ?></span>
		<?php endif; ?>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<div class="entry-meta">
			<?php haven_posted_on(); ?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php if ( has_post_format('gallery')  ) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	        <?php haven_gallery_format_slideshow('content-width'); ?>
	    </a>
	<?php endif; ?>

	<?php if ( has_post_thumbnail() && !has_post_format('gallery') ) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	        <?php the_post_thumbnail('featured'); ?>
	    </a>
	<?php endif; ?>

	<div class="entry-content">

		<?php
			the_excerpt();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'haven' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php haven_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
