<?php
mobilestore_setup_woocommerce();

function mobilestore_setup_woocommerce() {
	add_theme_support( 'woocommerce' );
	$settings = mobilestore_get_settings();

	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price' );

	if ( $settings->mobilestore_product_pagination == 'ajax' ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
	}

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
	remove_action( 'wp_footer', 'woocommerce_demo_store' );

	add_action( 'wp_loaded', 'mobilestore_handle_ajax_add_to_cart_failure', 99 );
	add_action( 'init', 'mobilestore_handle_query_vars', 999 );
	add_action( 'wp_enqueue_scripts', 'mobilestore_enqueue_scripts' );

	if ( function_exists( 'woocommerce_demo_store' ) ) {
		add_action( 'mobilestore_pre_sort_content', 'woocommerce_demo_store' );
	}

	add_action( 'pre_get_posts', 'mobilestore_products_per_page', 30 );
	add_filter( 'query_vars', 'mobilestore_add_query_vars' );
	add_filter( 'post_limits', 'wptouch_mobilestore_filter_search_limits', 10, 2 );

	add_action( 'woocommerce_single_product_summary', 'output_notice_wrapper', 25);
	function output_notice_wrapper() {
		echo '<div class="notice"></div>';
	}
	add_action( 'woocommerce_before_main_content', 'wptouch_mobilestore_output_content_wrapper', 10 );
	add_action( 'woocommerce_after_main_content', 'wptouch_mobilestore_output_content_wrapper_end', 10 );
	add_filter( 'woocommerce_show_page_title', 'mobilestore_page_title' );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_thumbnails', 50 );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title' );
	add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_price' );
	add_action( 'woocommerce_before_single_product_summary', 'output_product_start_wrapper', 1 );
	function output_product_start_wrapper() {
		echo '<div class="product-top">';
	}
	add_action( 'woocommerce_before_single_product_summary', 'output_end_wrapper', 99 );
	function output_end_wrapper() {
		echo '</div>';
	}
	add_filter( 'single_product_small_thumbnail_size', 'wptouch_mobilestore_thumbnail_size' );

	add_action( 'woocommerce_before_checkout_form', 'mobilestore_get_user_location' );
	add_action( 'woocommerce_before_checkout_form', 'output_utilities_start_wrapper', 5 );
	function output_utilities_start_wrapper() {
		echo '<div id="checkout_utilities">';
	}
	add_action( 'woocommerce_before_checkout_form', 'output_end_wrapper', 20 );

	add_filter( 'woocommerce_checkout_coupon_message', 'mobilestore_wrap_text' );
	add_filter( 'woocommerce_checkout_login_message', 'mobilestore_wrap_text' );
	add_filter( 'woocommerce_checkout_get_value', 'mobilestore_default_country', 10, 2 );

	add_filter( 'woocommerce_get_price_html', 'mobilestore_collapse_price_html' );

	if ( count( $settings->mobilestore_product_filters ) > 0 ) {
		add_filter( 'sidebars_widgets', 'mobilestore_force_woo_filter_widgets' );
	}

	if ( $settings->mobilestore_use_ajax_add_to_cart == true ){
		add_filter( 'add_to_cart_redirect', 'return_cart_redirect' );
		add_filter( 'wc_add_to_cart_message', 'clear_add_to_cart_message' );
	}

	if ( $settings->mobilestore_show_recently_viewed == true ) {
		add_filter( 'sidebars_widgets', 'mobilestore_force_recently_viewed_widget' );
	}
}

function return_cart_redirect( $redirect_url ) {
	if ( isset( $_REQUEST[ 'wptouch_ajax_cart' ] ) && ( !is_cart() ) ){
		return '?wptouch_mobilestore_action=add_to_cart_success';
	} else {
		return $redirect_url;
	}
}

function clear_add_to_cart_message(){
	return false;
}


function mobilestore_collapse_price_html( $price ) {
	return str_replace( '</span>&ndash;<span class="amount">', ' &ndash; ', $price );
}

function mobilestore_enqueue_scripts() {

	wp_dequeue_style( 'woocommerce-general' );
	wp_dequeue_style( 'woocommerce-layout' );
	wp_dequeue_style( 'woocommerce_fancybox_styles' );
	wp_dequeue_style( 'woocommerce-smallscreen' );
	wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	wp_dequeue_script( 'prettyPhoto' );
	wp_dequeue_script( 'prettyPhoto-init' );
	wp_dequeue_script( 'select2' );


	// libraries
	wp_enqueue_script(
		'mobilestore-libraries-js',
		MOBILESTORE_URL . '/default/libraries.js',
		array( 'jquery' ),
		MOBILESTORE_THEME_VERSION,
		true
	);

	if ( file_exists( MOBILESTORE_DIR . '/default/mobilestore.min.js' ) ) {
		$path_to_use = MOBILESTORE_URL . '/default/mobilestore.min.js';
	} else {
		$path_to_use = MOBILESTORE_URL . '/default/mobilestore.js';
	}

	// mobilestore min js
	wp_register_script(
		'mobilestore-js',
		$path_to_use,
		array( 'jquery', 'mobilestore-libraries-js' ),
		MOBILESTORE_THEME_VERSION,
		true
	);

	$translation_array = array(
		'login_toggle_start' => __( 'Login now', 'wptouch-pro' ),
		'login_toggle_close' => __( 'Close', 'wptouch-pro' ),
		'company_name_link' => __( 'Add Company Name', 'wptouch-pro' ),
		'order_notes_link' => __( 'Add Order Notes', 'wptouch-pro' ),
		'cvc' => __( 'CVC', 'wptouch-pro' )
	);
	wp_localize_script( 'mobilestore-js', 'translated_strings', $translation_array );
	wp_enqueue_script( 'mobilestore-js' );
}

