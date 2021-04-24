<?php

define( 'MOBILESTORE_THEME_VERSION', '1.3.3' );
define( 'MOBILESTORE_SETTING_DOMAIN', 'mobilestore' );

define( 'MOBILESTORE_PAGE_STORE', __( 'Store', 'wptouch-pro' ) );
define( 'MOBILESTORE_PAGE_TABLETS', __( 'Tablets', 'wptouch-pro' ) );

define( 'MOBILESTORE_DIR', wptouch_get_bloginfo( 'theme_root_directory' ) );
define( 'MOBILESTORE_URL', wptouch_get_bloginfo( 'theme_root_url' ) );

// mobilestore actions
add_action( 'admin_init', 'mobilestore_woo_check' );
add_action( 'foundation_init', 'mobilestore_theme_init' );
add_action( 'foundation_modules_loaded', 'mobilestore_register_fonts' );
add_action( 'admin_enqueue_scripts', 'mobilestore_enqueue_admin_scripts' );
add_action( 'wp_enqueue_scripts', 'mobilestore_inline_styles' );

// mobilestore filters
add_filter( 'wptouch_body_classes', 'mobilestore_body_classes' );
add_filter( 'wptouch_registered_setting_domains', 'mobilestore_setting_domain' );
add_filter( 'foundation_settings_logo', 'mobilestore_logo_settings' );

add_filter( 'wptouch_setting_defaults', 'mobilestore_setting_defaults' );
add_filter( 'wptouch_setting_defaults_foundation', 'mobilestore_foundation_setting_defaults' );
add_filter( 'wptouch_setting_version_compare', 'mobilestore_setting_version_compare', 10, 2 );
add_filter( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'mobilestore_theme_settings', 9 );
add_action( 'wptouch_update_settings_domain_mobilestore', 'wptouch_save_empty_filter_attributes' );

add_filter( 'wptouch_post_footer', 'mobilestore_footer_version' );

add_filter( 'woocommerce_available_payment_gateways', 'mobilestore_restrict_gateways' );

add_filter( 'wptouch_force_mobile_ajax', 'mobilestore_force_mobile_ajax' );

add_filter( 'wptouch_addon_cache_current_page', 'mobilestore_cache_rules', 10 );

add_filter( 'wptouch_allow_wam', 'mobilestore_allow_wam' );
add_filter( 'wptouch_allow_wam_message', 'mobilestore_allow_wam_message' );

add_filter( 'wptouch_customizer_override_wptouch_mobilestore_product_filters', 'wptouch_sanitize_string_to_array' );

// Let's check that WooCommerce is even active!
function mobilestore_woo_check(){
	if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {

	    function mobilestore_woo_msg() {
	        echo '<div class="error"><p>';
	        echo 'WPtouch: ' . sprintf( __( '%s %s is not installed and activated.%s %s requires it to work properly.' , 'wptouch-pro' ), '<strong>', 'WooCommerce', '</strong>', 'MobileStore' );
	        echo '</p></div>';
		}
		add_action( 'admin_notices', 'mobilestore_woo_msg' );
	}
}

function mobilestore_cache_rules( $cache_current_page ) {
	global $woocommerce;

	if ( is_object( $woocommerce ) ) {

		$cart_url = mobilestore_strip_protocol( $woocommerce->cart->get_cart_url() );
		$checkout_url = mobilestore_strip_protocol( $woocommerce->cart->get_checkout_url() );
		$requested_url = substr( $_SERVER[ 'REQUEST_URI' ], 0, strpos( $_SERVER[ 'REQUEST_URI' ], '?' ) );
		$current_url = strtolower( $_SERVER[ 'HTTP_HOST' ] . $requested_url );
		if ( $current_url == $cart_url || $current_url == $checkout_url ) {
			$cache_current_page = false;
		}
	}

	return $cache_current_page;
}

function mobilestore_strip_protocol( $url ) {
	return substr( $url, strpos( $url, '//' ) + 2 );
}

