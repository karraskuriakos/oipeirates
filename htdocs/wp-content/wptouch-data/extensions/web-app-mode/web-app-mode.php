<?php
if ( !function_exists( 'foundation_webapp_settings' ) ) {
	define( 'FOUNDATION_PAGE_WEB_APP', __( 'Web-App Mode', 'wptouch-pro' ) );

	add_action( 'wptouch_admin_page_render_wptouch-admin-theme-settings', 'foundation_webapp_settings' );
	add_filter( 'admin_init', 'wptouch_addon_web_app_mode_load_admin_js' );

	function foundation_webapp_settings( $page_options ) {
		$show_wam_settings = apply_filters( 'wptouch_allow_wam', true );
		$settings = foundation_get_settings();

		wptouch_add_sub_page( FOUNDATION_PAGE_WEB_APP, 'wptouch-addon-webapp', $page_options );


		if ( !$show_wam_settings ) {
			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Web-App Mode Unavailable', 'wptouch-pro' ),
				'web-app-settings',
				array(
					wptouch_add_pro_setting(
						'checkbox',
						'webapp_mode_unavailable',
						apply_filters( 'wptouch_allow_wam_message', 'Web-App Mode has been disabled by a theme or extension.' ),
						false,
						WPTOUCH_SETTING_BASIC,
						'3.6.6'
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);
		} else {
			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Settings', 'wptouch-pro' ),
				'web-app-settings',
				array(
					wptouch_add_pro_setting(
						'checkbox',
						'webapp_enable_persistence',
						__( 'Enable persistence', 'wptouch-pro' ),
						__( 'Loads the last visited URL for visitors on open.', 'wptouch-pro' ),
						WPTOUCH_SETTING_BASIC,
						'1.0.2'
					),
					$wam_settings[] = wptouch_add_pro_setting(
						'textarea',
						'webapp_ignore_urls',
						__( 'URLs to ignore in Web-App Mode', 'wptouch-pro' ),
						false,
						WPTOUCH_SETTING_BASIC,
						'1.0.2'
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);

			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Notice Message', 'wptouch-pro' ),
				'notice-message',
				array(
					wptouch_add_pro_setting(
						'checkbox',
						'webapp_show_notice',
						__( 'Show a web app notice message for new iOS visitors', 'wptouch-pro' ),
						false,
						WPTOUCH_SETTING_BASIC,
						'1.0'
					),
					wptouch_add_pro_setting(
						'list',
						'webapp_notice_expiry_days',
						__( 'Message will be shown again for visitors', 'wptouch-pro' ),
						false,
						WPTOUCH_SETTING_BASIC,
						'1.0',
						array(
							'0' => __( 'Every visit', 'wptouch-pro' ),
							'1' => __( 'After 1 day', 'wptouch-pro' ),
							'7' => __( 'After 7 days', 'wptouch-pro' ),
							'30' => __( 'In 1 month', 'wptouch-pro' )
						)
					)
				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);

			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Startup Images', 'wptouch-pro' ),
				'bookmark-startup-imgs',
				array(
					wptouch_add_pro_setting(
						'custom',
						'customizing_in_customizer',
						false,
						false,
						WPTOUCH_SETTING_BASIC,
						'4.0'
					)

				),
				$page_options,
				FOUNDATION_SETTING_DOMAIN
			);


			/* Startup Screen Area */

			if ( foundation_is_theme_using_module( 'tablets' ) ) {
				$startup_screen_fields = array(
					wptouch_add_pro_setting(
						'image-upload',
						'startup_screen_ipad_full_portrait',
						sprintf( __( 'iPad (%d by %d pixels)', 'wptouch-pro' ), 1536, 2008 ),
						false,
						WPTOUCH_SETTING_BASIC,
						'1.0'
					),
					wptouch_add_pro_setting(
						'image-upload',
						'startup_screen_ipad_full_landscape',
						sprintf( __( 'iPad (%d by %d pixels)', 'wptouch-pro' ), 2048, 1496 ),
						false,
						WPTOUCH_SETTING_BASIC,
						'1.0'
					)
				);
			} else {
				$startup_screen_fields = array();
			}

			array_unshift(
				$startup_screen_fields,
				wptouch_add_pro_setting(
					'image-upload',
					'startup_screen_full_res',
					sprintf( __( 'iPhone (%d by %d pixels)', 'wptouch-pro' ), 1242,2148 ),
					false,
					WPTOUCH_SETTING_BASIC,
					'1.0'
				)
			);

			wptouch_add_page_section(
				FOUNDATION_PAGE_WEB_APP,
				__( 'Web-App Startup Screens (iOS)', 'wptouch-pro' ),
				'iphone-startup-screen',
				$startup_screen_fields,
				$page_options,
				FOUNDATION_SETTING_DOMAIN,
				true
			);
		}

		return $page_options;
	}

	add_action( 'wptouch_customizer_start_setup', 'foundation_webapp_recover_startup_images' );

	function foundation_webapp_recover_startup_images() {
		wptouch_customizer_port_image( 'wptouch_startup_screen_full_res', 'startup_screen_iphone_6plus' );
		wptouch_customizer_port_image( 'wptouch_startup_screen_ipad_full_portrait', 'startup_screen_ipad_3_portrait' );
		wptouch_customizer_port_image( 'wptouch_startup_screen_ipad_full_landscape', 'startup_screen_ipad_3_landscape' );
	}

	add_filter( 'wptouch_customizer_save__foundation__startup_screen_full_res', 'foundation_webapp_save_startup_images', 10, 2 );

	function foundation_webapp_save_startup_images( $settings, $new_image ) {
		$sizes = array(
			'startup_screen_iphone_2g_3g' => array( 320, 460 ), // Early iPhone
			'startup_screen_iphone_4_4s' => array( 640, 920 ), // iPhone 4, 4s
			'startup_screen_iphone_5' => array( 640, 1096 ), // iPhone 5
			'startup_screen_iphone_6' => array( 750, 1294 ), // iPhone 6
			'startup_screen_iphone_6plus' => array( 1242, 2148 ), // iPhone 6+
		);

		return foundation_webapp_save_image_sizes( $settings, $new_image, 'startup_screen_full_res', 'png', $sizes );
	}

	add_filter( 'wptouch_customizer_save__foundation__startup_screen_ipad_full_portrait', 'foundation_webapp_save_startup_image_ipad_portrait', 10, 2 );

	function foundation_webapp_save_startup_image_ipad_portrait( $settings, $new_image ) {
		$sizes = array(
			'startup_screen_ipad_1_portrait' => array( 768, 1004 ),
			'startup_screen_ipad_3_portrait' => array( 1536, 2008 )
		);

		return foundation_webapp_save_image_sizes( $settings, $new_image, 'startup_screen_ipad_full_portrait', 'png', $sizes );
	}

	add_filter( 'wptouch_customizer_save__foundation__startup_screen_ipad_full_landscape', 'foundation_webapp_save_startup_image_ipad_landscape', 10, 2 );

	function foundation_webapp_save_startup_image_ipad_landscape( $settings, $new_image ) {
		$sizes = array(
			'startup_screen_ipad_1_landscape' => array( 1024, 748 ),
			'startup_screen_ipad_3_landscape' => array( 2048, 1496 )
		);

		return foundation_webapp_save_image_sizes( $settings, $new_image, 'startup_screen_ipad_full_landscape', 'png', $sizes );
	}

	add_action( 'foundation_module_init_mobile', 'foundation_webapp_init' );
	add_action( 'wptouch_post_head', 'foundation_setup_meta_area' );

	add_filter( 'wptouch_body_classes', 'foundation_webapp_body_classes' );
	add_filter( 'foundation_inline_style', 'foundation_webapp_inline_style' );
	add_filter( 'login_enqueue_scripts', 'foundation_webapp_inject_login_screen_components' );

	define( 'WPTOUCH_WEBAPP_COOKIE', 'wptouch-webapp' );
	define( 'WPTOUCH_WEBAPP_PERSIST_COOKIE', 'wptouch-webapp-persist' );

	function foundation_webapp_mode_enabled() {
		return apply_filters( 'wptouch_allow_wam', true );
	}

	function foundation_webapp_mode_active() {
		if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'Safari/' ) === false && strpos( $_SERVER['HTTP_USER_AGENT'], 'FBAN' ) === false && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'iPhone' ) || strpos( $_SERVER['HTTP_USER_AGENT'], 'iPod' ) || strpos( $_SERVER['HTTP_USER_AGENT'], 'iPad' ) ) ) {
			return true;
		} else {
			return false;
		}
	}

	function foundation_webapp_inject_login_screen_components() {
		if ( function_exists( 'wptouch_is_showing_mobile_theme_on_mobile_device' ) && wptouch_is_showing_mobile_theme_on_mobile_device() ) {
			echo '<style type="text/css">' . foundation_webapp_inline_style( '' ) . '</style>';
			foundation_setup_meta_area();
			foundation_setup_homescreen_icons();
		}
	}

	function foundation_webapp_inline_style( $style_data ) {
		require_once( WPTOUCH_DIR . '/core/file-operations.php' );

		return $style_data . wptouch_load_file( dirname( __FILE__ ) . '/addtohomescreen.css' );
	}

	function foundation_webapp_get_style_deps( $other_styles = array() ) {
		$style_deps = $other_styles;

		if ( defined( 'WPTOUCH_MODULE_RESET_INSTALLED' ) ) {
			$style_deps[] = 'foundation_reset';
		}

		return $style_deps;
	}

	function foundation_webapp_get_persistence_salt() {
		global $blog_id;

		if ( $blog_id ) {
			return substr( md5( $blog_id ), 0, 8 );
		} else return substr( md5( 'none' ), 0, 8 );
	}

	function foundation_webapp_init() {
		$settings = foundation_get_settings();
		$wptouch_settings = wptouch_get_settings();

		if ( isset( $_REQUEST[ 'wptouch_app_manifest' ] ) ) {
			echo json_encode(
				array(
					'short_name' => get_bloginfo( 'name' ),
					'icons' => array(
						array(
							'src' => $settings->iphone_icon_retina,
							'sizes' => '192x192'
						),
						array(
							'src' => $settings->android_others_icon,
							'sizes' => '57x57'
						),
					),
					'start_url' =>site_url() . '?wptouch_webapp_start=manifest',
					'display'=> 'standalone',
					'orientation'=> 'portrait'
				)
			);
			die();
		}

		// Do redirect in webapp mode
		if ( $settings->webapp_enable_persistence && foundation_webapp_mode_active() ) {
			if ( isset( $_COOKIE[WPTOUCH_WEBAPP_PERSIST_COOKIE . '-' . foundation_webapp_get_persistence_salt()] ) ) {

				$current_url = rtrim( $_SERVER['HTTP_HOST'] . strtolower( $_SERVER['REQUEST_URI'] ), '/' );
				$stored_url = str_replace( array( 'https://', 'http://' ), array( '', '' ), rtrim( strtolower( $_COOKIE[WPTOUCH_WEBAPP_PERSIST_COOKIE . '-' . foundation_webapp_get_persistence_salt()] ), '/' ) );

				if ( !strpos( $stored_url, '/logout/' ) && !strpos( $stored_url, '?action=logout' ) && $current_url != $stored_url && !isset( $_COOKIE[WPTOUCH_WEBAPP_COOKIE . '-' . foundation_webapp_get_persistence_salt()] ) && empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
					$cookie = $_COOKIE[WPTOUCH_WEBAPP_PERSIST_COOKIE . '-' . foundation_webapp_get_persistence_salt()];
					header( 'Location: ' . $cookie );
					die;
				}
			}
		}

		if ( foundation_webapp_mode_enabled() && $settings->webapp_show_notice == true && !foundation_webapp_mode_active() ) {

			wp_enqueue_script(
				'foundation_add2home',
				WPTOUCH_BASE_CONTENT_URL . '/extensions/web-app-mode/addtohomescreen.min.js',
				false,
				FOUNDATION_VERSION,
				true
			);

			wp_enqueue_script(
				'foundation_add2home_config',
				WPTOUCH_BASE_CONTENT_URL . '/extensions/web-app-mode/add2home-config.js',
				array( 'foundation_add2home' ),
				FOUNDATION_VERSION,
				true
			);

			$add_to_home_strings = array(
				'bubbleMessage' => str_replace( array( '[icon]', '[device]' ), array( '%icon', 'home screen' ), __( 'Install this Web-App on your home screen: tap [icon] then "Add to Home Screen"', 'wptouch-pro' ) ),
				'themeLanguage' => $wptouch_settings->force_locale,
				'bubbleExpiryInDays' => $settings->webapp_notice_expiry_days*60*24
			);

			wp_localize_script( 'foundation_add2home_config', 'wptouchFdnAddToHome',  $add_to_home_strings );

		}

		if ( foundation_webapp_mode_enabled() ) {

			wp_enqueue_script(
				'foundation_webapp',
				WPTOUCH_BASE_CONTENT_URL . '/extensions/web-app-mode/webapp.js',
				array( 'jquery' ),
				FOUNDATION_VERSION,
				true
			);
			
	//		wp_enqueue_style(
	//			'web-app-mode-css',
	//			WPTOUCH_BASE_CONTENT_URL . '/extensions/web-app-mode/addtohomescreen.css'
	//		);

			$webapp_strings = array();

			if ( $settings->webapp_ignore_urls ) {

				$ignored_wa_urls = explode( "\n", $settings->webapp_ignore_urls );

				$trimmed_wa_urls = array();
				foreach( $ignored_wa_urls as $wa_url ) {
					$trimmed_wa_urls[] = strtolower( trim( $wa_url ) );
				}

				$webapp_strings[ 'ignoredWebAppURLs' ] = $trimmed_wa_urls;
			}

			$admin_settings = wptouch_get_settings();

			if ( $admin_settings->filtered_urls && $admin_settings->url_filter_behaviour == 'exclude_urls' ) {

				$ignored_urls = explode( "\n", $admin_settings->filtered_urls );

				$trimmed_urls = array();
				foreach( $ignored_urls as $url ) {
					$trimmed_urls[] = strtolower( trim( $url ) );
				}

				$webapp_strings[ 'ignoredURLs' ] = $trimmed_urls;

			}

			$webapp_strings[ 'externalLinkText' ] =  __( 'External link— open it in the browser?', 'wptouch-pro' );
			$webapp_strings[ 'externalFileText' ] = __( 'File link— Do you want to open it in the browser?', 'wptouch-pro' );
			$webapp_strings[ 'persistence' ] = ( $settings->webapp_enable_persistence ? '1' : '0' );
			$webapp_strings[ 'persistenceSalt' ] = foundation_webapp_get_persistence_salt();

			wp_localize_script( 'foundation_webapp', 'wptouchWebApp',  $webapp_strings ) ;
		}
	}

	function foundation_setup_meta_area() {

		$settings = foundation_get_settings();

		echo '<link rel="manifest" href="' . site_url() . '?wptouch_app_manifest">';

		echo '<meta name="apple-mobile-web-app-title" content="' . get_bloginfo( 'name' ) . '">' . "\n";

		if ( foundation_webapp_mode_enabled() ) {

			// We're web-app capable
			echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
			echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
			if ( foundation_webapp_mode_active() ) {
				echo '<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" media="(device-height: 568px)" />';
			}

			// iOS Status Bar
				echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";

			// Check for startup screens
			if ( wptouch_is_device_real_ipad() ) {
				// Only output iPad startup screens

				// iPad Portrait
				if ( $settings->startup_screen_ipad_1_portrait ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_ipad_1_portrait ) . '" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPad Landscape
				if ( $settings->startup_screen_ipad_1_landscape ) {
				echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_ipad_1_landscape ) . '" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPad Retina Portrait
				if ( $settings->startup_screen_ipad_3_portrait ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_ipad_3_portrait ) . '" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPad Retina Landscape
				if ( $settings->startup_screen_ipad_3_landscape ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_ipad_3_landscape ) . '" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">' . "\n";
				}
			} else {
				// iPhone
				if ( $settings->startup_screen_iphone_2g_3g ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_2g_3g ) . '" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPhone Retina
				if ( $settings->startup_screen_iphone_4_4s ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_4_4s ) . '" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPhone 5
				if ( $settings->startup_screen_iphone_5 ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_5 ) . '"  media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">' . "\n";
				}

				// iPhone 6
				if ( $settings->startup_screen_iphone_6 ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_6 ) . '"  media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image">' . "\n";
					echo '<style>html{background-image:url("' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_6 ) . '") no-repeat top left;}</style>';
				}

				// iPhone 6+
				if ( $settings->startup_screen_iphone_6plus ) {
					echo '<link href="' . foundation_prepare_uploaded_file_url( $settings->startup_screen_iphone_6plus ) . '"  media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image">' . "\n";
				}
			}
		}

	}

	function foundation_webapp_body_classes( $classes ) {
		$settings = foundation_get_settings();

		if ( foundation_webapp_mode_active() && isset( $_COOKIE[ WPTOUCH_WEBAPP_COOKIE . '-' . foundation_webapp_get_persistence_salt() ] ) ) {
			$classes[] = 'web-app-mode';
		}

		return $classes;
	}

	function foundation_webapp_save_image_sizes( $settings, $new_image, $source_field, $output_filetype, $sizes ) {
		$mime_types = array(
			'png' => 'image/png',
			'jpg' => 'image/jpeg',
		);

		if ( $settings->$source_field != $new_image ) {
			$new_image = get_home_path() . substr( $new_image, strlen( site_url() ) + 1 );

			if ( substr( $new_image, strlen( $new_image ) - 4 ) == 'jpeg' ) {
				$suffix_length = 5;
			} else {
				$suffix_length = 4;
			}

			$new_filename_base = substr( $new_image, 0, strlen( $new_image ) - $suffix_length );

			foreach ( $sizes as $setting_name => $size ) {
				$image = wp_get_image_editor( $new_image );
				if ( ! is_wp_error( $image ) ) {
					$image->resize( $size[ 0 ], $size[ 1 ], true );
					$new_filename = $new_filename_base . '-' . $size[ 0 ] . 'x' . $size[ 1 ] . '.png';
					$image->save( $new_filename, $mime_types[ $output_filetype ] );
					$settings->$setting_name = site_url() . '/' . substr( $new_filename, strlen( get_home_path() ) );
				}
			}
		}

		return $settings;
	}
}

function wptouch_addon_web_app_mode_load_admin_js(){
	global $wptouch_pro;
	if ( $wptouch_pro->admin_is_wptouch_page() ) {
		wp_enqueue_script(
			'web-app-mode-admin',
			WPTOUCH_BASE_CONTENT_URL . '/extensions/web-app-mode/webapp-admin.js',
			array( 'wptouch-pro-admin' ),
			FOUNDATION_VERSION,
			true
		);
	}
}

add_filter( 'wptouch_show_mobile_switch_link', 'wptouch_addon_web_app_return_false_when_wam_active' );
add_filter( 'wptouch_show_login_links', 'wptouch_addon_web_app_return_false_when_wam_active' );

function wptouch_addon_web_app_return_false_when_wam_active( $original_boolean ) {
	if ( foundation_webapp_mode_enabled() && foundation_webapp_mode_active() ) {
		return false;
	} else {
		return $original_boolean;
	}
}