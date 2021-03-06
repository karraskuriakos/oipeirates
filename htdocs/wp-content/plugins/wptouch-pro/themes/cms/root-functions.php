<?php

// CMS Defines
define( 'CMS_THEME_VERSION', '1.4.2' );
define( 'CMS_SETTING_DOMAIN', 'cms' );
define( 'CMS_DIR', wptouch_get_bloginfo( 'theme_root_directory' ) );
define( 'CMS_URL', wptouch_get_bloginfo( 'theme_root_url' ) );

// CMS Actions
add_action( 'foundation_init', 'cms_theme_init' );
add_action( 'foundation_modules_loaded', 'cms_register_fonts' );

// CMS Filters
add_filter( 'wptouch_registered_setting_domains', 'cms_setting_domain' );
add_filter( 'wptouch_setting_defaults_cms', 'cms_setting_defaults' );
add_filter( 'wptouch_setting_defaults_foundation', 'cms_foundation_setting_defaults' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'cms_render_theme_settings' );
add_filter( 'foundation_settings_blog', 'cms_blog_settings' );
add_filter( 'foundation_settings_pages', 'cms_page_settings' );

add_filter( 'foundation_featured_should_modify_query', 'cms_featured_check_query', 10, 2 );
add_filter( 'wptouch_setting_version_compare', 'cms_setting_version_compare', 10, 2 );

function cms_setting_version_compare( $version, $domain ) {
	if ( $domain == CMS_SETTING_DOMAIN ) {
		return CMS_THEME_VERSION;
	}

	return $version;
}

function cms_setting_defaults( $settings ) {
	// Pages
	$settings->show_titles = true;

	// Search
	$settings->show_search = true;

	// Custom theme colors
	$settings->cms_heading_color = '#990000';
	$settings->cms_link_color = '#990000';
	$settings->cms_background_color = '#f6f3e0';

	$settings->category_slider = true;
	$settings->second_menu_title = __( 'Alt Menu', 'wptouch-pro' );
	$settings->background_image = '';
	$settings->frontpage_message = '';
	$settings->show_featured_images_in_posts = false;

	return $settings;
}

function cms_foundation_setting_defaults( $settings ) {
	$settings->typography_sets = 'arvo_ptsans';
	return $settings;
}

function cms_featured_check_query( $should_be_ignored, $query ) {
	$should_be_ignored = $should_be_ignored || $query->is_archive;

	return $should_be_ignored;
}

// Add Foundation Module Support
function cms_theme_init() {
	foundation_add_theme_support(
		array(
			// Modules w/ settings
			'google-fonts',
			'custom-posts',
			'custom-latest-posts',
			'load-more',
			'sharing',
			'media',
			'social-links',
			'featured',
			// Modules w/o settings
			'wptouch-icons',
			'menu',
			'spinjs',
			'fastclick',
			'tappable',
			'concat'
		)
	);

	wptouch_register_theme_menu( array(
		'name' => 'main_menu',	// this is the name of the setting
		'friendly_name' => __( 'Main Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
		'settings_domain' => CMS_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
		'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
		'tooltip' => '',
		'can_be_disabled' => false
	));

	wptouch_register_theme_menu( array(
		'name' => 'alternate_menu',	// this is the name of the setting
		'friendly_name' => __( 'Alternate Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
		'settings_domain' => CMS_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
		'description' => __( 'Choose a menu', 'wptouch-pro' ),	// the description
		'tooltip' => '',
		'can_be_disabled' => true
	));

	// Theme Colours
	foundation_register_theme_color( 'cms_heading_color', __( 'Header background', 'wptouch-pro' ), '', 'body, #header, .generic-slider, #single-nav-bar, #main-menu, #alt-menu, .fixed-header-fill, #slider', CMS_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'header' );
	foundation_register_theme_color( 'cms_background_color', __( 'Theme background', 'wptouch-pro' ), '.entry-inner', '.page-wrapper, .wptouch-login-wrap', CMS_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING, 150, 'body' );
	foundation_register_theme_color( 'cms_link_color', __( 'Links', 'wptouch-pro' ), '#content a, .post-link-button i, #comments a, .nav-controls a, #switch a, .footer a, a.back-to-top', '#switch .active, .dots li.active', CMS_SETTING_DOMAIN, WPTOUCH_PRO_LIVE_PREVIEW_SETTING );
}

function cms_register_fonts() {
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
			'domine_opensans',
			foundation_create_google_font( 'heading', 'Domine', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Open Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);

		foundation_register_google_font_pairing(
			'bitter_sourcesans',
			foundation_create_google_font( 'heading', 'Bitter', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Source Sans Pro', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
	}
}

// Hook into Foundation blog section and add settings
function cms_blog_settings( $blog_settings ) {

	$blog_settings[] = wptouch_add_setting(
		'checkbox',
		'show_featured_images_in_posts',
		__( 'Show featured images on single posts', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.1.1',
		false,
		CMS_SETTING_DOMAIN,
		true
	);

	return $blog_settings;
}

// Hook into Foundation page section and add settings
function cms_page_settings( $page_settings ) {

	$page_settings[] = wptouch_add_setting(
		'checkbox',
		'show_titles',
		__( 'Show titles on pages', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0.6',
		false,
		CMS_SETTING_DOMAIN,
		true
	);

	return $page_settings;
}

function cms_render_theme_settings( $page_options ) {

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Category Slider', 'wptouch-pro' ),
		'category-slider',
		array(
		wptouch_add_setting(
				'checkbox',
				'category_slider',
				__( 'Enable category slider', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0.1'
			)
		),
		$page_options,
		CMS_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Search', 'wptouch-pro' ),
		'show-search',
		array(
		wptouch_add_setting(
				'checkbox',
				'show_search',
				__( 'Enable search', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'2.3.4'
			)
		),

		$page_options,
		CMS_SETTING_DOMAIN,
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
		CMS_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Second Menu', 'wptouch-pro' ),
		'secondary-menu',
		array(
		wptouch_add_setting(
				'text',
				'second_menu_title',
				__( 'Second	 menu button label (if used)', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		CMS_SETTING_DOMAIN,
		true
	);

	$settings = cms_get_settings();
	if ( $settings->frontpage_message != '' ) {
		wptouch_add_page_section(
			FOUNDATION_PAGE_CUSTOM,
			__( 'Front Page Alternate Content', 'wptouch-pro' ),
			'frontpage-message',
			array(
				wptouch_add_setting(
					'textarea',
					'frontpage_message',
					__( 'Front page alternate content', 'wptouch-pro' ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.0'
				)
			),
			$page_options,
			CMS_SETTING_DOMAIN,
			true
		);
	}

	return $page_options;
}

add_action( 'wptouch_customizer_start_setup', 'cms_port_images' );
function cms_port_images() {
	wptouch_customizer_port_image( 'wptouch_background_image', 'background_image', CMS_SETTING_DOMAIN );
}

function cms_setting_domain( $domains ) {
	$domains[] = CMS_SETTING_DOMAIN;
	return $domains;
}

function cms_get_settings() {
	return wptouch_get_settings( CMS_SETTING_DOMAIN );
}