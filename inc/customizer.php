<?php
/**
 * Haven Theme Customizer.
 *
 * @package Haven
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function haven_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'haven_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function haven_customize_preview_js() {
	wp_enqueue_script( 'haven_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'haven_customize_preview_js' );


/**
 * Customizer options
  * @param WP_Customize_Manager $wp_customize
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

function haven_customizer_register( $wp_customize ) {

    $wp_customize->add_panel( 'haven_theme_options', array(
        'title' => __( 'Theme Options', 'haven' ),
        'description' => '',
        'priority' => 10,
    ) );


    //////////////////////////
    // Colors
    /////////////////////////

    $wp_customize->add_section( 'haven_colors_section', array(
        'title'    => __( 'Colors', 'haven' ),
        'priority' => 1,
        'panel' => 'haven_theme_options'
    ) );

    // Background color
    $wp_customize->add_setting( 'hvn_bg_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hvn_bg_color',
            array(
                'label'    => __( 'Background color', 'haven' ),
                'settings' => 'hvn_bg_color',
                'section'  => 'haven_colors_section'
            )
        )
    );

    // Top bar color
    $wp_customize->add_setting( 'hvn_topbar_color', array(
        'default' => '#f5f5f5',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hvn_topbar_color',
            array(
                'label'    => __( 'Top bar color', 'haven' ),
                'settings' => 'hvn_topbar_color',
                'section'  => 'haven_colors_section'
            )
        )
    );

    // Footer color
    $wp_customize->add_setting( 'hvn_footer_color', array(
        'default' => '#f5f5f5',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hvn_footer_color',
            array(
                'label'    => __( 'Footer background color', 'haven' ),
                'settings' => 'hvn_footer_color',
                'section'  => 'haven_colors_section'
            )
        )
    );

    // Accent color
    $wp_customize->add_setting( 'hvn_accent_color', array(
        'default' => '#C28184',
        'sanitize_callback' => 'sanitize_hex_color'
    ));

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'hvn_accent_color',
            array(
                'label'    => __( 'Theme accent color', 'haven' ),
                'settings' => 'hvn_accent_color',
                'section'  => 'haven_colors_section'
            )
        )
    );



    //////////////////////////
    // Layout Options
    /////////////////////////

	$wp_customize->add_section( 'haven_layout_options', array(
		'title'    => __( 'Layout Options', 'haven' ),
		'priority' => 1,
        'panel' => 'haven_theme_options'
	) );

	// Theme layout
    $wp_customize->add_setting( 'hvn_theme_layout', array(
        'default' => 'layout-big-grid',
        'sanitize_callback' => 'haven_sanitize_select'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_theme_layout',
            array(
                'label'    => __( 'Theme Layout', 'haven' ),
                'settings' => 'hvn_theme_layout',
                'section'  => 'haven_layout_options',
                'type'     => 'select',
                'choices'  => array(
                    'layout-big-grid'   => __( 'First big, then grid', 'haven' ),
                    'layout-grid-only'  => __( 'Grid only', 'haven' ),
                    'layout-big-only'   => __( 'Big posts only', 'haven' ),
                ),
            )
        )
    );

    // Sidebar position
    $wp_customize->add_setting( 'hvn_sidebar_position', array(
        'default' => 'sidebar-right',
        'sanitize_callback' => 'haven_sanitize_select'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_sidebar_position',
            array(
                'label'     => __( 'Sidebar Position', 'haven' ),
                'section'   => 'haven_layout_options',
                'settings'  => 'hvn_sidebar_position',
                'type'      => 'radio',
                'choices'   => array(
                    'sidebar-right' => __( 'Right', 'haven' ),
                    'sidebar-left'  => __( 'Left', 'haven' ),
                )
            )
        )
    );


    //////////////////////////
    // Featured Posts
    /////////////////////////

    $wp_customize->add_section( 'haven_featured_section', array(
        'title'    => __( 'Featured Posts', 'haven' ),
        'priority' => 1,
        'panel' => 'haven_theme_options'
    ) );

    // Slider posts select
    $wp_customize->add_setting( 'hvn_slider_posts', array(
        'default' => '',
        'sanitize_callback' => 'haven_sanitize_select'
    ));

    $wp_customize->add_control(
        new WP_Customize_Select_Post_Control(
            $wp_customize,
            'hvn_slider_posts',
            array(
                'label'    => __( 'Featured posts', 'haven' ),
                'description' => __( 'Select posts to display in the slider.', 'haven' ),
                'settings' => 'hvn_slider_posts',
                'section'  => 'haven_featured_section',
                'type'     => 'select_post_dropdown',
            )
        )
    );

     // Slider timeout
    $wp_customize->add_setting( 'hvn_slider_timeout', array(
        'default' => '5000',
        'sanitize_callback' => 'haven_sanitize_number_absint'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_slider_timeout',
            array(
                'label'       => __( 'Slide transition time', 'haven' ),
                'description' => __( 'Time between slide transitions <strong>in milliseconds</strong>. Enter 0 to stop automatic transitions. Default: 5000 = 5 seconds.', 'haven' ),
                'section'   => 'haven_featured_section',
                'settings'  => 'hvn_slider_timeout',
                'type'      => 'number'
            )
        )
    );

    // Slider pause on hover
    $wp_customize->add_setting( 'hvn_enable_slider_pause', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_enable_slider_pause',
            array(
                'label'       => __( 'Enable pause on hover', 'haven' ),
                'description' => __( 'Select to enable pausing the slider upon hovering.', 'haven' ),
                'section'   => 'haven_featured_section',
                'settings'  => 'hvn_enable_slider_pause',
                'type'      => 'checkbox'
            )
        )
    );


    //////////////////////////
    // Post Settings
    /////////////////////////

    $wp_customize->add_section( 'haven_post_settings', array(
        'title'    => __( 'Post Settings', 'haven' ),
        'priority' => 1,
        'panel' => 'haven_theme_options'
    ) );

    // Read more text
    $wp_customize->add_setting( 'hvn_read_more_text', array(
        'default'  => 'Continue reading',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_read_more_text',
            array(
                'label'     => __( '"Read More" text', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_read_more_text',
                'type'      => 'text'
            )
        )
    );

    // Hide category
    $wp_customize->add_setting( 'hvn_hide_category', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_category',
            array(
                'label'     => __( 'Hide category', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_category',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide comment number
    $wp_customize->add_setting( 'hvn_hide_comment_number', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_comment_number',
            array(
                'label'     => __( 'Hide comment number', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_comment_number',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide date
    $wp_customize->add_setting( 'hvn_hide_date', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_date',
            array(
                'label'     => __( 'Hide date', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_date',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide tags
    $wp_customize->add_setting( 'hvn_hide_tags', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_tags',
            array(
                'label'     => __( 'Hide tags', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_tags',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide share icons
    $wp_customize->add_setting( 'hvn_hide_share_icons', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_share_icons',
            array(
                'label'     => __( 'Hide share icons', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_share_icons',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide post navigation
    $wp_customize->add_setting( 'hvn_hide_post_nav', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_post_nav',
            array(
                'label'     => __( 'Hide previous/next post navigation', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_post_nav',
                'type'      => 'checkbox'
            )
        )
    );

    // Hide related posts
    $wp_customize->add_setting( 'hvn_hide_related_posts', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_hide_related_posts',
            array(
                'label'     => __( 'Hide related posts', 'haven' ),
                'section'   => 'haven_post_settings',
                'settings'  => 'hvn_hide_related_posts',
                'type'      => 'checkbox'
            )
        )
    );


    //////////////////////////
    // Footer Settings
    /////////////////////////

    $wp_customize->add_section( 'haven_footer_section', array(
        'title'    => __( 'Footer', 'haven' ),
        'priority' => 1,
        'panel' => 'haven_theme_options'
    ) );

    // Copyright text
    $wp_customize->add_setting( 'hvn_footer_text', array(
        'default' => __( '&copy; Copyright 2017 Haven. Theme by <a href="http://hellojusi.com">Jusi</a>.', 'haven' ),
        'sanitize_callback' => 'wp_kses'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_footer_text',
            array(
                'label'     => __( 'Copyright Info', 'haven' ),
                'section'   => 'haven_footer_section',
                'settings'  => 'hvn_footer_text',
                'type'      => 'textarea'
            )
        )
    );

    // Disable 'back to top'
    $wp_customize->add_setting( 'hvn_disable_back_top', array(
        'default' => 0,
        'sanitize_callback' => 'haven_sanitize_checkbox'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'hvn_disable_back_top',
            array(
                'label'     => __( 'Disable "back to top" link', 'haven' ),
                'section'   => 'haven_footer_section',
                'settings'  => 'hvn_disable_back_top',
                'type'      => 'checkbox'
            )
        )
    );


    //////////////////////////
    // Social Media
    /////////////////////////

    $wp_customize->add_section( 'haven_social_media', array(
        'title'    => __( 'Social Media', 'haven' ),
        'description'    => __( 'Add your social media links here. They\'re used in the top bar and Social Links widget. Leave empty to disable specific icons.', 'haven' ),
        'priority' => 1,
        'panel' => 'haven_theme_options'
    ) );

    // Facebook
    $wp_customize->add_setting( 'hvn_facebook', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_facebook', array(
                'label'    => __( 'Facebook', 'haven' ),
                'settings' => 'hvn_facebook',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Twitter
    $wp_customize->add_setting( 'hvn_twitter', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_twitter', array(
                'label'    => __( 'Twitter', 'haven' ),
                'settings' => 'hvn_twitter',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Instagram
    $wp_customize->add_setting( 'hvn_instagram', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_instagram', array(
                'label'    => __( 'Instagram', 'haven' ),
                'settings' => 'hvn_instagram',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Google+
    $wp_customize->add_setting( 'hvn_google', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_google', array(
                'label'    => __( 'Google+', 'haven' ),
                'settings' => 'hvn_google',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // YouTube
    $wp_customize->add_setting( 'hvn_youtube', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_youtube', array(
                'label'    => __( 'YouTube', 'haven' ),
                'settings' => 'hvn_youtube',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Pinterest
    $wp_customize->add_setting( 'hvn_pinterest', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_pinterest', array(
                'label'    => __( 'Pinterest', 'haven' ),
                'settings' => 'hvn_pinterest',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Bloglovin
    $wp_customize->add_setting( 'hvn_bloglovin', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_bloglovin', array(
                'label'    => __( 'Bloglovin', 'haven' ),
                'settings' => 'hvn_bloglovin',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // Tumblr
    $wp_customize->add_setting( 'hvn_tumblr', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_tumblr', array(
                'label'    => __( 'Tumblr', 'haven' ),
                'settings' => 'hvn_tumblr',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );

    // RSS
    $wp_customize->add_setting( 'hvn_rss', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize, 'hvn_rss', array(
                'label'    => __( 'RSS', 'haven' ),
                'settings' => 'hvn_rss',
                'section'  => 'haven_social_media',
                'type'     => 'text'
            )
        )
    );


}

add_action( 'customize_register', 'haven_customizer_register' );