function mobilestore_page_title() {
	// Hide the WooCommerce page title if the shop page is the home page.
	if ( is_front_page() ) {
		return false;
	} else {
		return true;
	}
}

function mobilestore_wrap_text( $text ) {
	return '<span>' . $text . '</span>';
}

function mobilestore_get_user_location() {
	global $woocommerce;

	if ( !$woocommerce->session->get( 'user_location' ) && ini_get( 'allow_url_fopen' ) == 1 ) {
		$country_lookup = 'http://ip-api.com/php/' . $_SERVER[ 'REMOTE_ADDR' ];
		$woocommerce->session->set( 'user_location', file_get_contents( $country_lookup ) );
	}
}

function mobilestore_default_country( $value, $input ) {
	if ( $input == 'billing_country' || $input == 'shipping_country' ) {
		global $woocommerce;
		$location = $woocommerce->session->get( 'user_location' );
		if ( is_array( $location ) && isset( $location[ 'status'] ) && $location[ 'status' ] == 'success' ) {
			return $location[ 'countryCode' ];
		}
	} elseif( $input == 'billing_state' ) {
		global $woocommerce;
		$location = $woocommerce->session->get( 'user_location' );
		if ( is_array( $location ) && isset( $location[ 'status'] ) && $location[ 'status' ] == 'success' ) {
			return $location[ 'region' ];
		}
	} else {
		return $value;
	}
}

function wptouch_mobilestore_thumbnail_size( $default ) {
	return 'shop_single';
}

function wptouch_mobilestore_output_content_wrapper() {
	echo '<div id="content">';
}

function wptouch_mobilestore_output_content_wrapper_end() {
	echo '</div>';
	$settings = mobilestore_get_settings();
	if ( $settings->mobilestore_product_pagination == 'ajax' && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		global $wp_query;
		if ( get_next_posts_page_link( $wp_query->max_num_pages ) ) {
			echo '<a class="load-more-products-link no-ajax" href="#" rel="' . get_next_posts_page_link($wp_query->max_num_pages) . '">';
			_e( 'view more products', 'wptouch-pro' );
			echo '</a>';
		}
	}
}

function mobilestore_add_query_vars($qvars){
    $qvars[]='wptouch_mobilestore_action';
    return $qvars;
}

function mobilestore_handle_query_vars() {

	$do_interrupt = false;

	if ( isset( $_REQUEST[ 'wptouch_mobilestore_action' ] ) ) {
		switch ( $_REQUEST[ 'wptouch_mobilestore_action' ] ) {
			case 'add_to_cart_success':
				echo json_encode( array( 'wptouch_mobilestore_action' => 'success', 'message' => __( 'Added to cart', 'wptouch-pro' ) ) );
				$do_interrupt = true;
				break;
			case 'refresh_cart':
				woocommerce_mini_cart();
				$do_interrupt = true;
				break;
			case 'add_to_cart':
				break;
			default:
				print_r( wc_get_notices() );
		}

		if ( $do_interrupt ) {
			wc_clear_notices();
			die();
		}
	} else {
		mobilestore_handle_ajax_add_to_cart_failure();
	}
}

function mobilestore_handle_ajax_add_to_cart_failure() {
	if ( function_exists( 'wc_get_notices' ) ) {
		$notices = wc_get_notices();
		if ( array_key_exists( 'error', $notices ) && isset( $_REQUEST[ 'add-to-cart' ] ) ) {
			$notices = wc_get_notices();
			$error = preg_replace( '#<a.*?>([^>]*)</a> (.*)#i' , '$2', $notices[ 'error' ][ 0 ] );
			echo json_encode( array( 'wptouch_mobilestore_action' => 'error', 'message' => $error ) );
			wc_clear_notices();
			die();
		}
	}
}

function mobilestore_products_per_page( $query ) {
	if ( is_array( $query->query_vars ) && ( isset( $query->query_vars[ 'post_type' ] ) && $query->query_vars[ 'post_type' ] == 'product' ) || ( isset( $query->query_vars[ 'product_cat' ] ) ) ) {
		$settings = mobilestore_get_settings();
		set_query_var( 'posts_per_page', $settings->mobilestore_products_per_page );
	}
}