function mobilestore_force_mobile_ajax( $force_mobile ) {
	if ( defined( 'DOING_AJAX' ) && $_REQUEST['action'] == 'woocommerce_update_order_review' ) {
		$force_mobile = true;
	}

	return $force_mobile;
}

function mobilestore_allow_wam( $allow_wam ) {
	global $wptouch_pro;

	$current_theme = $wptouch_pro->get_current_theme_info();

	if ( strstr( $current_theme->base, 'mobilestore' ) ) {
		global $woocommerce;
		if ( isset( $woocommerce->payment_gateways->payment_gateways ) ) {
			$gateways = $woocommerce->payment_gateways->payment_gateways;
			$safe_gateways = array();
			$known_safe_gateways = mobilestore_get_known_gateways();
			foreach ( $gateways as $gateway ) {
				if ( $gateway->enabled == 'yes' && in_array( $gateway->id, $known_safe_gateways ) ) {
					$safe_gateways[] = $gateway->id;
				}
			}
		} else {
			return true;
		}

		if ( count( $safe_gateways ) == 0 ) {
			$allow_wam = false;
		}
	}

	return $allow_wam;
}

function mobilestore_allow_wam_message( $message ) {
	return sprintf( __( 'Web-App Mode is not available because your site does not use a supported payment gateway.%sSee %s for further information.', 'wptouch-pro' ), '<br><br>' , '<a href="https://wptouch.freshdesk.com/solution/articles/5000548268-mobilestore-and-web-app-mode" target="_new">MobileStore and Web App Mode</a>' );
}

function mobilestore_get_known_gateways() {
	return array(
		'bacs',
		'cheque',
		'cod',
		'bankgiro-postgiro',
		'ppay', //
		'stripe', //WooCommerce Stripe Gateway
		's4wc' //Stripe for WooCommerce
	);
}

function mobilestore_restrict_gateways( $gateways ) {
	/****************************************************************************************

		These are gateways known to provide a positive user experience in Web App Mode.
		Gateways not found in this list will be disabled when your site is viewed in
		Web App Mode.

		To request evaluation of your preferred gateway plugin, please open a WPtouch Pro
		support ticket, attaching a copy of the plugin and the necessary test credentials.

	****************************************************************************************/

	$known_safe_gateways = mobilestore_get_known_gateways();

	if ( function_exists( 'foundation_webapp_mode_active' ) && foundation_webapp_mode_active() ) {
		foreach ( $gateways as $gateway_key => $gateway ) {
			if ( !in_array( $gateway_key, $known_safe_gateways ) ) {
				unset( $gateways[ $gateway_key ] );
			}
		}
	}
	return $gateways;
}

function mobilestore_setting_domain( $domain ) {
	$domain[] = MOBILESTORE_SETTING_DOMAIN;

	return $domain;
}

function mobilestore_get_settings() {
	return wptouch_get_settings( MOBILESTORE_SETTING_DOMAIN );
}

function mobilestore_setting_version_compare( $version, $domain ) {
	if ( $domain == MOBILESTORE_SETTING_DOMAIN ) {
		return MOBILESTORE_THEME_VERSION;
	}

	return $version;
}

function mobilestore_footer_version(){
	echo '<!--MobileStore v' . MOBILESTORE_THEME_VERSION . '-->';
}

function mobilestore_setting_defaults( $settings ) {
	// Theme colors
	$settings->mobilestore_cart_background_color = '#455C7B';
	$settings->mobilestore_header_background_color = '#685C79';
	$settings->mobilestore_body_bg_color = '#EFEFEF';
	$settings->mobilestore_link_color = '#DA727E';
	$settings->mobilestore_primary_action_color = '#AC6C82';
	$settings->mobilestore_highlight_color = '#FFBC67';

	// Header Settings
	$settings->mobilestore_header_type = 'small';
	$settings->mobilestore_show_h4 = true;

	// Store
	$settings->mobilestore_product_filters = array();
	$settings->mobilestore_products_per_page = get_option( 'posts_per_page' );
	$settings->mobilestore_show_categories = true;
	$settings->mobilestore_show_top_products_carousel = true;
//	$settings->mobilestore_featured_categories_smartphone = '';
	$settings->mobilestore_show_recently_viewed = true;
	$settings->mobilestore_product_pagination = 'ajax';
	$settings->mobilestore_initial_product_view = 'grid';
	$settings->mobilestore_allow_product_zoom = true;

	// Cart Options
	$settings->mobilestore_show_minicart = true;
	$settings->mobilestore_use_ajax_add_to_cart = true;

	// Tablets
	$settings->mobilestore_tablet_support = false;
	$settings->mobilestore_featured_categories_tablet = array();

	return $settings;
}

