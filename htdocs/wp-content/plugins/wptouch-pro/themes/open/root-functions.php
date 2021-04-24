<?php
define( 'OPEN_THEME_VERSION', '1.5.2' );
define( 'OPEN_SETTING_DOMAIN', 'open' );

define( 'OPEN_DIR', wptouch_get_bloginfo( 'theme_root_directory' ) );
define( 'OPEN_URL', wptouch_get_bloginfo( 'theme_root_url' ) );

// Open actions
add_action( 'init', 'open_init' );
add_action( 'foundation_init', 'open_theme_init' );
add_action( 'foundation_modules_loaded', 'open_register_fonts' );
add_action( 'customize_controls_enqueue_scripts', 'open_enqueue_customizer_script' );

// Open filters
add_filter( 'wptouch_registered_setting_domains', 'open_setting_domain' );
add_filter( 'wptouch_setting_defaults', 'open_setting_defaults' );
add_filter( 'foundation_settings_header', 'open_header_settings' );
add_filter( 'wptouch_setting_defaults_foundation', 'open_foundation_setting_defaults', 20 );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'open_theme_settings' );
add_filter( 'wptouch_admin_page_render_wptouch-admin-menus', 'open_menu_settings', 20 );
add_filter( 'wptouch_body_classes', 'open_body_classes' );

function open_setting_domain( $domain ) {
	$domain[] = OPEN_SETTING_DOMAIN;

	return $domain;
}

function open_get_settings() {
	return wptouch_get_settings( OPEN_SETTING_DOMAIN );
}

function open_setting_defaults( $settings ) {
	$settings->tagline = '';

	// Theme colors
	$settings->open_header_color = '#b8d04a';
	$settings->header_image = '';
	$settings->open_branding_color = '#4a2f13';
	$settings->open_background_color = '#f5f0f0';
	$settings->open_link_color = '#098aa1';

	$settings->logo_background_field = true;

	// CTA
	$settings->show_cta = true;
	$settings->cta_label = 'Call Us To Book';
	$settings->cta_action = 'tel:1-905-555-1234';

	// Location
	$settings->map_address = false;

	// Hours
	$settings->show_hours = true;
	$settings->hours_sunday = '';
	$settings->hours_monday = '';
	$settings->hours_tuesday = '';
	$settings->hours_wednesday = '';
	$settings->hours_thursday = '';
	$settings->hours_friday = '';
	$settings->hours_saturday = '';
	$settings->hours_note = '';

	$settings->open_show_menu_on_homepage = true;

	return $settings;
}

function open_foundation_setting_defaults( $settings ) {
	$settings->typography_sets = 'satisfy_lato';
	return $settings;
}

function open_init() {
	$open_settings = open_get_settings();
	if ( $open_settings->show_hours || $open_settings->map_address ) {
		add_rewrite_tag('%open_feature%', '([a-z]+)');
	}
}

function open_theme_init() {
	// WPtouch modules to load
	foundation_add_theme_support(
		array(
			// Modules w/ settings
			'custom-posts',
			'custom-latest-posts',
			'google-fonts',
			'media',
			'social-links',
			'menu',
			'wptouch-icons',
			'fastclick',
			'tappable',
			'spinjs',
			'concat'
		)
	);

	// Open Menu Location
	wptouch_register_theme_menu(
		array(
			'name' => 'primary_menu',	// this is the name of the setting
			'friendly_name' => __( 'Primary Menu', 'wptouch-pro' ),	// the friendly name, shows as a section heading
			'settings_domain' => OPEN_SETTING_DOMAIN,	// the setting domain (should be the same for the whole theme)
			'description' => __( 'Choose a menu', 'wptouch-pro' ),	 	// the description
			'tooltip' => __( 'Menus are awesome!', 'wptouch-pro' ), // Extra help info about this menu, perhaps?
			'can_be_disabled' => false
		)
	);

	// Open Colors
	foundation_register_theme_color(
		'open_branding_color',
		__( 'Main branding colour', 'wptouch-pro' ),
		'#header-area h1, .has-header-image #header-area h1.color, #menu-toggle',
		'.wptouch-login-wrap, #openclosed, #switch .active',
		OPEN_SETTING_DOMAIN,
		WPTOUCH_PRO_LIVE_PREVIEW_SETTING
	);

	foundation_register_theme_color(
		'open_header_color',
		__( 'Header background', 'wptouch-pro' ),
		'',
		'#header-area',
		OPEN_SETTING_DOMAIN,
		WPTOUCH_PRO_LIVE_PREVIEW_SETTING,
		250,
		'header'
	);

	foundation_register_theme_color(
		'open_background_color',
		__( 'Theme background', 'wptouch-pro' ),
		'',
		'.page-wrapper',
		OPEN_SETTING_DOMAIN,
		WPTOUCH_PRO_LIVE_PREVIEW_SETTING
	);

	foundation_register_theme_color(
		'open_link_color',
		__( 'Links', 'wptouch-pro' ),
		'a, #menu a, .menu-tree li span::before',
		'body, .dots li.active, .footer-action a',
		OPEN_SETTING_DOMAIN,
		WPTOUCH_PRO_LIVE_PREVIEW_SETTING,
		250,
		'links'
	);
}

