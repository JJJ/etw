<?php


function csi18n( $key ) {
	return CS()->i18n( $key );
}

function e_csi18n( $key ) {
	echo csi18n( $key );
}

/**
 * Get all the Font Awesome unicode values
 * @return array Hash list of icon aliases and unicode values
 */
function fa_all_unicode() {
	return CS()->common()->getFontIcons();
}

/**
 * Returns a unicode value for a font icon
 * @param  string $key Icon to lookup
 * @return string      String containing unicode reference for the requested icon
 */
function fa_unicode( $key ) {
	return CS()->common()->getFontIcon( $key );
}


/**
 * Get an HTML entity for an icon
 * @param  string $key Icon to lookup
 * @return string      HTML entity
 */
function fa_entity( $key ) {
	return '&#x' . fa_unicode( $key ) . ';';
}

/**
 * Template function that returns a data attribute for an icon
 * @param  string $key Icon to lookup
 * @return string      Data attribute string that can be placed inside an element tag
 */
function fa_data_icon( $key ) {
	return 'data-x-icon="' . fa_unicode( $key ) . '"';
}


/**
 * Alternate for wp_localize_script that outputs a function to return the data
 * @param  string $handle          Handle for the item in WP scripts
 * @param  string $function_name   Name of the function to be added to the window object
 * @param  object $data            Object or array containing data to be converted to JSON
 * @return none
 */
function wp_script_data_function( $handle, $function_name, $data ) {

	global $wp_scripts;

	foreach ( (array) $data as $key => $value ) {
		if ( ! is_scalar( $value ) ) {
			continue;
		}

		$data[ $key ] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8' );

	}

	$script = "var $function_name=function(){ return " . wp_json_encode( $data ) . ';}';

	$data = $wp_scripts->get_data( $handle, 'data' );

	if ( ! empty( $data ) ) {
		$script = "$data\n$script";
	}

	return $wp_scripts->add_data( $handle, 'data', $script );

}

/**
 * Get a posts excerpt without the_content filters being applied
 * This is useful if you need to retreive an excerpt from within
 * a shortcode.
 * @return string Post excerpt
 */
function cs_get_raw_excerpt() {

	add_filter( 'get_the_excerpt', 'cs_trim_raw_excerpt' );
	remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );

	$excerpt = get_the_excerpt();

	add_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
	remove_filter( 'get_the_excerpt', 'cs_trim_raw_excerpt' );

	return $excerpt;
}

/**
 * Themeco customized version of the wp_trim_excerpt function in WordPress formatting.php
 * Generates an excerpt from the content, if needed.
 *
 * @param string $text Optional. The excerpt. If set to empty, an excerpt is generated.
 * @return string The excerpt.
 */
function cs_trim_raw_excerpt( $text = '' ) {

	$raw_excerpt = $text;

	if ( '' === $text ) {

		$text = get_the_content( '' );

		$text = strip_shortcodes( $text );

		//$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );

		$excerpt_length = apply_filters( 'excerpt_length', 55 );

		$excerpt_more = apply_filters( 'excerpt_more', ' [&hellip;]' );
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}

	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );

}



// Get Unitless Milliseconds
// =============================================================================
// 01. If unit is "seconds", multiply by 1000 to get millisecond value.
// 02. Fallback if we fail.

function cs_get_unitless_ms( $duration = '500ms' ) {

  $unit_matches = array();

  if ( preg_match( '/(s|ms)/', $duration, $unit_matches ) ) {

    $duration_unit = $unit_matches[0];
    $duration_num  = floatval( preg_replace( '/' . $duration_unit . '/', '', $duration ) );

    if ( $duration_unit === 's' ) {
      $duration_num = $duration_num * 1000; // 01
    }

    $the_duration = $duration_num;

  } else {

    $the_duration = 500; // 02

  }

  return $the_duration;

}



// Data Attribute Generator
// =============================================================================

function cs_generate_data_attributes( $element, $params = array() ) {
  return cs_atts( cs_element_js_atts( $element, $params ) );
}

function cs_element_js_atts( $element, $params = array() ) {

  $atts = array( 'data-x-element' => esc_attr( $element ) );

  if ( ! empty( $params ) ) {
    $atts['data-x-params'] = cs_prepare_json_att( $params );
  }

  return $atts;

}