function mobilestore_foundation_setting_defaults( $settings ) {
	$settings->typography_sets = 'oswald_lato';
	return $settings;
}

function mobilestore_enqueue_admin_scripts() {
	wp_enqueue_script(
		'mobilestore-admin-js',
		MOBILESTORE_URL . '/mobilestore-admin.js',
		array( 'jquery', 'wptouch-pro-admin' ),
		MOBILESTORE_THEME_VERSION,
		false
	);
}

function mobilestore_theme_init() {

	// Foundation modules this theme should load
	foundation_add_theme_support(
		array(
			// Modules w/ settings
			'wptouch-icons',
			'google-fonts',
			'load-more',
			'custom-posts',
			'custom-latest-posts',
			'menu',
			'social-links',
			'pushit',
			'spinjs',
			'concat'
		)
	);

	if ( mobilestore_if_tablets_supported() ) {
		foundation_add_theme_support( 'tablets' );
	}

	if ( function_exists( 'is_checkout' ) ) {
		if ( !is_page( wc_get_page_id( 'checkout' ) ) || is_page( wc_get_page_id( 'cart' ) ) ) {
			foundation_add_theme_support(
				array (
					'hammer',
					'tappable',
					'owlcarousel'
				)
			);
		}
	}

	// Register primary theme menu
	wptouch_register_theme_menu(
		array(
			'name' => 'primary_menu',
			'friendly_name' => __( 'Primary Menu', 'wptouch-pro' ),
			'settings_domain' => MOBILESTORE_SETTING_DOMAIN,
			'description' => __( 'Choose a menu', 'wptouch-pro' ),
			'tooltip' => __( 'Off-Canvas left menu', 'wptouch-pro' ),
			'can_be_disabled' => false
		)
	);

	// Register footer theme menu
	wptouch_register_theme_menu(
		array(
			'name' => 'footer_menu',
			'friendly_name' => __( 'Footer Menu', 'wptouch-pro' ),
			'settings_domain' => MOBILESTORE_SETTING_DOMAIN,
			'description' => __( 'Choose a menu', 'wptouch-pro' ),
			'tooltip' => __( 'Menu shown in the MobileStore footer', 'wptouch-pro' ),
			'can_be_disabled' => false
		)
	);

	// Register theme colors (name,title,color,background-color,settings_domain)
	// Cart and menu background
	foundation_register_theme_color( 'mobilestore_cart_background_color', __( 'Menu & Cart Background', 'wptouch-pro' ), '', '.pushit', MOBILESTORE_SETTING_DOMAIN );

	// Header and footer background
	foundation_register_theme_color( 'mobilestore_header_background_color', __(
		'Header & Footer Background', 'wptouch-pro' ),
		// color (none)
		'',
		// background-color
		'body,
		#header-area,
		#wptouch-search-inner,
		.footer,
		.footer-menu,
		.recent-searches,
		.post .post-head,
		.fixed-header-fill,
		.filtering h2',
		MOBILESTORE_SETTING_DOMAIN
	);

	// Header and footer background
	foundation_register_theme_color( 'mobilestore_body_bg_color', __(
		'Body Background', 'wptouch-pro' ),
		'',
		'.page-wrapper',
		MOBILESTORE_SETTING_DOMAIN
	);

	// Links (sitewide)
	foundation_register_theme_color(
		'mobilestore_link_color',
		__( 'Links', 'wptouch-pro' ),
		// color
		'a,
		button.button.touched,
		#menu-left li a,
		.cart_list li.empty,
		.woocommerce-cart .cart-empty,
		.light-header .recent-searches,
		.light-header .recent-searches a,
		.products li span.price,
		#content .woocommerce-tabs .active a,
		.comment-form-rating .stars a.active:before,
		.comment-form-rating .stars a.fill:before,
		.star-rating i',
		// background-color
		'.active,
		#search-submit,
		button#submit,
		a#blog-back,
		ul.products li.touched,
		li.touched .onsale,
		.active-filters li a,
		#content .product .quantity .button.touched,
		.owl-carousel .owl-dot.active span',
		MOBILESTORE_SETTING_DOMAIN
	);

	//Primary CTA color
	foundation_register_theme_color( 'mobilestore_primary_action_color', __( 'Primary Actions & Purchase Flow', 'wptouch-pro' ), false, false, MOBILESTORE_SETTING_DOMAIN );

	// Secondary color
	foundation_register_theme_color(
		'mobilestore_highlight_color',
		__( 'Highlight Color', 'wptouch-pro' ),
		// color
		'.woocommerce-checkout #content .payment_methods li.active > label, .no-results i, .cart-btn.filled i:after',
		// background-color
		'.onsale, .woocommerce-checkout .payment_methods .active:before, .product-top .amount, .thankyou-message:before',
		MOBILESTORE_SETTING_DOMAIN
	);

} // theme init

