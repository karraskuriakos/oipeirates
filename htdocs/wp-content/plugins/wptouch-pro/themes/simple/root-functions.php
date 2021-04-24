<?php

define( 'SIMPLE_THEME_VERSION', '1.5.2' );
define( 'SIMPLE_SETTING_DOMAIN', 'simple' );
define( 'SIMPLE_DIR', wptouch_get_bloginfo( 'theme_root_directory' ) );
define( 'SIMPLE_URL', wptouch_get_bloginfo( 'theme_root_url' ) );

// Simple Actions
add_action( 'foundation_init', 'simple_theme_init' );
add_action( 'foundation_modules_loaded', 'simple_register_fonts' );

// Simple Filters
add_filter( 'wptouch_registered_setting_domains', 'simple_setting_domain' );
add_filter( 'wptouch_setting_defaults', 'simple_setting_defaults' );
add_filter( 'wptouch_setting_defaults_foundation', 'simple_foundation_setting_defaults' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'simple_render_theme_settings' );
add_filter( 'wptouch_setting_version_compare', 'simple_setting_version_compare', 10, 2 );
add_filter( 'foundation_settings_blog', 'simple_blog_settings' );

function simple_setting_version_compare( $version, $domain ) {
	if ( $domain == SIMPLE_SETTING_DOMAIN ) {
		return SIMPLE_THEME_VERSION;
	}

	return $version;
}

// Load the modules Simple supports:
function simple_theme_init() {
	foundation_add_theme_support(
		array(
			// Modules w/ settings
			'google-fonts',
			'load-more',
			'media',
			'login',
			'social-links',
			'custom-posts',
			'custom-latest-posts',
			'featured',
			// Modules w/o settings
			'menu',
			'fastclick',
			'tappable',
			'spinjs',
			'wptouch-icons',
			'concat'
		)
	);

	wptouch_register_theme_menu(
		array(
			'name' => 'site_menu',	// this is the name of the setting
			'friendly_name' => __( 'Site Menu (Pulldown)', 'wptouch-pro' ),	// the friendly name, shows as a section heading
			'settings_domain' => SIMPLE_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
			'tooltip' => __( 'Pull-down menu at top of pages', 'wptouch-pro' ),
		)
	);

	wptouch_register_theme_menu(
		array(
			'name' => 'secondary_menu',	// this is the name of the setting
			'friendly_name' => __( 'Front Page Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
			'settings_domain' => SIMPLE_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
			'tooltip' => __( 'Displayed below front page menu and content', 'wptouch-pro' ),
			'can_be_disabled' => false
		)
	);

	// Theme Colors
	foundation_register_theme_color( 'simple_heading_color', __( 'Header background', 'wptouch-pro' ), '', '#menu, .toggle-button, .login-button, .menu-bumper, .homepage-menu a.touched, .homepage-menu li span.touched, body, .wptouch-login-wrap, .fixed-header-fill', SIMPLE_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'header' );
	foundation_register_theme_color( 'simple_background_color', __( 'Theme background', 'wptouch-pro' ), '', 'html, .page-wrapper', SIMPLE_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'body' );
	foundation_register_theme_color( 'simple_link_color', __( 'Links', 'wptouch-pro' ), 'a', '.dots li.active, #switch .active', SIMPLE_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING );

}

function simple_register_fonts() {
	if ( foundation_is_theme_using_module( 'google-fonts' ) ) {

		foundation_register_google_font_pairing(
			'lato_only',
			foundation_create_google_font( 'heading', 'Lato', 'serif', array( '300', '700' ) ),
			foundation_create_google_font( 'body', 'Lato', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

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
			'domine_opensans',
			foundation_create_google_font( 'heading', 'Domine', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Open Sans', 'sans-serif', array( '500', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'dosis_dsans',
			foundation_create_google_font( 'heading', 'Dosis', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Droid Sans', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'fugaz_dsans',
			foundation_create_google_font( 'heading', 'Leckerli One', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Roboto', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'fjalla_carrois',
			foundation_create_google_font( 'heading', 'Fjalla One', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Carrois Gothic', 'sans-serif', array( '400', '700', '500italic', '700italic' ) )
		);

	}
}

function simple_setting_defaults( $settings ) {

	// Homepage setting defaults
	$settings->homepage_message = '';

	// Map address
	$settings->map_address = '';

	// Phone Number
	$settings->phone_number = '';

	// Show Search
	$settings->blog_search = true;

	// 3D Menu
	$settings->threed_menu = true;

	// Branding
	$settings->simple_heading_color  = '#0095dc';
	$settings->simple_link_color = '#0095dc';
	$settings->simple_background_color = '#e5e3db';
	$settings->background_image = '';

	return $settings;
}

function simple_foundation_setting_defaults( $settings ) {
	$settings->typography_sets = 'dosis_dsans';
	return $settings;
}

// Hook into Foundation page section for Blog and add a setting
function simple_blog_settings( $blog_settings ) {

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'blog_search',
		__( 'Enable search on blog pages', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0.1',
		false,
		SIMPLE_SETTING_DOMAIN,
		true
	);

	return $blog_settings;
}

function simple_render_theme_settings( $page_options ) {
	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Special Menu Items', 'wptouch-pro' ),
		'homepage-phone',
		array(
			wptouch_add_setting(
				'text',
				'phone_number',
				__( 'Phone number', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'map_address',
				__( 'Address', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		SIMPLE_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_CUSTOM,
		__( 'Front Page Content', 'wptouch-pro' ),
		'homepage-message',
		array(
			wptouch_add_setting(
				'textarea',
				'homepage_message',
				__( 'Front page alternate content', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		SIMPLE_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Tiled Background Image', 'wptouch-pro' ),
		'background-image',
		array(
			wptouch_add_setting(
				'image-upload',
				'background_image',
				__( '(Scaled for retina displays)', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		SIMPLE_SETTING_DOMAIN,
		true
	);

	return $page_options;
}

add_action( 'wptouch_customizer_start_setup', 'simple_port_images' );
function simple_port_images() {
	wptouch_customizer_port_image( 'wptouch_background_image', 'background_image', SIMPLE_SETTING_DOMAIN );
}

function simple_setting_domain( $domains ) {
	$domains[] = SIMPLE_SETTING_DOMAIN;
	return $domains;
}

function simple_get_settings() {
	return wptouch_get_settings( SIMPLE_SETTING_DOMAIN );
}