function wptouch_mobilestore_filter_search_limits( $limit, $query ) {
	$post_count = false;

	if ( !is_admin() && $query->is_main_query() && $query->is_search() ) {
		if ( $query->query_vars[ 'post_type' ] == 'product' ) {
			$post_count = $query->query_vars[ 'posts_per_page' ];
		} else {
			$post_count = foundation_number_of_posts_to_show();
		}
	}

	if ( $post_count ) {
		$wp_ppp = $query->query_vars[ 'posts_per_page' ];
		$limits = explode( ', ',  $limit );
		$offset = substr( $limits[ 0 ], 6 );
		$count = $limits[ 1 ];

		$offset_multiplier = $offset / $wp_ppp;
		$count_multiplier = $count / $wp_ppp;

		$offset = $offset_multiplier * $post_count;
		$count = $count_multiplier * $post_count;

		return 'LIMIT ' . $offset . ', ' . $count;
	} else {
		return $limit;
	}
}

function mobilestore_full_image_url() {
	if ( has_post_thumbnail() ) {
		$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		echo $full_image_url[0];
	}
}

function mobilestore_woo_cart_url(){
	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();
	if ( $cart_url ) {
		echo $cart_url;
	} else {
		return false;
	}
}

function mobilestore_woo_checkout_url(){
	global $woocommerce;
	$checkout_url = $woocommerce->cart->get_checkout_url();
	if ( $checkout_url ) {
		echo $checkout_url;
	} else {
		return false;
	}
}

function mobilestore_have_filters() {
	$settings = mobilestore_get_settings();

	if ( count( $settings->mobilestore_product_filters ) > 0 && $settings->mobilestore_product_filters != '' ) {
		return true;
	} else {
		return false;
	}
}

function mobilestore_do_filters() {
	$settings = mobilestore_get_settings();
	$instance = array( 'display_type' => 'list', 'query_type' => 'and' );

	if ( count( $settings->mobilestore_product_filters ) > 0 ) {
		foreach ( $settings->mobilestore_product_filters as $attribute_name ) {
			if ( taxonomy_exists( wc_attribute_taxonomy_name( $attribute_name ) ) ) {
				$instance[ 'title' ] = strtolower( wc_attribute_label( 'pa_' . $attribute_name ) );
				$instance[ 'attribute' ] = $attribute_name;
				the_widget( 'WC_Widget_Layered_Nav' , $instance );
			}
		}
	}
}

function mobilestore_force_woo_filter_widgets( $widgets ) {
	$widgets[ 'mobile' ] = array( 'woocommerce_layered_nav-2' );
	return $widgets;
}

function mobilestore_show_active_filters(){
	$settings = mobilestore_get_settings();

	if ( count( $settings->mobilestore_product_filters ) > 0 ) {
		the_widget( 'WC_Widget_Layered_Nav_Filters', array( 'title' => '' ), 'before_widget=<div class="active-filters"><i class="wptouch-icon-filter"></i>&after_widget=</div>' );
	}
}

function mobilestore_is_tablet() {
	$settings = mobilestore_get_settings();

	if ( function_exists( 'foundation_is_tablet' ) && foundation_is_tablet() && mobilestore_if_tablets_supported() ) {
		return true;
	}

	return false;
}

function mobilestore_list_category_products( $category_slug = '', $top_selling = true ) {
	$args = array(
		'post_type'     => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 11,
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			)
		),
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'terms' => $category_slug,
				'field' => 'slug',
				'operator' => 'IN'
			)
		)
	);

	if ( $top_selling ) {
		$args[ 'meta_key' ] = 'total_sales';
		$args[ 'orderby' ] = 'meta_value_num';
	}

	$loop = new WP_Query( $args );

	$counter = 0;
	while ( $loop->have_posts() ) {
		$loop->the_post();
		$counter++;
		if ( $counter <= 10 ) {
			global $product;
			if (!$product->is_visible()) continue;
			wc_get_template_part( 'content', 'product' );
		} else {
			echo '<li class="more"><a href="' . get_term_link( $category_slug, 'product_cat' ) . '"><i class="wptouch-icon-angle-right"></i>' . __( 'More', 'wptouch-pro' ) . '</a></li>';
		}
	}
}

function mobilestore_list_top_selling_products() {
	$args = array(
		'post_type'     => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 10,
		'meta_key' 		 		=> 'total_sales',
		'orderby' 		 		=> 'meta_value_num',
		'meta_query' => array(
			array(
				'key' => '_visibility',
				'value' => array('catalog', 'visible'),
				'compare' => 'IN'
			)
		)
	);

	$loop = new WP_Query( $args );

	while ( $loop->have_posts() ) {
		$loop->the_post();
		global $product;
		if (!$product->is_visible()) continue;
		wc_get_template_part( 'content', 'product' );
	}
}

/* Compatibility with the WooThemes storefront designer plugin. */
function storefront_sanitize_hex_color() {
	return false;
}

function mobilestore_cart_icon_link(){
	$settings = mobilestore_get_settings();
	if ( $settings->mobilestore_show_minicart == true ) {
		return false;
	} else {
		return true;
	}
}

function mobilestore_force_recently_viewed_widget( $sidebars ) {
	$sidebars[ 'mobilestore' ] = array( 'woocommerce_recently_viewed_products' );
	return $sidebars;
}