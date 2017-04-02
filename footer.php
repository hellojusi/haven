<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the #content div and all content after.
 *
 * @package Haven
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">

		<div class="footer-instagram">
			<?php dynamic_sidebar( 'footer' ); ?>
		</div>

		<div class="site-info">

			<?php if ( get_theme_mod('hvn_footer_text', '') ) {
				echo get_theme_mod('hvn_footer_text', ''); 
			} ?>
			
			<?php if ( false == get_theme_mod( 'hvn_disable_back_top', false )) : ?>
				<div class="btn-back-top">
					<a href="#"><?php echo esc_html__('Back to top', 'haven' ); ?> <i class="fa fa-angle-double-up"></i></a>
				</div>
			<?php endif; ?>

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>