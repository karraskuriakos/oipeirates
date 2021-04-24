<?php
define( 'WPTOUCH_RESPONSIVE_IMAGES_VERSION', '1.4' );
define( 'WPTOUCH_RESPONSIVE_IMAGES_PAGENAME', 'Responsive Images' );
define( 'WPTOUCH_EXTENSION_RESPONSIVE_INSTALLED', '1' );

add_filter( 'wp_loaded', 'wptouch_media_add_sizes' );
add_filter( 'wptouch_addon_options', 'wptouch_media_addon_options' );
add_filter( 'wptouch_setting_defaults_addons', 'wptouch_media_settings_defaults' );

function wptouch_media_add_sizes() {
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'responsive-images-large', 1200, 9999, false );
	}
}

function wptouch_media_settings_defaults( $settings ) {
	$settings->media_optimize_on_desktop = true;

	return $settings;
}

function wptouch_media_addon_options( $page_options ) {
	wptouch_add_sub_page(
        WPTOUCH_RESPONSIVE_IMAGES_PAGENAME,
        'wptouch-addon-responsive-images',
        $page_options
    );

	wptouch_add_page_section(
		WPTOUCH_RESPONSIVE_IMAGES_PAGENAME,
		__( 'Responsive Images', 'wptouch-pro' ),
		'addons-media',
		array(
			wptouch_add_setting(
				'checkbox',
				'media_optimize_on_desktop',
				__( 'Make desktop images responsive', 'wptouch-pro' ),
				__( 'Applies srcset optimization to desktop theme as well as mobile theme.', 'wptouch-pro' ),
				WPTOUCH_SETTING_BASIC,
				'3.1'
			)
		),
		$page_options,
		ADDON_SETTING_DOMAIN
	);

	return $page_options;
}

function wptouch_media_can_optimize() {
	global $wptouch_pro;
	$settings = wptouch_get_settings( ADDON_SETTING_DOMAIN );

	return wptouch_is_mobile_theme_showing() || $settings->media_optimize_on_desktop;
}

add_filter( 'post_thumbnail_html', 'wptouch_media_inject_attachment_id', 10, 5 );
add_filter( 'post_thumbnail_html', 'wp_make_content_images_responsive', 20 );
function wptouch_media_inject_attachment_id( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	return str_replace( 'class="', 'class="wp-image-' . $post_thumbnail_id . ' ', $html );
}

if ( !function_exists( 'wp_make_content_images_responsive' ) ) {
	add_filter( 'the_content', 'wp_make_content_images_responsive', 99 ); // only add our copies as a filter if this WordPress installation does not handle srcset itself.

	function wp_make_content_images_responsive( $content ) {
		if ( wptouch_media_can_optimize() ) {
			if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {
				return $content;
			}

			$selected_images = $attachment_ids = array();

			foreach( $matches[0] as $image ) {

				if ( false === strpos( $image, ' srcset=' ) && preg_match( '/wp-image-([0-9]+)/i', $image, $class_id ) &&
					( $attachment_id = absint( $class_id[1] ) ) ) {

					/*
					 * If exactly the same image tag is used more than once, overwrite it.
					 * All identical tags will be replaced later with 'str_replace()'.
					 */
					$selected_images[ $image ] = $attachment_id;
					// Overwrite the ID when the same image is included more than once.
					$attachment_ids[ $attachment_id ] = true;
				}
			}

			if ( count( $attachment_ids ) > 1 ) {
				/*
				 * Warm object cache for use with 'get_post_meta()'.
				 *
				 * To avoid making a database call for each image, a single query
				 * warms the object cache with the meta information for all images.
				 */
				// update_meta_cache( 'post', array_keys( $attachment_ids ) );
			}
			foreach ( $selected_images as $image => $attachment_id ) {
				$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );
				if ( $image_meta ) {
					$content = str_replace( $image, wp_image_add_srcset_and_sizes( $image, $image_meta, $attachment_id ), $content );
				}
			}
		}

		return $content;
	}
}

