<?php
/**
 * Haven functions and definitions.
 * 
 * @package Haven
 */

if ( ! function_exists( 'haven_setup' ) ) :

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function haven_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'haven', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'content-width', 920 );
	add_image_size( 'featured', 1000, 650, true );

	// Enable support for Theme Logo.
	add_theme_support( 'custom-logo', array(
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'haven' ),
	) );

	// Enable HTML5 markup.
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'gallery' ) );
	
}

endif; // haven_setup
add_action( 'after_setup_theme', 'haven_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
function haven_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'haven_content_width', 740 );
}
add_action( 'after_setup_theme', 'haven_content_width', 0 );


/**
 * Register widget area.
  */
function haven_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'haven' ),
		'id'            => 'sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'haven' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer (for Instagram)', 'haven' ),
		'id'            => 'footer',
		'description'   => esc_html__( 'Footer widget area for Instagram photos.', 'haven' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'haven_widgets_init' );


/**
 * Return the Google font stylesheet URL
 */
function haven_fonts_url() {

	$fonts_url = '';

	$font_families = array();

	$font_families[] = 'NotoSans:400,700,400italic,700italic';
	$font_families[] = 'Playfair+Display:400,400italic,700,700italic';
	$font_families[] = 'Merriweather:400,400i,700,700i';

	$query_args = array(
		'family' => implode( '|', $font_families ),
		'subset' => 'latin,latin-ext',
	);

	$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

	return $fonts_url;
}


/**
 * Enqueue scripts and styles.
 */
function haven_scripts() {

	// Main theme stylesheet
	wp_enqueue_style( 'haven-style', get_stylesheet_uri() );

	// Load Noto Sans from Google
	wp_enqueue_style( 'haven-fonts', haven_fonts_url(), array(), null );

	// Font Awesome Icons
    wp_enqueue_style( 'haven-font-awesome', get_stylesheet_directory_uri() . "/inc/font-awesome/font-awesome.min.css", array(), array(), null );

	// Fire up jQuery 
	wp_enqueue_script( 'jquery' );

	// Load Haven's scripts
	wp_enqueue_script( 'haven-js', get_template_directory_uri() . '/js/haven.js', array('jquery'), '', true );

	// Load the comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	// Load third-party plugins
	wp_enqueue_script( 'jquery-cycle', get_template_directory_uri() . '/inc/plugins/jquery.cycle2.min.js', array('jquery'), '', true );
	wp_enqueue_script( 'slicknav', get_template_directory_uri() . '/inc/plugins/jquery.slicknav.min.js', array('jquery'), '', true );
	wp_enqueue_style( 'slicknav-css', get_stylesheet_directory_uri() . "/inc/plugins/slicknav.min.css", array(), array(), null );
	wp_enqueue_script('jquery-fitvids', get_template_directory_uri() . '/inc/plugins/jquery.fitvids.js', 'jquery', '', true);



}

add_action( 'wp_enqueue_scripts', 'haven_scripts' );


/**
 * Enqueue Google fonts style to admin for editor styles 
 */
function haven_admin_fonts( $hook_suffix ) {
	wp_enqueue_style( 'haven-fonts', haven_fonts_url(), array(), null );
}
add_action( 'admin_enqueue_scripts', 'haven_admin_fonts' );



/**
 * Custom widgets for Haven.
 */
include("inc/widgets/widget-featured-posts.php");
include("inc/widgets/widget-featured-author.php");
include("inc/widgets/widget-social-links.php");

/**
 * Custom template tags for Haven.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Customizer theme options.
 */
require get_template_directory() . '/inc/customizer-controls.php';
require get_template_directory() . '/inc/customizer-styles.php';
require get_template_directory() . '/inc/customizer.php';




/*----------------------------------------------------------------------------
	Additional social media user meta
----------------------------------------------------------------------------*/

function haven_social_user_meta( $contactmethods ) {

	$contactmethods['facebook'] = 'Facebook URL';
	$contactmethods['twitter'] = 'Twitter URL';
	$contactmethods['google'] = 'Google+ URL';
	$contactmethods['tumblr'] = 'Tumblr URL';
	$contactmethods['instagram'] = 'Instagram URL';
	$contactmethods['pinterest'] = 'Pinterest URL';
	$contactmethods['youtube'] = 'YouTube URL';
	$contactmethods['bloglovin'] = 'Bloglovin URL';

	return $contactmethods;
}
add_filter('user_contactmethods','haven_social_user_meta',10,1);


/*----------------------------------------------------------------------------
	Comments Layout callback
----------------------------------------------------------------------------*/

function haven_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		
		<div class="thecomment">
					
			<div class="author-img">
				<?php echo get_avatar($comment,$args['avatar_size']); ?>
			</div>
			
			<div class="comment-text">
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('reply_text' => __('Reply', 'haven'), 'depth' => $depth, 'max_depth' => $args['max_depth'])), $comment->comment_ID); ?>
					<?php edit_comment_link(__('Edit', 'haven')); ?>
				</span>
				<span class="author"><?php echo get_comment_author_link(); ?></span>
				<span class="date"><?php printf(__('%1$s at %2$s', 'haven'), get_comment_date(),  get_comment_time()) ?></span>
				<?php if ($comment->comment_approved == '0') : ?>
					<em><i class="icon-info-sign"></i> <?php _e('Comment awaiting approval', 'haven'); ?></em>
					<br />
				<?php endif; ?>
				<?php comment_text(); ?>
			</div>
					
		</div>
		
		
	</li>

	<?php 
}


/*----------------------------------------------------------------------------
	Add body classes for selected layout options
----------------------------------------------------------------------------*/

function haven_layout_body_class($classes) {
	$classes[] = get_theme_mod('hvn_theme_layout', 'layout-big-grid');
	return $classes;
}

add_filter( 'body_class', 'haven_layout_body_class' );


function haven_sidebar_position_body_class($classes) {
	$classes[] = get_theme_mod('hvn_sidebar_position', 'sidebar-right');
	return $classes;
}

add_filter( 'body_class', 'haven_sidebar_position_body_class' );


/**
 * Checkbox sanitization callback.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */

function haven_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Select sanitization callback.
 * 
 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
 * as a slug, and then validates `$input` against the choices defined for the control.
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
function haven_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Number sanitization callback.
 *
 * Sanitization callback for 'number' type text inputs. This callback sanitizes `$number`
 * as an absolute integer (whole number, zero or greater).
  *
 * @param int                  $number  Number to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return int Sanitized number; otherwise, the setting default.
 */
function haven_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	
	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}