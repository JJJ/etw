<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Panels_Settings
 *
 * Define settings for the Panels Builder section.
 *
 * @since 1.6.0.
 * @since 1.7.0. Changed class name from TTFMP_Panels_Settings.
 */
final class MAKEPLUS_Component_Panels_Settings implements MAKEPLUS_Component_Panels_SettingsInterface {
	/**
	 * Defines the settings for Panels.
	 *
	 * Can return the entire definition array, or a simpler array of each setting
	 * with one specific property.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $property    The property to return, or all properties.
	 *
	 * @return array                  The array of settings and properties.
	 */
	public function get_settings( $property = 'all' ) {
		$settings = array(
			'title' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_title' ),
			),
			'label' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_title' ),
			),
			'mode' => array(
				'default' => 'accordion',
				'sanitize' => 'ttfmake_sanitize_section_choice',
			),
			'height-style' => array(
				'default' => 'content',
				'sanitize' => 'ttfmake_sanitize_section_choice',
			),
			'background-image' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_image_id' ),
			),
			'background-image-darken' => array(
				'default' => 0,
				'sanitize' => 'absint',
			),
			'background-image-style' => array(
				'default' => 'tile',
				'sanitize' => 'ttfmake_sanitize_section_choice',
			),
			'background-color' => array(
				'default' => '',
				'sanitize' => 'maybe_hash_hex_color',
			),
			'item-order' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_order' ),
			),
			'item-title' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_title' ),
			),
			'item-content' => array(
				'default' => '',
				'sanitize' => array( $this, 'sanitize_content' ),
			),
		);

		// Return everything.
		if ( 'all' === $property ) {
			return $settings;
		}

		$setting_ids = array_keys( $settings );
		$properties = wp_list_pluck( $settings, $property );

		// Return a specific setting property.
		if ( ! empty( $properties ) ) {
			return array_combine( $setting_ids, $properties );
		} else {
			return array();
		}
	}

	/**
	 * Sanitize the value of a setting using it's defined callback.
	 *
	 * @since 1.6.0.
	 *
	 * @param mixed  $value
	 * @param string $setting_id
	 *
	 * @return mixed|null
	 */
	public function sanitize_value( $value, $setting_id ) {
		$callbacks = $this->get_settings( 'sanitize' );
		$sanitized_value = null;

		if ( isset( $callbacks[ $setting_id ] ) ) {
			$callback = $callbacks[ $setting_id ];
			if ( $callback && is_callable( $callback ) ) {
				$sanitized_value = call_user_func_array( $callback, (array) $value );
			}
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize a comma separated list of section IDs. Return an array.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $str    The comma separated list of IDs.
	 *
	 * @return array         The array of sanitized IDs.
	 */
	private function sanitize_order( $str ) {
		return array_map( array( 'TTFMAKE_Builder_Save', 'clean_section_id' ), explode( ',', $str ) );
	}

	/**
	 * Sanitize a title string.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $title    The title string.
	 *
	 * @return string          The sanitized title string.
	 */
	private function sanitize_title( $title ) {
		return apply_filters( 'title_save_pre', $title );
	}

	/**
	 * Sanitize an image ID that might be either an array or a string.
	 *
	 * @since 1.6.0.
	 *
	 * @param string|array $image    The variable containing the image ID.
	 *
	 * @return int|string            The sanitized image ID.
	 */
	private function sanitize_image_id( $image ) {
		$image_id = 0;

		if ( is_array( $image ) ) {
			$image_id = ttfmake_sanitize_image_id( $image['image-id'] );
		} else {
			$image_id = ttfmake_sanitize_image_id( $image );
		}

		return $image_id;
	}

	/**
	 * Sanitize a chunk of content as if it were intended for the post_content field.
	 *
	 * @since 1.6.0.
	 *
	 * @param string $content    The chunk of content.
	 *
	 * @return string            The sanitized chunk of content.
	 */
	private function sanitize_content( $content ) {
		$post_id = ( get_post() ) ? get_the_ID() : 0;
		return sanitize_post_field( 'post_content', $content, $post_id, 'db' );
	}
}