function cs_prepare_json_att( $atts ) {
  return htmlspecialchars( wp_json_encode( $atts ), ENT_QUOTES, 'UTF-8' );
}



// Data Attribute Generator (Popovers and Tooltips)
// =============================================================================

function cs_generate_data_attributes_extra( $type, $trigger, $placement, $title = '', $content = '' ) {

	if ( ! in_array( $type, array( 'tooltip', 'popover' ), true ) ) {
		return '';
	}

	$js_params = array(
		'type'      => ( 'tooltip' === $type ) ? 'tooltip' : 'popover',
		'trigger'   => $trigger,
		'placement' => $placement,
		'title'     => htmlspecialchars_decode( $title ), // to avoid double encoding.
		'content'   => htmlspecialchars_decode( $content ),
	);

	return cs_generate_data_attributes( 'extra', $js_params );

}



// Background Video Output
// =============================================================================

function cs_bg_video( $video, $poster ) {

	$output = do_shortcode( '[x_video_player class="bg transparent" src="' . $video . '" poster="' . $poster . '" hide_controls="true" autoplay="true" loop="true" muted="true" no_container="true"]' );

	return $output;

}



// Build Shortcode
// =============================================================================

function cs_build_shortcode( $name, $attributes, $extra = '', $content = '', $require_content = false ) {

	$output = "[{$name}";

	foreach ($attributes as $attribute => $value) {
		$clean = cs_clean_shortcode_att( $value );
		$att = sanitize_key( $attribute );
		$output .= " {$att}=\"{$clean}\"";
	}

	if ( '' !== $extra ) {
		$output .= " {$extra}";
	}

	if ( '' === $content && ! $require_content ) {
		$output .= ']';
	} else {
    $content = apply_filters( 'cs_element_update_build_shortcode_content', $content, null );
		$output .= "]{$content}[/{$name}]";
	}

	return $output;

}



// Animation Base Class
// =============================================================================

function cs_animation_base_class( $animation_string ) {

	if ( false !== strpos( $animation_string, 'In' ) ) {
		$base_class = ' animated-hide';
	} else {
		$base_class = '';
	}

	return $base_class;

}

function cs_att( $attribute, $content, $echo = false ) {

	$att = '';

	if ( $content ) {
		$att = $attribute . '="' . esc_attr( $content ) . '" ';
	}

	if ( is_null( $content ) ) {
		$att = $attribute . ' ';
	}

	if ( $echo ) {
		echo $att;
	}

	return $att;

}

function cs_atts( $atts, $echo = false ) {
	$result = '';
	foreach ( $atts as $att => $content) {
		$result .= cs_att( $att, $content, false );
	}
	if ( $echo ) {
		echo $result;
	}
	return $result;
}


function cs_deep_array_merge ( array &$defaults, array $data, $max_depth = -1 ) {

	if ( 1 === $max_depth-- ) {
		return $defaults;
	}

	foreach ( $defaults as $key => &$value ) {
		if ( isset( $data[ $key ] ) && is_array( $value ) && is_array( $data[ $key ] ) ) {
			$data[ $key ] = cs_deep_array_merge( $value, $data[ $key ], $max_depth );
			continue;
		}
		$data[ $key ] = $value;
	}

	return $data;
}

function cs_alias_shortcode( $new_tag, $existing_tag, $filter_atts = true ) {

	if ( is_array( $new_tag ) ) {
		foreach ($new_tag as $tag) {
			cs_alias_shortcode( $tag, $existing_tag, $filter_atts );
		}
		return;
	}

	if ( ! shortcode_exists( $existing_tag ) ) {
		return;
	}

	global $shortcode_tags;
	add_shortcode( $new_tag, $shortcode_tags[ $existing_tag ] );

	if ( ! $filter_atts || ! has_filter( $tag = "shortcode_atts_$existing_tag" ) ) {
		return;
	}

	global $wp_filter;

	foreach ( $wp_filter[ $tag ] as $priority => $filter ) {
		foreach ($filter as $tag => $value) {
			add_filter( "shortcode_atts_$new_tag", $value['function'], $priority, $value['accepted_args'] );
		}
	}

}

function cs_array_filter_use_keys( $array, $callback ) {
	return array_intersect_key( $array, array_flip( array_filter( array_keys( $array ), $callback ) ) );
}

