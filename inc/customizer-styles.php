<?php
/*----------------------------------------------------------------------------
	Additional CSS for Customizer colors
----------------------------------------------------------------------------*/

function haven_customizer_colors() {
    ?>

    <style type="text/css">

    	body { background-color: <?php echo get_theme_mod( 'hvn_bg_color' ); ?>; }
		.main-navigation, .main-navigation ul ul { background-color: <?php echo get_theme_mod( 'hvn_topbar_color' ); ?>; }
		.site-footer { background-color: <?php echo get_theme_mod( 'hvn_footer_color' ); ?>; }
		.posts-navigation a:hover, .posts-navigation span:hover, .widget_mc4wp_form_widget input[type="submit"]:hover, button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, #infinite-handle span:hover {
			background-color: <?php echo get_theme_mod( 'hvn_accent_color' ); ?>;
		}
		h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, a, .main-navigation a:hover, .post-navigation .nav-links div a:hover, .entry-header .cat a, .tags-links a:hover, .post-share a:hover, .widget_archive ul li a:hover, .widget_categories ul li a:hover, .widget_pages ul li a:hover, .widget_meta ul li a:hover, .widget_tag_cloud a:hover, .widget_calendar tbody td a:hover, .widget_haven_featured_author .author-social-links a:hover, .site-title a:hover, .site-footer .btn-back-top a:hover, .entry-more-link:hover {
			color: <?php echo get_theme_mod( 'hvn_accent_color' ); ?>;
		}
		.entry-header .cat a, .tags-links a:hover, .widget_tag_cloud a:hover {
			border-color: <?php echo get_theme_mod( 'hvn_accent_color' ); ?>;
		}
		

		
    </style>
    <?php
}
add_action( 'wp_head', 'haven_customizer_colors' );

?>