<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Haven
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	
	<nav id="site-navigation" class="main-navigation" role="navigation">
		<div class="container">

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'main-menu' ) ); ?>

			<div class="social-menu">
				<?php if(get_theme_mod('hvn_facebook')) : ?><a href="http://facebook.com/<?php echo get_theme_mod('hvn_facebook'); ?>" target="_blank"><i class="fa fa-facebook"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_twitter')) : ?><a href="http://twitter.com/<?php echo get_theme_mod('hvn_twitter'); ?>" target="_blank"><i class="fa fa-twitter"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_instagram')) : ?><a href="http://instagram.com/<?php echo get_theme_mod('hvn_instagram'); ?>" target="_blank"><i class="fa fa-instagram"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_pinterest')) : ?><a href="http://pinterest.com/<?php echo get_theme_mod('hvn_pinterest'); ?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_bloglovin')) : ?><a href="http://bloglovin.com/<?php echo get_theme_mod('hvn_bloglovin'); ?>" target="_blank"><i class="fa fa-heart"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_google')) : ?><a href="http://plus.google.com/<?php echo get_theme_mod('hvn_google'); ?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_tumblr')) : ?><a href="http://<?php echo get_theme_mod('hvn_tumblr'); ?>.tumblr.com/" target="_blank"><i class="fa fa-tumblr"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_youtube')) : ?><a href="http://youtube.com/<?php echo get_theme_mod('hvn_youtube'); ?>" target="_blank"><i class="fa fa-youtube-play"></i></a><?php endif; ?>
				<?php if(get_theme_mod('hvn_rss')) : ?><a href="<?php echo get_theme_mod('hvn_rss'); ?>" target="_blank"><i class="fa fa-rss"></i></a><?php endif; ?>
			</div>

		</div>
	</nav><!-- #site-navigation -->

	<header id="masthead" class="site-header" role="banner">

		<div class="container">
			
			<div class="site-branding">
				<?php haven_theme_logo(); ?>

				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

		</div>

	</header><!-- #masthead -->

	<div id="content" class="site-content">
