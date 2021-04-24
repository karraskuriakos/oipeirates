<?php
add_action( 'foundation_enqueue_scripts', 'open_enqueue_scripts' );

add_filter( 'wptouch_menu_start_html', 'open_add_menu_links' );
add_filter( 'body_class', 'open_body_classes' );

function open_full_image_url() {
	if ( has_post_thumbnail() ) {
		$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		echo $full_image_url[0];
	}
}

function open_add_menu_links( $input ) {
	$open_settings = open_get_settings();

	$menu_items = '';

	if ( $open_settings->map_address ) {
		$menu_items .= '<li class="menu-item auto"><i class="wptouch-icon-map-marker" style="color:' . open_alter_colour( $open_settings->open_link_color, 30 ) . '"></i><a href="' . home_url() . '?open_feature=location">' . __( 'Our Location', 'wptouch-pro' ) . '</a></li>';
	}

	if ( $open_settings->show_hours ) {
		$menu_items .= '<li class="menu-item auto"><i class="wptouch-icon-time" style="color:' . open_alter_colour( $open_settings->open_link_color, 30 ) . '"></i><a href="' . home_url() . '?open_feature=hours">' . __( 'Our Hours', 'wptouch-pro' ) . '</a></li>';
	}

	if ( $input == '</ul>' ) {
		$input = $menu_items . $input;
	} else {
		$input = $input . $menu_items;
	}

	return $input;
}

function open_enqueue_scripts() {
	wp_enqueue_script( 'open-js', OPEN_URL . '/default/open.js', array(), OPEN_THEME_VERSION, true );
}

function open_tagline() {
	$open_settings = open_get_settings();

	if ( $open_settings->tagline ) {
		echo '<p class="tagline">' . $open_settings->tagline . '</p>';
	}
}

function open_phone_number() {
	$open_settings = open_get_settings();

	if ( $open_settings->phone_number ) {
		echo $open_settings->phone_number;
	}
}

function open_has_phone_number() {
	$open_settings = open_get_settings();

	if ( $open_settings->phone_number ) {
		return true;
	} else {
		return false;
	}
}

function open_homepage_content() {
/*	$open_settings = open_get_settings();

	if ( $open_settings->homepage_message ) {
		echo '<p class="message">';
		echo $open_settings->homepage_message;
		echo '</p>';
	}*/
}

function open_header_image() {
	$header_image = false;

	$open_settings = open_get_settings();
	$header_image = foundation_prepare_uploaded_file_url( $open_settings->header_image );

	if ( $header_image && $header_image != WPTOUCH_BASE_CONTENT_URL ) {
		echo '<div class="header-image" style="background-image: url(\'' . $header_image . '\');"></div>';
	}
}

function open_header_class() {
	$open_settings = open_get_settings();
	if ( $open_settings->logo_background_field == false ) {
		echo ' class="no-background"';
	}
}

function open_alter_colour( $color_code , $percentage_adjuster = 0 ) {
/**
 * @param $color_code
 * @param int $percentage_adjuster
 * @return array|string
 * @author Jaspreet Chahal
 */
$percentage_adjuster = round($percentage_adjuster/100,2);
	if( is_array( $color_code ) ) {
		$r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
		$g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
		$b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

		return array("r"=> round(max(0,min(255,$r))),
			"g"=> round(max(0,min(255,$g))),
			"b"=> round(max(0,min(255,$b))));
	} else if ( preg_match( "/#/", $color_code ) ) {
		$hex = str_replace("#","",$color_code);
		$r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
		$g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
		$b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
		$r = round($r - ($r*$percentage_adjuster));
		$g = round($g - ($g*$percentage_adjuster));
		$b = round($b - ($b*$percentage_adjuster));

		return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
			.str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
			.str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);
	}
}