// Add custom border styles from the link colour to UI elements
function mobilestore_inline_styles(){
	$settings = mobilestore_get_settings();
	$link_color = $settings->mobilestore_link_color;

	$primary_link_color = $settings->mobilestore_primary_action_color;
    $custom_css = "
    	.pushit .button, .pushit button {
    		color: $link_color;
    		border-color: $link_color;
    	}
    	.pushit .button.touched, .pushit button.touched, .woocommerce-message {
    		color: #fff;
			background-color: $link_color;
		}
    	.dark-cart .pushit .button, .dark-cart .pushit button {
    		color: rgba(255,255,255,.5);
    		border-color: rgba(255,255,255,.5)
    	}
    	.dark-cart .pushit .button.touched, .dark-cart .pushit button.touched {
    		color: rgba(255,255,255,.5);
    		border-color: $link_color;
    		background-color: $link_color;
    	}
    	#content .button, #content a.button {
    		color: $link_color;
    		border-color: $link_color;
    	}
    	#content .button.touched, #content a.button.touched {
    		color: #fff;
    		background-color: $link_color;
    		border-color: $link_color;
    	}
		#content .orderby, .woocommerce-ordering:after {
			color: $link_color;
			border-color: $link_color;
		}
		button.checkout, .woocommerce button.single_add_to_cart_button, #place_order, input#submit, .woocommerce #respond input#submit, .woocommerce button#submit {
			color: #FFF !important;
			border-color: $primary_link_color !important;
			background-color: $primary_link_color !important;
		}

		.button.checkout.touched, button.checkout_button.touched, button.checkout.touched, .single_add_to_cart_button.touched, #place_order.touched, .woocommerce-account .shop_table input {
			color: #fff !important;
			background-color: $primary_link_color !important;
			border-color: $primary_link_color;
		}
		#content .thumbnails li.active, #content .thumbnails li.active:after {
			border-color: $primary_link_color;
		}
		#content .product .quantity, .woocommerce-cart #content .cart li input, #commentform input:focus, #commentform textarea:focus, .woocommerce-page input[type='text']:focus, .woocommerce-page input[type='url']:focus, .woocommerce-page input[type='email']:focus,.woocommerce-page input[type='password']:focus, .woocommerce-page input[type='tel']:focus, .woocommerce-page select:focus, .woocommerce-page textarea:focus {
			border-color: $primary_link_color !important;
		}
    "; // End Custom CSS
    wp_add_inline_style( 'wptouch-theme-css', $custom_css );
}

