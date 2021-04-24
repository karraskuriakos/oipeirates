<?php
define( 'CLASSIC_THEME_VERSION', '1.5.7' );
define( 'CLASSIC_SETTING_DOMAIN', 'classic-redux' );
define( 'CLASSIC_DIR', wptouch_get_bloginfo( 'theme_root_directory' ) );
define( 'CLASSIC_URL', wptouch_get_bloginfo( 'theme_root_url' ) );

add_action( 'foundation_init', 'classic_theme_init' );
add_action( 'foundation_modules_loaded', 'classic_register_fonts' );
add_action( 'customize_controls_enqueue_scripts', 'classic_enqueue_customizer_script' );

add_filter( 'wptouch_registered_setting_domains', 'classic_setting_domain' );
add_filter( 'wptouch_setting_defaults_classic_redux', 'classic_setting_defaults' );
add_filter( 'wptouch_setting_defaults_foundation', 'classic_foundation_setting_defaults' );
add_filter( 'wptouch_body_classes', 'classic_body_classes' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'classic_render_theme_settings' );
add_filter( 'wptouch_setting_version_compare', 'classic_setting_version_compare', 10, 2 );
add_filter( 'foundation_settings_blog', 'classic_blog_settings' );
add_filter( 'foundation_settings_pages', 'classic_page_settings' );

add_filter( 'wptouch_has_post_thumbnail', 'classic_handle_has_thumbnail' );
add_filter( 'wptouch_the_post_thumbnail', 'classic_handle_the_thumbnail' );

function classic_handle_has_thumbnail( $does_have_it ) {
	$settings = classic_get_settings();

	if ( $settings->thumbnail_type == 'custom_field' ) {
		if ( $settings->thumbnail_custom_field ) {
			global $post;

			$possible_image = get_post_meta( $post->ID, $settings->thumbnail_custom_field, true );
			return strlen( $possible_image );
 		}
	}

	return $does_have_it;
}

function classic_handle_the_thumbnail( $current_thumbnail ) {
	$settings = classic_get_settings();

	if ( $settings->thumbnail_type == 'custom_field' ) {
		global $post;

		$image = get_post_meta( $post->ID, $settings->thumbnail_custom_field, true );
		echo $image;
	}

	return $current_thumbnail;
}

function classic_setting_version_compare( $version, $domain ) {
	if ( $domain == CLASSIC_SETTING_DOMAIN ) {
		return CLASSIC_THEME_VERSION;
	}

	return $version;
}

function classic_theme_init() {
	// Load the modules Classic supports:
	foundation_add_theme_support(
		array(
			// Modules w/ settings
			'custom-posts',
			'custom-latest-posts',
			'google-fonts',
			'load-more',
			'sharing',
			'media',
			'social-links',
			'featured',
			'tablets',
			// Modules w/o settings
			'wptouch-icons',
			'menu',
			'spinjs',
			'fastclick',
			'tappable',
			'concat'
		)
	);

	// If enable in Classic settings, load up infinite scrolling
	classic_if_infinite_scroll_enabled();

	wptouch_register_theme_menu(
		array(
			'name' => 'primary_menu',									// This is the name of the setting
			'friendly_name' => __( 'Header Menu', 'wptouch-pro' ),		// The friendly name, shows as a section heading
			'settings_domain' => CLASSIC_SETTING_DOMAIN,				// The setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	 	// The description
			'tooltip' => '', 											// Extra help info about this menu, perhaps?
			'can_be_disabled' => false 									// Not used right now
		)
	);

	// Classic Colors
	foundation_register_theme_color( 'classic_header_color', __( 'Header background', 'wptouch-pro' ), '.arrow-down', '#header, ul.tab-menu, #menu, #slider, body', CLASSIC_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'header' );
	foundation_register_theme_color( 'classic_background_color', __( 'Theme background', 'wptouch-pro' ), '', '.page-wrapper, .wptouch-login-wrap', CLASSIC_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'body' );
	foundation_register_theme_color( 'classic_link_color', __( 'Links', 'wptouch-pro' ), '#content a, .footer a, a.back-to-top, .wptouch-mobile-switch a', '.dots li.active, .placeholder, #switch .active', CLASSIC_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING );

}

function classic_if_infinite_scroll_enabled(){
	$settings = classic_get_settings();

	if ( $settings->use_infinite_scroll ) {
		foundation_add_theme_support( 'infinite-scroll' );
	}
}

function classic_enqueue_customizer_script() {
	wp_enqueue_script(
		'classic-customizer-js',
		CLASSIC_URL . '/classic-customizer.js',
		array( 'jquery' ),
		CLASSIC_THEME_VERSION,
		false
	);
}