/**
 * Runs wp_parse_args, then applies key whitelisting based on keys from defaults
 * @param  array $args     User arguments
 * @param  array $defaults Default keys ans values
 * @return array           Arguments with defaults and key whitelisting applied.
 */
function cs_define_defaults( $args, $defaults ) {
	return array_intersect_key( wp_parse_args( $args, $defaults ), array_flip( array_keys( $defaults ) ) );
}

/**
 * Call a potentially expensive function and store the results in a transient.
 * Future calls to cs_memoize for the same function will return the cached value
 * until the transient expires. For example:
 *
 * $result = cs_memoize( 'transient_key', 'my_remote_api_request', 15 * MINUTE_IN_SECONDS, $api_key, $secret );
 *
 * This is the equivalent of: $result = my_remote_api_request( $api_key, $secret );
 * but it will only truly run once every 15 minutes. It will only persist
 * successful calls, meaning it wont set the transient if the callback
 * returns false or a WP_Error object.
 *
 * @param string   $key        Key used to set the transient
 * @param callable $function   Function to call for the original result.
 * @param int      $expiration Optional. Time until expiration in seconds. Default 0.
 * Optionally pass any additional paramaters that you would passed into the callback.
 * @return mixed    $value    Value from the original call to $function
 */
function cs_memoize( $key, $callback, $expiration = 0 ) {

	$value = get_transient( $key );

	if ( false === $value ) {

		$args = func_get_args();
		$value = call_user_func_array( $callback, array_slice( $args, 3 ) );

		if ( false !== $value && ! is_wp_error( $value ) ) {
			set_transient( $key, $value, $expiration );
		}

	}

	return $value;

}

/**
 * Sanitize a value for use in a shortcode attribute
 * @param  string $value Value to clean
 * @return string        Value ready for use in shortcode markup
 */
function cs_clean_shortcode_att( $value ) {

	$value = wp_kses( $value, wp_kses_allowed_html( 'post' ) );
	$value = esc_html( $value );
	$value = str_replace( ']', '&rsqb;', str_replace( '[', '&lsqb;', $value ) );

	return $value;
}

/**
 * Sanitizes an HTML classname to ensure it only contains valid characters.
 *
 * Uses sanitize_html_class but allows accepts multiple classes, either as
 * an array or a space delimted string.
 *
 * @param string|array $classes    The classname to be sanitized
 * @return string the sanitized value
 */
function cs_sanitize_html_classes( $classes ) {

  if ( is_string( $classes ) ) {
    $classes = explode( ' ', $classes );
  }

	array_map( 'sanitize_html_class', array_filter( $classes ) );
	$class = implode( ' ', $classes );

	return $class;
}

/**
 * WordPress wp_localize_script will cast boolean values to a string, making
 * types difficult to keep up with. This function turns them into recognizable
 * strings that can be converted back later
 * @param  array $data Data requiring boolean value preservation.
 * @return array       Data with string 'true' or 'false' values
 */
function cs_booleanize( $data ) {

	foreach ($data as $key => $value) {
		if ( is_bool( $value ) ) {
			$data[ $key ] = ( $value ) ? 'true' : 'false';
		}
	}

	return $data;

}

/**
 * Remove <p> and <br> tags added by wpautop around shortcodes.
 * This is used for anything within a Cornerstone section to keep
 * the markup clean and predictable.
 * @param  string $content Content to be cleaned
 * @return string          Cleaned content
 */
function cs_noemptyp( $content ) {

	$array = array(
		'<p>['    => '[',
		']</p>'   => ']',
		']<br />' => ']',
	);

	$content = strtr( $content, $array );

	return $content;

}


/**
 * Wrap wp_send_json_success allowing for a filterable response
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function cs_send_json_success( $data = null ) {

	$response = array( 'success' => true );

	if ( isset( $data ) ) {
		$response['data'] = $data;
	}

	wp_send_json( apply_filters( '_cornerstone_send_json_response', $response ) );

}

/**
 * Wrap wp_send_json_error allowing for a filterable response
 * @param mixed $data Data to encode as JSON, then print and die.
 */