if ( !function_exists( 'wp_image_add_srcset_and_sizes' ) ) {
	function wp_image_add_srcset_and_sizes( $image, $image_meta, $attachment_id ) {
		// Ensure the image meta exists.
		if ( empty( $image_meta['sizes'] ) ) {
			return $image;
		}

		$image_src = preg_match( '/src="([^"]+)"/', $image, $match_src ) ? $match_src[1] : '';
		list( $image_src ) = explode( '?', $image_src );

		// Return early if we couldn't get the image source.
		if ( ! $image_src ) {
			return $image;
		}

		// Bail early if an image has been inserted and later edited.
		if ( preg_match( '/-e[0-9]{13}/', $image_meta['file'], $img_edit_hash ) &&
			strpos( wp_basename( $image_src ), $img_edit_hash[0] ) === false ) {

			return $image;
		}

		$base_url = trailingslashit( _wp_upload_dir_baseurl() );
		$image_base_url = $base_url;

		$dirname = dirname( $image_meta['file'] );
		if ( $dirname !== '.' ) {
			$image_base_url .= trailingslashit( $dirname );
		}

		$all_sizes = wp_list_pluck( $image_meta['sizes'], 'file' );

		foreach ( $all_sizes as $key => $file ) {
			$all_sizes[ $key ] = $image_base_url . $file;
		}

		// Add the original image.
		$all_sizes[] = $base_url . $image_meta['file'];

		// Bail early if the image src doesn't match any of the known image sizes.
		if ( ! in_array( $image_src, $all_sizes ) ) {
			return $image;
		}

		$width  = preg_match( '/ width="([0-9]+)"/',  $image, $match_width  ) ? (int) $match_width[1]  : 0;
		$height = preg_match( '/ height="([0-9]+)"/', $image, $match_height ) ? (int) $match_height[1] : 0;

		if ( ! $width || ! $height ) {
			/*
			 * If attempts to parse the size value failed, attempt to use the image meta data to match
			 * the image file name from 'src' against the available sizes for an attachment.
			 */
			$image_filename = wp_basename( $image_src );

			if ( $image_filename === wp_basename( $image_meta['file'] ) ) {
				$width = (int) $image_meta['width'];
				$height = (int) $image_meta['height'];
			} else {
				foreach( $image_meta['sizes'] as $image_size_data ) {
					if ( $image_filename === $image_size_data['file'] ) {
						$width = (int) $image_size_data['width'];
						$height = (int) $image_size_data['height'];
						break;
					}
				}
			}
		}

		if ( ! $width || ! $height ) {
			return $image;
		}

		$size_array = array( $width, $height );
		$srcset = wp_calculate_image_srcset( $size_array, $image_src, $image_meta, $attachment_id );

		if ( $srcset ) {
			// Check if there is already a 'sizes' attribute.
			$sizes = strpos( $image, ' sizes=' );

			if ( ! $sizes ) {
				$sizes = wp_calculate_image_sizes( $size_array, $image_src, $image_meta, $attachment_id );
			}
		}

		if ( $srcset && $sizes ) {
			// Format the 'srcset' and 'sizes' string and escape attributes.
			$attr = sprintf( ' srcset="%s"', esc_attr( $srcset ) );

			if ( is_string( $sizes ) ) {
				$attr .= sprintf( ' sizes="%s"', esc_attr( $sizes ) );
			}

			// Add 'srcset' and 'sizes' attributes to the image markup.
			$image = preg_replace( '/<img ([^>]+?)[\/ ]*>/', '<img $1' . $attr . ' />', $image );
		}

		return $image;
	}
}