function classic_setting_defaults( $settings ) {

	$settings->use_thumbnails = 'index';
	$settings->tab_bar_cat_tags = 'categories_and_tags';
	$settings->show_tab_bar = true;
	$settings->tab_bar_max_cat_tags = 15;

	$settings->classic_header_color = '#333333';
	$settings->classic_background_color = '#eceef5';
	$settings->classic_link_color = '#0095dc';

	$settings->show_date = true;
	$settings->show_author = false;
	$settings->show_taxonomy = false;

	$settings->show_page_titles = true;

	$settings->menu_button_as_text = false;
	$settings->rounded_corners = false;
	$settings->use_infinite_scroll = false;

	$settings->thumbnail_type = 'featured';
	$settings->thumbnail_custom_field = '';

	$settings->landscape_menu = true;
	
	return $settings;
}

function classic_foundation_setting_defaults( $settings ) {
	$settings->typography_sets = 'lato_sourcesans';
	return $settings;
}

function classic_register_fonts() {
	if ( foundation_is_theme_using_module( 'google-fonts' ) ) {

		foundation_register_google_font_pairing(
			'arvo_ptsans',
			foundation_create_google_font( 'heading', 'Arvo', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'PT Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'inika_raleway',
			foundation_create_google_font( 'heading', 'Inika', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Raleway', 'sans-serif', array( '500', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'dosis_dsans',
			foundation_create_google_font( 'heading', 'Dosis', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Droid Sans', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'bitter_sourcesans',
			foundation_create_google_font( 'heading', 'Bitter', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'lato_sourcesans',
			foundation_create_google_font( 'heading', 'Lato', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

	}
}

function classic_body_classes( $classes ) {
	$settings = classic_get_settings();

	if ( $settings->rounded_corners ) {
		$classes[] = 'rounded-corners';
	}

	if ( $settings->landscape_menu == true ) {
		$classes[] = 'landscape-menu';
	}

	return $classes;
}

// Hook into Foundation page section for Blog and add a setting
function classic_blog_settings( $blog_settings ) {

	$blog_settings[] = wptouch_add_setting(
		'list',
		'use_thumbnails',
		__( 'Post thumbnails', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0.2',
		array(
			'none' => __( 'No thumbnails', 'wptouch-pro' ),
			'index' => __( 'Blog listing only', 'wptouch-pro' ),
			'index_single' => __( 'Blog listing, single posts', 'wptouch-pro' ),
			'all' => __( 'All (blog, single, search and archive)', 'wptouch-pro' )
		),
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'radiolist',
		'thumbnail_type',
		__( 'Thumbnail Selection', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_ADVANCED,
		'1.0.4',
		array(
			'featured' => __( 'Post featured image', 'wptouch-pro' ),
			'custom_field' => __( 'Post custom field', 'wptouch-pro' )
		),
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'text',
		'thumbnail_custom_field',
		__( 'Thumbnail custom field name', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_ADVANCED,
		'1.0.4',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'show_date',
		__( 'Show post date', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0.2',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'show_author',
		__( 'Show post author', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'show_taxonomy',
		__( 'Show post categories and tags', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'use_infinite_scroll',
		__( 'Use infinite scrolling for blog', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'rounded_corners',
		__( 'Use rounded corners', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		CLASSIC_SETTING_DOMAIN
	);


	return $blog_settings;
}

// Hook into Foundation page section and add a setting
function classic_page_settings( $page_settings ) {

	$page_settings[] = wptouch_add_setting(
		'checkbox',
		'show_page_titles',
		__( 'Show page title areas on pages', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0.3',
		false,
		CLASSIC_SETTING_DOMAIN
	);

	return $page_settings;
}

function classic_render_theme_settings( $page_options ) {
	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Header Menu Area', 'wptouch-pro' ),
		'menu-tab-bar-theme-settings',
		array(
			wptouch_add_setting(
				'checkbox',
				'menu_button_as_text',
				__( 'Drop-down button says "Menu"', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0.2'
			),
			wptouch_add_setting(
				'checkbox',
				'show_tab_bar',
				__( 'Show tab bar', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'list',
				'tab_bar_cat_tags',
				__( 'Tab-bar shows categories or tags', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0',
				array(
					'categories_and_tags' => __( 'Categories and tags', 'wptouch-pro' ),
					'categories' => __( 'Categories only', 'wptouch-pro' ),
					'tags' => __( 'Tags only', 'wptouch-pro' ),
					'none' => __( 'No categories or tags', 'wptouch-pro' )
				)
			),
			wptouch_add_setting(
				'range',
				'tab_bar_max_cat_tags',
				__( 'Max categories / tags', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0',
				array(
				'min' => 5,
				'max' => 50,
				'step' => 5
				)
			)
		),
		$page_options,
		CLASSIC_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Tablets', 'wptouch-pro' ),
		'tablet-theme-settings',
		array(
			wptouch_add_setting(
				'checkbox',
				'landscape_menu',
				__( 'Show menu on left side in landscape orientation', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.5.6'
			)
		),
		$page_options,
		CLASSIC_SETTING_DOMAIN,
		true
	);

	return $page_options;

}

function classic_setting_domain( $domain ) {
	$domain[] = CLASSIC_SETTING_DOMAIN;

	return $domain;
}

function classic_get_settings() {
	return wptouch_get_settings( CLASSIC_SETTING_DOMAIN );
}