// Register Google font pairings
function mobilestore_register_fonts() {
	if ( foundation_is_theme_using_module( 'google-fonts' ) ) {
		foundation_register_google_font_pairing(
			'vollkorn_lato',
			foundation_create_google_font( 'heading', 'Vollkorn', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Lato', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
		foundation_register_google_font_pairing(
			'oswald_lato',
			foundation_create_google_font( 'heading', 'Oswald', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Lato', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
		foundation_register_google_font_pairing(
			'arvo_ptsans',
			foundation_create_google_font( 'heading', 'Arvo', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'PT Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
		foundation_register_google_font_pairing(
			'robotocond_notosans',
			foundation_create_google_font( 'heading', 'Roboto Condensed', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Noto Sans', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
		foundation_register_google_font_pairing(
			'raleway_roboto',
			foundation_create_google_font( 'heading', 'Raleway', 'serif', array( '400', '700' ) ),
			foundation_create_google_font( 'body', 'Roboto', 'sans-serif', array( '400', '700', '400italic', '700italic' ) )
		);
	}
}

function mobilestore_theme_settings( $page_options ) {
	$woocommerce_attributes = array();
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) ) {
						$woocommerce_attributes[ $tax->attribute_name ] = $tax->attribute_label;
				}
			}
		}
	}

	wptouch_add_sub_page( MOBILESTORE_PAGE_STORE, 'mobilestore-page-store', $page_options );

	wptouch_add_page_section(
		MOBILESTORE_PAGE_STORE,
		__( 'Product Listing', 'wptouch-pro' ),
		'product_listing_section',
		array(
			wptouch_add_setting(
				'checkbox',
				'mobilestore_show_top_products_carousel',
				__( 'Show top-selling products carousel above product listings', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.1'
			),
			wptouch_add_setting(
				'numeric',
				'mobilestore_products_per_page',
				__( 'Number of products shown per page in product listings', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'radiolist',
				'mobilestore_initial_product_view',
				__( 'First Product Listing View', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.2',
				array(
					'grid' => __( 'Grid view', 'wptouch-pro' ),
					'list' => __( 'List view', 'wptouch-pro' ),
				)
			)
		),
		$page_options,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		MOBILESTORE_PAGE_STORE,
		__( 'Pagination', 'wptouch-pro' ),
		'pagination_section',
			array(
				wptouch_add_setting(
					'radiolist',
					'mobilestore_product_pagination',
					__( 'Product Pagination Type', 'wptouch-pro' ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.1',
					array(
						'ajax' => __( 'Use AJAX load more', 'wptouch-pro' ),
						'numbered' => __( 'Use numbered pages', 'wptouch-pro' ),
					)
				)
			),
		$page_options,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);

	if ( count( $woocommerce_attributes ) > 0 ) {

		wptouch_add_page_section(
			MOBILESTORE_PAGE_STORE,
			__( 'Product Filters', 'wptouch-pro' ),
			'product_filters_section',
			array(
				wptouch_add_setting(
					'checklist',
					'mobilestore_product_filters',
					__( 'Include WooCommerce product filters for', 'wptouch-pro' ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.0',
					$woocommerce_attributes
				),
			),
			$page_options,
			MOBILESTORE_SETTING_DOMAIN,
			true
		);

	}

	wptouch_add_page_section(
		MOBILESTORE_PAGE_STORE,
		__( 'Single Product Pages', 'wptouch-pro' ),
		'single_product_section',
		array(
			wptouch_add_setting(
				'checkbox',
				'mobilestore_allow_product_zoom',
				__( 'Allow zooming on product images', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.2'
			)
		),

		$page_options,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);


	wptouch_add_page_section(
		MOBILESTORE_PAGE_STORE,
		__( 'Side Menu Options', 'wptouch-pro' ),
		'sidebar_section',
		array(
			wptouch_add_setting(
				'checkbox',
				'mobilestore_show_categories',
				__( 'Show category menu', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			),
			wptouch_add_setting(
				'checkbox',
				'mobilestore_show_recently_viewed',
				__( 'Show recently viewed products', 'wptouch-pro' ),
				false,
				WPTOUCH_SETTING_BASIC,
				'1.0'
			)
		),

		$page_options,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);

	wptouch_add_page_section(
		MOBILESTORE_PAGE_STORE,
		__( 'Cart Options', 'wptouch-pro' ),
		'cart_section',
		array(
			wptouch_add_setting(
				'checkbox',
				'mobilestore_show_minicart',
				__( 'Enable off-canvas mini-cart', 'wptouch-pro' ),
				false,
//				__( 'If disabled, the cart icon will take visitors to the Cart page instead of opening the mini-cart.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.2'
			),
			wptouch_add_setting(
				'checkbox',
				'mobilestore_use_ajax_add_to_cart',
				__( 'Enable AJAX add to cart', 'wptouch-pro' ),
				false,
//				__( 'If you are experiencing issues with adding items to the cart, disable this feature.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'1.2'
			)
		),

		$page_options,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);

	$woocommerce_categories = array();
	$woocommerce_cats = get_terms( 'product_cat', array( 'hide_empty' => true ) );
	if ( count( $woocommerce_cats ) > 0 ) {
		foreach ( $woocommerce_cats as $category ) {
			$woocommerce_categories[ $category->slug ] = $category->name;
		}
	}
/*
	wptouch_add_sub_page( MOBILESTORE_PAGE_TABLETS, 'mobilestore-page-tablets', $page_options );

	wptouch_add_page_section(
		MOBILESTORE_PAGE_TABLETS,
		__( 'Tablets', 'wptouch-pro' ),
		'tablet-settings',
		array(
			wptouch_add_setting(
			'checkbox',
			'mobilestore_tablet_support',
			__( 'Enable tablet support', 'wptouch-pro' ),
			false,
			WPTOUCH_SETTING_BASIC,
			'1.0'
			)
		),
		$page_options,
		MOBILESTORE_SETTING_DOMAIN
	);


	if ( mobilestore_if_tablets_supported() ) {
			wptouch_add_page_section(
			MOBILESTORE_PAGE_TABLETS,
			__( 'Featured Categories (Tablet)', 'wptouch-pro' ),
			'featured_categories_section_tablet',
			array(
				wptouch_add_setting(
					'checklist',
					'mobilestore_featured_categories_tablet',
					__( 'List best-selling products from these categories on the homepage', 'wptouch-pro' ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.0',
					$woocommerce_categories
				),
			),
			$page_options,
			MOBILESTORE_SETTING_DOMAIN
		);

		wptouch_add_page_section(
			MOBILESTORE_PAGE_STORE,
			__( 'Featured Categories (Mobile)', 'wptouch-pro' ),
			'featured_categories_section_mobile',
			array(
				wptouch_add_setting(
					'list',
					'mobilestore_featured_categories_smartphone',
					__( 'List best-selling products from this category on the homepage', 'wptouch-pro' ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.0',
					$woocommerce_categories
				),
			),
			$page_options,
			MOBILESTORE_SETTING_DOMAIN
		);

	}
*/
	return $page_options;
}

// Custom MobileStore theme classes
function mobilestore_body_classes( $classes ) {
	$classes[ 'locale' ] = 'locale-lang-' . substr( strtolower( get_locale() ), 0, strpos( get_locale(), '_' ) );

	global $woocommerce;
	if ( is_object( $woocommerce ) ) {
		$version = explode( '.', $woocommerce->version );
		$classes[ 'woocommerce' ] = 'wc-' . $version[ 0 ] . '.' . $version[ 1 ];
	}

	$settings = mobilestore_get_settings();

	$heading_luma = wptouch_hex_to_luma( $settings->mobilestore_header_background_color );

	if ( $heading_luma <= 147 ) {
		$classes[] = 'dark-header';
	} else {
		$classes[] = 'light-header';
	}

	$cart_luma = wptouch_hex_to_luma( $settings->mobilestore_cart_background_color );

	if ( $cart_luma <= 147 ) {
		$classes[] = 'dark-cart';
	} else {
		$classes[] = 'light-cart';
	}

	$link_luma = wptouch_hex_to_luma( $settings->mobilestore_link_color );

	if ( $link_luma <= 140 ) {
		$classes[] = 'dark-link';
	} else {
		$classes[] = 'light-link';
	}

	if ( $heading_luma <= 147 && $link_luma <= 140 ) {
		$classes[] = 'dark-header-w-dark-link';
	}

	if ( $settings->mobilestore_header_background_color == $settings->mobilestore_link_color ) {
		$classes[] = 'dark-header';
	}

	if ( $settings->mobilestore_cart_background_color ==  $settings->mobilestore_link_color ) {
		$classes[] = 'dark-cart';
	}

	if ( $settings->mobilestore_cart_background_color == $settings->mobilestore_primary_action_color ) {
		$classes[] = 'primary-cart-conflict';
	}

	if ( $settings->mobilestore_product_pagination == 'ajax' ) {
		$classes[] = 'ajax-pagination';
	} else {
		$classes[] = 'classic-pagination';
	}

	$primary_luma = wptouch_hex_to_luma( $settings->mobilestore_primary_action_color );
	if ( $primary_luma >= 200 ) {
		$classes[] = 'light-primary-action';
	}

	// Short or Tall Header
	$header_type = $settings->mobilestore_header_type;
	$classes[] = $header_type . '-header';

	if ( $settings->mobilestore_use_ajax_add_to_cart == true ) {
		$classes[] = 'ajax-add-to-cart';
	}

	if ( $settings->mobilestore_initial_product_view == 'grid' ) {
		$classes[] = 'grid-view';
	} else {
		$classes[] = 'list-view';
	}

	if ( $settings->mobilestore_allow_product_zoom == true ) {
		$classes[] = 'can-zoom-images';
	}

	return $classes;
}

// Hook into Foundation logo section and add a setting
function mobilestore_logo_settings( $logo_settings ) {

	$logo_settings[] = wptouch_add_setting(
		'radiolist',
		'mobilestore_header_type',
		__( 'Site logo display size', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		array(
			'small' => __( 'Short (default)', 'wptouch-pro' ),
			'large' => __( 'Tall (longer vertically for square logos)', 'wptouch-pro' )
		),
		MOBILESTORE_SETTING_DOMAIN,
		true
	);
	$logo_settings[] = wptouch_add_setting(
		'checkbox',
		'mobilestore_show_h4',
		__( 'Show site description in large header', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'1.0',
		false,
		MOBILESTORE_SETTING_DOMAIN,
		true
	);

	return $logo_settings;
}

function mobilestore_header_type_large(){
	$settings = mobilestore_get_settings();

	if ( $settings->mobilestore_header_type == 'large' && $settings->mobilestore_show_h4 ) {
		return true;
	} else {
		return false;
	}
}

function wptouch_save_empty_filter_attributes() {
	global $wptouch_pro;

	$settings = mobilestore_get_settings();
	$attributes_to_save = array();

	if ( $settings->mobilestore_product_filters && isset( $_POST[ 'checklist-mobilestore_product_filters' ] ) ) {
		if ( !isset( $_POST[ 'wptouch__mobilestore__mobilestore_product_filters' ] ) ) {
			$settings->mobilestore_product_filters = array();
			$wptouch_pro->settings_objects[ MOBILESTORE_SETTING_DOMAIN ] = $settings;
			$settings->save();
		}
	}

	if ( $settings->mobilestore_featured_categories_tablet && isset( $_POST[ 'checklist-mobilestore_featured_categories_tablet' ] ) ) {
		if ( !isset( $_POST[ 'wptouch__mobilestore__mobilestore_featured_categories_tablet' ] ) ) {
			$settings->mobilestore_featured_categories_tablet = array();
			$wptouch_pro->settings_objects[ MOBILESTORE_SETTING_DOMAIN ] = $settings;
			$settings->save();
		}
	}
}

function mobilestore_if_tablets_supported(){
	$settings = mobilestore_get_settings();

/*	if ( $settings->mobilestore_tablet_support ) {
		return true;
	}
*/
	return false;
}