// Open Customizer JS
function open_enqueue_customizer_script() {
	wp_enqueue_script(
		'open-customizer-js',
		OPEN_URL . '/open-customizer.js',
		array( 'jquery' ),
		OPEN_THEME_VERSION,
		false
	);
}

// Open Settings
function open_menu_settings( $page_options ) {
	wptouch_add_page_section(
		WPTOUCH_ADMIN_MENU_ICONS_OPTIONS,
		__( 'Open Homepage Menu', 'wptouch-pro' ),
		'open_show_menu_on_homepage',
		array(
			wptouch_add_setting(
				'checkbox',
				'open_show_menu_on_homepage',
				__( 'Show full menu on Open homepage', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		OPEN_SETTING_DOMAIN,
		true
	);

	return $page_options;
}

function open_header_settings( $open_header_settings ) {

	$open_header_settings[] = wptouch_add_setting(
		'checkbox',
		'logo_background_field',
		__( 'Display a white background behind the site logo.', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		OPEN_SETTING_DOMAIN
	);

	$open_header_settings[] = wptouch_add_setting(
		'image-upload',
		'header_image',
		__( 'Displayed behind header on pages.', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		OPEN_SETTING_DOMAIN
	);

	return $open_header_settings;
}

function open_theme_settings( $page_options ) {
	wptouch_add_page_section(
		FOUNDATION_PAGE_BRANDING,
		__( 'Tagline', 'wptouch-pro' ),
		'tagline',
		array(
			wptouch_add_setting(
				'text',
				'tagline',
				__( 'Displayed below your logo on the homepage.', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		OPEN_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Location', 'wptouch-pro' ),
		'location',
		array(
			wptouch_add_setting(
				'text',
				'map_address',
				__( 'Map address', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		OPEN_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Call to Action', 'wptouch-pro' ),
		'call_to_action',
		array(
			wptouch_add_setting(
				'checkbox',
				'show_cta',
				__( 'Use Call to Action button on pages', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'cta_label',
				__( 'Button Label', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'cta_action',
				__( 'Target URL (prefix phone numbers with tel:)', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		OPEN_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		FOUNDATION_PAGE_GENERAL,
		__( 'Hours', 'wptouch-pro' ),
		'hours',
		array(
			wptouch_add_setting(
				'checkbox',
				'show_hours',
				__( 'Use built-in Hours feature', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_sunday',
				__( 'Sunday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_monday',
				__( 'Monday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_tuesday',
				__( 'Tuesday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_wednesday',
				__( 'Wednesday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_thursday',
				__( 'Thursday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_friday',
				__( 'Friday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'text',
				'hours_saturday',
				__( 'Saturday', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'textarea',
				'hours_note',
				__( 'Note', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),
		$page_options,
		OPEN_SETTING_DOMAIN,
		true
	);

	return $page_options;
}

add_action( 'wptouch_customizer_start_setup', 'open_port_images' );
function open_port_images() {
	wptouch_customizer_port_image( 'wptouch_header_image', 'header_image', OPEN_SETTING_DOMAIN );
	wptouch_customizer_port_image( 'wptouch_background_image', 'background_image', OPEN_SETTING_DOMAIN );
}

function open_body_classes( $classes ) {
	global $wp_query;
	// Pages with the open_feature rewrite default to 'home' & 'blog' - override.
	if ( isset( $wp_query->query_vars[ 'open_feature' ] ) ) {
		$classes = array_flip( $classes );
		unset( $classes[ 'blog' ] );
		unset( $classes[ 'home' ] );
		$classes = array_flip( $classes );
		if ( isset( $wp_query->query_vars[ 'open_feature' ] ) ) {
			$classes[] = $wp_query->query_vars[ 'open_feature' ];
		}
		$classes[] = 'page';
	} elseif ( is_front_page() ) {
		$core_settings = wptouch_get_settings();
		if ( $core_settings->homepage_landing != 'none' ) {
			$classes = array_flip( $classes );
			unset( $classes[ 'home' ] );
			$classes = array_flip( $classes );
			if ( isset( $wp_query->query_vars[ 'open_feature' ] ) ) {
				$classes[] = $wp_query->query_vars[ 'open_feature' ];
			}
			$classes[] = 'page';
		}
	}

	$settings = open_get_settings();

	return $classes;
}

function open_register_fonts() {
	if ( foundation_is_theme_using_module( 'google-fonts' ) ) {
		foundation_register_google_font_pairing(
			'patua_alegreya',
			foundation_create_google_font( 'heading', 'Patua One', 'sans-serif', array( '400' ) ),
			foundation_create_google_font( 'body', 'Alegreya Sans', 'sans-serif', array( '300', '400', '700', '400italic', '700italic' ) )
		);
		foundation_register_google_font_pairing(
			'satisfy_lato',
			foundation_create_google_font( 'heading', 'Satisfy', 'sans-serif', array( '400' ) ),
			foundation_create_google_font( 'body', 'Lato', 'sans-serif', array( '300', '400', '700', '400italic', '700italic' ) )
		);
	}
}