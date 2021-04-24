<?php

function wpassist_remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
} 
add_action( 'wp_enqueue_scripts', 'wpassist_remove_block_library_css' );


/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

add_action('pre_get_posts', 'wpse74620_ignore_sticky');
// the function that does the work
function wpse74620_ignore_sticky($query)
{
    // sure we're were we want to be.
    if (is_home() && $query->is_main_query())
        $query->set('ignore_sticky_posts', true);
}

add_action( 'wp_enqueue_scripts', 'classic_enqueue_scripts' );

function classic_enqueue_scripts() {
	wp_enqueue_script( 
		'classic-js', 
		CLASSIC_URL . '/default/classic.js', 
		array( 'jquery' ), 
		CLASSIC_THEME_VERSION, 
		true 
	);
}

function classic_should_show_thumbnail() {
	$settings = classic_get_settings();

	switch( $settings->use_thumbnails ) {
		case 'none':
			return false;
		case 'index':
			return is_home();
		case 'index_single':
			return is_home() || is_single();
		case 'all':
			return is_home() || is_single() || is_page() || is_archive() || is_search();
		default:
			// in case we add one at some point
			return false;
	}
}

function classic_should_show_taxonomy() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_taxonomy ) {
		return true;
	} else {
		return false;
	}
}

function classic_should_show_author() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_author ) {
		return true;
	} else {
		return false;
	}
}

function classic_should_show_date() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_date ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_menu_button_text() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->menu_button_as_text ) {
		return true;
	} else {
		return false;
	}
}

function classic_show_page_titles() {
	$classic_settings = classic_get_settings();
	
	if ( $classic_settings->show_page_titles ) {
		return true;
	} else {
		return false;
	}
}