if ( !function_exists( 'wp_calculate_image_srcset' ) ) {
	function wp_calculate_image_srcset( $size_array, $image_src, $image_meta, $attachment_id = 0 ) {
		if ( empty( $image_meta['sizes'] ) ) {
			return false;
		}

		$image_sizes = $image_meta['sizes'];

		// Get the width and height of the image.
		$image_width = (int) $size_array[0];
		$image_height = (int) $size_array[1];

		// Bail early if error/no width.
		if ( $image_width < 1 ) {
			return false;
		}

		$image_basename = wp_basename( $image_meta['file'] );
		$image_baseurl = _wp_upload_dir_baseurl();

		/*
		 * WordPress flattens animated GIFs into one frame when generating intermediate sizes.
		 * To avoid hiding animation in user content, if src is a full size GIF, a srcset attribute is not generated.
		 * If src is an intermediate size GIF, the full size is excluded from srcset to keep a flattened GIF from becoming animated.
		 */
		if ( ! isset( $image_sizes['thumbnail']['mime-type'] ) || 'image/gif' !== $image_sizes['thumbnail']['mime-type'] ) {
			$image_sizes['full'] = array(
				'width'  => $image_meta['width'],
				'height' => $image_meta['height'],
				'file'   => $image_basename,
			);
		} elseif ( strpos( $image_src, $image_meta['file'] ) ) {
			return false;
		}

		// Uploads are (or have been) in year/month sub-directories.
		if ( $image_basename !== $image_meta['file'] ) {
			$dirname = dirname( $image_meta['file'] );

			if ( $dirname !== '.' ) {
				$image_baseurl = trailingslashit( $image_baseurl ) . $dirname;
			}
		}

		$image_baseurl = trailingslashit( $image_baseurl );

		// Calculate the image aspect ratio.
		$image_ratio = $image_height / $image_width;

		/*
		 * Images that have been edited in WordPress after being uploaded will
		 * contain a unique hash. Look for that hash and use it later to filter
		 * out images that are leftovers from previous versions.
		 */
		$image_edited = preg_match( '/-e[0-9]{13}/', wp_basename( $image_src ), $image_edit_hash );

		/**
		 * Filter the maximum image width to be included in a 'srcset' attribute.
		 *
		 * @since 4.4.0
		 *
		 * @param int   $max_width  The maximum image width to be included in the 'srcset'. Default '1600'.
		 * @param array $size_array Array of width and height values in pixels (in that order).
		 */
		$max_srcset_image_width = apply_filters( 'max_srcset_image_width', 1600, $size_array );

		// Array to hold URL candidates.
		$sources = array();

		/*
		 * Loop through available images. Only use images that are resized
		 * versions of the same edit.
		 */
		foreach ( $image_sizes as $image ) {

			// Filter out images that are from previous edits.
			if ( $image_edited && ! strpos( $image['file'], $image_edit_hash[0] ) ) {
				continue;
			}

			// Filter out images that are wider than '$max_srcset_image_width'.
			if ( $max_srcset_image_width && $image['width'] > $max_srcset_image_width ) {
				continue;
			}

			// Calculate the new image ratio.
			if ( $image['width'] ) {
				$image_ratio_compare = $image['height'] / $image['width'];
			} else {
				$image_ratio_compare = 0;
			}

			// If the new ratio differs by less than 0.002, use it.
			if ( abs( $image_ratio - $image_ratio_compare ) < 0.002 ) {
				// Add the URL, descriptor, and value to the sources array to be returned.
				$sources[ $image['width'] ] = array(
					'url'        => $image_baseurl . $image['file'],
					'descriptor' => 'w',
					'value'      => $image['width'],
				);
			}
		}

		/**
		 * Filter an image's 'srcset' sources.
		 *
		 * @since 4.4.0
		 *
		 * @param array  $sources {
		 *     One or more arrays of source data to include in the 'srcset'.
		 *
		 *     @type array $width {
		 *         @type string $url        The URL of an image source.
		 *         @type string $descriptor The descriptor type used in the image candidate string,
		 *                                  either 'w' or 'x'.
		 *         @type int    $value      The source width if paired with a 'w' descriptor, or a
		 *                                  pixel density value if paired with an 'x' descriptor.
		 *     }
		 * }
		 * @param array  $size_array    Array of width and height values in pixels (in that order).
		 * @param string $image_src     The 'src' of the image.
		 * @param array  $image_meta    The image meta data as returned by 'wp_get_attachment_metadata()'.
	 	 * @param int    $attachment_id Image attachment ID or 0.
		 */
		$sources = apply_filters( 'wp_calculate_image_srcset', $sources, $size_array, $image_src, $image_meta, $attachment_id );

		// Only return a 'srcset' value if there is more than one source.
		if ( count( $sources ) < 2 ) {
			return false;
		}

		$srcset = '';

		foreach ( $sources as $source ) {
			$srcset .= $source['url'] . ' ' . $source['value'] . $source['descriptor'] . ', ';
		}

		return rtrim( $srcset, ', ' );
	}
}

if ( !function_exists( 'wp_calculate_image_sizes' ) ) {
	function wp_calculate_image_sizes( $size, $image_src = null, $image_meta = null, $attachment_id = 0 ) {
		$width = 0;

		if ( is_array( $size ) ) {
			$width = absint( $size[0] );
		} elseif ( is_string( $size ) ) {
			if ( ! $image_meta && $attachment_id ) {
				$image_meta = get_post_meta( $attachment_id, '_wp_attachment_metadata', true );
			}

			if ( is_array( $image_meta ) ) {
				$size_array = _wp_get_image_size_from_meta( $size, $image_meta );
				if ( $size_array ) {
					$width = absint( $size_array[0] );
				}
			}
		}

		if ( ! $width ) {
			return false;
		}

		// Setup the default 'sizes' attribute.
		$sizes = sprintf( '(max-width: %1$dpx) 100vw, %1$dpx', $width );

		/**
		 * Filter the output of 'wp_calculate_image_sizes()'.
		 *
		 * @since 4.4.0
		 *
		 * @param string       $sizes         A source size value for use in a 'sizes' attribute.
		 * @param array|string $size          Requested size. Image size or array of width and height values
		 *                                    in pixels (in that order).
		 * @param string|null  $image_src     The URL to the image file or null.
		 * @param array|null   $image_meta    The image meta data as returned by wp_get_attachment_metadata() or null.
		 * @param int          $attachment_id Image attachment ID of the original image or 0.
		 */
		return apply_filters( 'wp_calculate_image_sizes', $sizes, $size, $image_src, $image_meta, $attachment_id );
	}
}

if ( !function_exists( '_wp_upload_dir_baseurl' ) ) {
	function _wp_upload_dir_baseurl() {
		static $baseurl = array();

		$blog_id = get_current_blog_id();

		if ( empty( $baseurl[$blog_id] ) ) {
			$uploads_dir = wp_upload_dir();
			$baseurl[$blog_id] = $uploads_dir['baseurl'];
		}

		return $baseurl[$blog_id];
	}
}