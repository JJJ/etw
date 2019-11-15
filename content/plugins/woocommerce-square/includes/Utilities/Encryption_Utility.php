<?php
/**
 * WooCommerce Square
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@woocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Square to newer
 * versions in the future. If you wish to customize WooCommerce Square for your
 * needs please refer to https://docs.woocommerce.com/document/woocommerce-square/
 *
 * @author    WooCommerce
 * @copyright Copyright: (c) 2019, Automattic, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace WooCommerce\Square\Utilities;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

/**
 * The encryption utility class.
 *
 * Requires OpenSSL by default.
 *
 * @since 2.0.0
 */
class Encryption_Utility {


	/** @var string default cipher method */
	protected $default_cipher_method = 'AES-128-CBC';

	/** @var string cipher method */
	protected $cipher_method;


	/**
	 * Constructs the class.
	 *
	 * @param string $preferred_cipher_method cipher method
	 */
	public function __construct( $preferred_cipher_method = '' ) {

		// bail entirely if openssl isn't available
		if ( ! self::is_encryption_supported() ) {
			wc_doing_it_wrong( __CLASS__, __( 'Encryption is not supported on this site.', 'woocommerce-square' ), Framework\SV_WC_Plugin::VERSION );
			return;
		}

		$this->cipher_method = $this->get_default_cipher_method();

		// if a preferred cipher method is set, check and set it
		if ( is_string( $preferred_cipher_method ) && ! empty( $preferred_cipher_method ) ) {

			// only use what's preferred if it's supported
			if ( $this->is_cipher_method_supported( $preferred_cipher_method ) ) {

				$this->cipher_method = $preferred_cipher_method;

			// otherwise, throw a notice and continue with the default
			} else {

				$message = sprintf(
					__( '%1$s encryption is not available on this site. %2$s will be used instead.', 'woocommerce-square' ),
					$preferred_cipher_method,
					$this->cipher_method
				);

				wc_doing_it_wrong( __CLASS__, $message, Framework\SV_WC_Plugin::VERSION );
			}
		}
	}


	/**
	 * Encrypts data.
	 *
	 * @since 2.0.0
	 *
	 * @param string|array $data data to encrypt
	 * @param string $key encryption key
	 * @return string
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public function encrypt_data( $data, $key = '' ) {

		// sanity check to ensure encryption can happen
		if ( ! $this->get_cipher_method() ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'No encryption method available', 'woocommerce-square' ) );
		}

		if ( empty( $data ) || ( ! is_string( $data ) && ! is_array( $data ) ) ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Data must be a non-empty string or array', 'woocommerce-square' ) );
		}

		if ( ! is_string( $key ) ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Encryption key must be a string', 'woocommerce-square' ) );
		}

		// default to the WP salt
		if ( empty( $key ) ) {
			$key = $this->get_default_key();
		}

		$vector = openssl_random_pseudo_bytes( $this->get_vector_length(), $crypto_strong );

		// bail if a strong vector wasn't generated
		if ( false === $vector || false === $crypto_strong ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Could not generate encryption vector.', 'woocommerce-square' ) );
		}

		$encrypted_data = openssl_encrypt( json_encode( $data ), $this->get_cipher_method(), $key, 0, $vector );

		return base64_encode( $vector . $encrypted_data );
	}


	/**
	 * Decrypts data.
	 *
	 * @since 2.0.0
	 *
	 * @param string $data data to decrypt
	 * @param string $key decryption key
	 * @return string|array
	 * @throws Framework\SV_WC_Plugin_Exception
	 */
	public function decrypt_data( $data, $key = '' ) {

		// sanity check to ensure decryption can happen
		if ( ! $this->get_cipher_method() ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'No decryption method available', 'woocommerce-square' ) );
		}

		if ( empty( $data ) || ! is_string( $data ) ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Data must be a non-empty string', 'woocommerce-square' ) );
		}

		if ( ! is_string( $key ) ) {
			throw new Framework\SV_WC_Plugin_Exception( __( 'Encryption key must be a string', 'woocommerce-square' ) );
		}

		// default to the WP salt
		if ( empty( $key ) ) {
			$key = $this->get_default_key();
		}

		$data = base64_decode( $data );

		$vector_length = $this->get_vector_length();
		$vector        = substr( $data, 0, $vector_length );
		$data          = substr( $data, $vector_length );
		$data          = openssl_decrypt( $data, $this->get_cipher_method(), $key, 0, $vector );

		return json_decode( $data, true );
	}


	/**
	 * Gets the vector length.
	 *
	 * @since 2.0.0
	 *
	 * @return int
	 */
	protected function get_vector_length() {

		return openssl_cipher_iv_length( $this->get_cipher_method() );
	}


	/**
	 * Determines if a cipher method is supported by the server.
	 *
	 * @since 2.0.0
	 *
	 * @param string $method cipher method to check
	 * @return bool
	 */
	protected function is_cipher_method_supported( $method ) {

		return in_array( $method, $this->get_supported_cipher_methods(), true );
	}


	/**
	 * Determines if encryption is supported at all.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public static function is_encryption_supported() {

		return extension_loaded( 'openssl' );
	}


	/**
	 * Gets the cipher method.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_cipher_method() {

		return $this->cipher_method;
	}


	/**
	 * Gets the default cipher method.
	 *
	 * Checks the list of supported methods first, and if the default isn't supported, uses the first available.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_default_cipher_method() {

		$available_methods = $this->get_supported_cipher_methods();

		return in_array( $this->default_cipher_method, $available_methods, true ) ? $this->default_cipher_method : $available_methods[0];
	}


	/**
	 * Gets the supported cipher methods.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_supported_cipher_methods() {

		return openssl_get_cipher_methods();
	}


	/**
	 * Gets the default encryption key.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	protected function get_default_key() {

		return md5( wp_salt(), true );
	}


}
