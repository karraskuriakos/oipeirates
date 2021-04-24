<?php

add_action( 'foundation_enqueue_scripts', 'simple_enqueue_scripts' );

function simple_enqueue_scripts() {
	wp_enqueue_script( 'simple', SIMPLE_URL . '/default/simple.js', array( 'jquery' ), SIMPLE_THEME_VERSION, true );
}

function simple_full_image_url() {
	if ( has_post_thumbnail() ) {
		$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		echo $full_image_url[0];
	}
}

function simple_homepage_content() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->homepage_message ) {
		echo '<p class="message">';
		echo do_shortcode( $simple_settings->homepage_message );
		echo '</p>';
	}
}

function simple_has_custom_content() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->homepage_message ) {
		return true;
	} else {
		return false;
	}
}

function simple_map_display() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->map_address ) {
		echo '<p>' . $simple_settings->map_address . '</p>';
		echo '<br />';
		echo '<div class="simple-map"><iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="//maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=' . $simple_settings->map_address . '&ie=UTF8&z=12&t=m&iwloc=near&output=embed"></iframe></div>';
	}
}

function simple_has_map() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->map_address ) {
		return true;
	} else {
		return false;
	}
}

function simple_phone_number() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->phone_number ) {
		echo $simple_settings->phone_number;
	}
}

function simple_has_phone_number() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->phone_number ) {
		return true;
	} else {
		return false;
	}
}

function simple_get_background_image() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->background_image ) {
		echo foundation_prepare_uploaded_file_url( $simple_settings->background_image );
		return true;
	} else {
		return false;
	}
}

function simple_show_search() {
	$simple_settings = simple_get_settings();

	if ( $simple_settings->blog_search ) {
		return true;
	} else {
		return false;
	}
}