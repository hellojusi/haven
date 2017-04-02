<?php
/**
 * Template part for displaying single post.
 *
 * @package Haven
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( false == get_theme_mod( 'hvn_hide_category', false )) : ?>
			<span class="cat"><?php the_category(', '); ?></span>
		<?php endif; ?>

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php haven_posted_on(); ?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php 

	if ( has_post_format('gallery') ) : 

		haven_gallery_format_slideshow('content-width');

	else : 

		if ( has_post_thumbnail() ) :
			the_post_thumbnail('featured');
		endif;

	endif;

	?>

	<div class="entry-content">

		<?php
			the_content();

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