function cs_send_json_error( $data = null ) {

	$response = array( 'success' => false );

	if ( isset( $data ) ) {
		if ( is_wp_error( $data ) ) {
			$result = array();
			foreach ( $data->errors as $code => $messages ) {
				foreach ( $messages as $message ) {
					$result[] = array( 'code' => $code, 'message' => $message );
				}
			}

			$response['data'] = $result;
		} else {
			$response['data'] = $data;
		}
	}

	wp_send_json( apply_filters( '_cornerstone_send_json_response', $response ) );

}


/**
 * Procces content through the_content filters, and strip down to just the
 * contents of paragraph tags. To finish, pass it through wp_trim_words
 * using WordPress defaults.
 * @param  string $content Content to make an excerpt for
 * @return string          Text result
 */
function cs_derive_excerpt( $content, $store = false ) {


	$the_content = apply_filters( 'the_content', $content );
	$length = apply_filters( 'excerpt_length', 55 );

	$offset = 0;
	$reduction = '';

	while ( str_word_count( $reduction ) < $length * 1.5 ) {

		preg_match( '/<p.*?>(.*?)<\/p>/', $the_content, $matches, PREG_OFFSET_CAPTURE, $offset );
		if ( empty( $matches ) || ! isset( $matches[1] )  ) {
			break;
		}

		$offset = $matches[1][1];
		$reduction .= strip_tags( $matches[1][0] ) . ' ';

	}

	if ( $store === true ) {
		return trim( $reduction );
	}

	return wp_trim_words( trim( $reduction ), $length, apply_filters( 'excerpt_more', ' [&hellip;]' ) );

}

/**
 * Allows HTML to be passed through shortcode attributes by decoding entities.
 * We apply the cs_decode_shortcode_attribute filter to allow other
 * components to process and expand directives if needed.
 * @param  string $content Original content from shortcode attribute.
 * @return string          HTML ready to use in shortcode output
 */
function cs_decode_shortcode_attribute( $content ) {
  if ( ! is_string( $content ) ) {
    return $content;
  }
	return apply_filters( 'cs_decode_shortcode_attribute', wp_specialchars_decode( $content, ENT_QUOTES ) );
}

/**
 * Accessor function for TCO
 * @return object TCO instance
 */
function cs_tco() {
	return TCO_1_0::instance();
}


function cs_update_serialized_post_meta( $post_id, $meta_key, $meta_value, $prev_value = '', $allow_revision_updates = false, $filter = '' ) {


	if ( is_array( $meta_value ) && apply_filters( 'cornerstone_store_as_json', true ) ) {
		$meta_value = wp_slash( cs_json_encode( $meta_value ) );
	}

  if ( $filter ) {
    $meta_value = apply_filters( $filter, $meta_value );
  }

  if ( $allow_revision_updates ) {
    return update_metadata('post', $post_id, $meta_key, $meta_value, $prev_value );
  }

	return update_post_meta( $post_id, $meta_key, $meta_value, $prev_value );

}


function cs_json_encode( $value ) {

  if ( defined('JSON_UNESCAPED_SLASHES') && apply_filters( 'cornerstone_json_unescaped_slashes', true ) ) {
    return wp_json_encode( $value, JSON_UNESCAPED_SLASHES );
  }

  return wp_json_encode( $value );

}

function cs_get_serialized_post_meta( $post_id, $key = '', $single = false, $filter = '' ) {
  $meta_value = get_post_meta( $post_id, $key, $single );
  if ( $filter ) {
    $meta_value = apply_filters( $filter, $meta_value );
  }
  return cs_maybe_json_decode( $meta_value );
}

function cs_maybe_json_decode( $value ) {
	if ( is_string( $value ) ) {
		$value = json_decode( $value, true );
	}
	return $value;
}

function cs_error( $data, $throw = false ) {
  return new Cornerstone_Error( $data, $throw );
}

function is_cs_error( $error ) {
  return is_a( $error, 'Cornerstone_Error' );
}

function cs_to_component_name( $name ) {
  return str_replace( ' ', '_', ucwords( strtolower( preg_replace('/[-_:\/]/', ' ', str_replace(' ', '', $name ) ) ) ) );
}

function cs_debug( $message ) {
  CS()->loadComponent('Debug')->add_message($message);
}

function cs_set_curl_timeout_begin( $timeout ) {
  CS()->loadComponent('Networking')->set_curl_timeout_begin( $timeout );
}

function cs_set_curl_timeout_end() {
  CS()->loadComponent('Networking')->set_curl_timeout_end();
}
