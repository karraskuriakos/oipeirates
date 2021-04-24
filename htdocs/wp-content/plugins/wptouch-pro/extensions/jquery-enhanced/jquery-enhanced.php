<?php
define( 'JQUERY_E_CONTENT_VERSION', '1.1' );
define( 'JQUERY_E_PAGENAME', 'jQuery Enhanced' );

add_filter( 'wptouch_addon_options', 'wptouch_addon_jquery_e_options' );
add_filter( 'wptouch_setting_defaults_addons', 'wptouch_addon_jquery_e_settings_defaults' );
add_filter( 'admin_init', 'wptouch_addon_jquery_e_load_admin_js' );
add_action( 'init', 'wptouch_addon_jquery_e' );

function wptouch_addon_jquery_e_settings_defaults( $settings ) {

	$settings->enable_jquery_e = true;
	$settings->enable_jquery_e_footer = true;
	$settings->enable_jquery_e_v2 = 'jqueryone';

	return $settings;
}

function wptouch_addon_jquery_e_options( $page_options ) {
	wptouch_add_sub_page(
        JQUERY_E_PAGENAME,
        'wptouch-addon-jquery-e',
        $page_options
    );

	$settings_array[] = wptouch_add_setting(
		'checkbox',
		'enable_jquery_e',
		__( 'Enable jQuery Enhanced', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'3.7.8'
	);

	$settings_array[] = wptouch_add_setting(
		'radiolist',
		'enable_jquery_e_v2',
		__( 'Choose a version', 'wptouch-pro' ),
		__( 'jQuery 2.x does not include support for older mobile devices and operating systems. Can cause issues with other plugins that rely on older jQuery code. Use with caution.', 'wptouch-pro' ),
		WPTOUCH_SETTING_BASIC,
		'3.7.8',
		array(
			'jqueryone' => __( 'Latest jQuery 1.x', 'wptouch-pro' ),
			'jquerytwo' => __( 'Latest jQuery 2.x', 'wptouch-pro' )
		)
	);

	$settings_array[] = wptouch_add_setting(
		'checkbox',
		'enable_jquery_e_footer',
		__( 'Load jQuery in the footer instead of the header', 'wptouch-pro' ),
		false,
		WPTOUCH_SETTING_BASIC,
		'3.7.8'
	);

	wptouch_add_page_section(
		JQUERY_E_PAGENAME,
		__( 'jQuery Enhanced', 'wptouch-pro' ),
		'addons-jquery-e',
		$settings_array,
		$page_options,
		ADDON_SETTING_DOMAIN
	);

	return $page_options;
}

function wptouch_addon_jquery_e_load_admin_js(){
	global $wptouch_pro;
	if ( $wptouch_pro->admin_is_wptouch_page() ) {
		wp_enqueue_script(
			'jquery-enhanced',
			WPTOUCH_BASE_CONTENT_URL . '/extensions/jquery-enhanced/jquery-enhanced-admin.js',
			array( 'wptouch-pro-admin' ),
			FOUNDATION_VERSION,
			true
		);
	}
}

function wptouch_addon_jquery_e(){
	if ( !is_admin() && wptouch_is_showing_mobile_theme_on_mobile_device() ){
		$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

		$in_footer = ( $settings->enable_jquery_e_footer === 1 ? 1 : 0 );

		if ( $settings->enable_jquery_e == true ) {
			wp_deregister_script( 'jquery' );

			if ( $settings->enable_jquery_e_v2 == 'jquerytwo' ) {
				wp_register_script( 'jquery', '//code.jquery.com/jquery-2.1.4.min.js', false, '2.1.4', $in_footer );
			} else {
				wp_register_script( 'jquery', '//code.jquery.com/jquery-1.11.3.min.js', false, '1.11.3', $in_footer );
			}

			wp_enqueue_script( 'jquery' );
		}
	}
}