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

namespace WooCommerce\Square\Emails;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * Sync completed email.
 *
 * @since 2.0.0
 */
class Sync_Completed extends \WC_Email {


	/** @var string email body */
	protected $body;


	/**
	 * Email constructor.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// set properties
		$this->id             = 'wc_square_sync_completed';
		$this->title          = __( 'Square sync completed', 'woocommerce-square' );
		$this->description    = __( 'This email is sent once a manual sync has been completed between WooCommerce and Square', 'woocommerce-square' );
		$this->subject        = _x( '[WooCommerce] Square sync completed', 'Email subject', 'woocommerce-square');
		$this->heading        = _x( 'Square sync completed for {product_count}', 'Email heading with merge tag placeholder', 'woocommerce-square');
		$this->body           = _x( 'Square sync completed for {site_title} at {sync_completed_date} {sync_completed_time}.', 'Email body with merge tag placeholders', 'woocommerce-square' );
		$this->template_html  = 'emails/square-sync-completed.php';
		$this->template_plain = 'emails/plain/square-sync-completed.php';
		$this->template_base  = wc_square()->get_plugin_path() . '/templates/';

		// call parent constructor
		parent::__construct();

		// set default recipient
		$this->recipient = $this->get_option( 'recipient', get_option( 'admin_email' ) );
	}


	/**
	 * Initializes the email settings form fields.
	 *
	 * Extends and overrides parent method.
	 *
	 * @since 2.0.0
	 */
	public function init_form_fields() {

		// initialize the default fields from parent email object
		parent::init_form_fields();

		$form_fields = $this->form_fields;

		// set email disabled by default
		if ( isset( $form_fields['enabled'] ) ) {
			$form_fields['enabled']['default'] = 'no';
		}

		// the email has no customizable body or heading via input field
		unset( $form_fields['body'], $form_fields['heading'] );

		// adjust email subject field
		if ( isset( $form_fields['subject'] ) ) {
			/* translators: Placeholder: %s - default email subject text */
			$form_fields['subject']['description'] = sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: %s', 'woocommerce-square' ), '<code>' . $this->get_default_subject() . '</code>' );
			$form_fields['subject']['desc_tip']    = false;
			$form_fields['subject']['default']     = $this->subject;
		}

		// add a recipient field
		$form_fields = Framework\SV_WC_Helper::array_insert_after( $form_fields, isset( $form_fields['enabled'] ) ? 'enabled' : key( $form_fields ), [
			'recipient' => [
				'title'         => __( 'Recipient(s)', 'woocommerce-square' ),
				'type'          => 'text',
				/* translators: Placeholder: %s default email address */
				'description'   => sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to admin email: %s', 'woocommerce-square' ), '<code>' . esc_attr( get_option( 'admin_email' ) ) . '</code>' ),
				'placeholder'   => get_bloginfo( 'admin_email' ),
				'default'       => get_bloginfo( 'admin_email' ),
			],
		] );

		// set the updated fields
		$this->form_fields = $form_fields;
	}


	/**
	 * Gets the email heading, adjusted by sync job result status.
	 *
	 * @since 2.0.0
	 *
	 * @param string $status sync job status
	 * @return string
	 */
	private function get_heading_by_job_status( $status ) {

		if ( 'failed' === $status ) {
			$email_heading = esc_html__( 'Square sync failed', 'woocommerce-square' );
		} else {
			$email_heading = parent::get_default_heading();
		}

		/** @see Sync_Completed::get_heading() for filter documentation */
		return apply_filters( 'woocommerce_email_heading_' . $this->id, $this->format_string( $email_heading ), $this->object );
	}


	/**
	 * Gets the default email subject.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_default_subject() {

		return $this->subject;
	}


	/**
	 * Gets the email body.
	 *
	 * @since 2.0.0
	 *
	 * @return string may contain HTML
	 */
	protected function get_default_body() {

		return $this->body;
	}


	/**
	 * Gets the email body.
	 *
	 * @since 2.0.0
	 *
	 * @return string may contain HTML
	 */
	protected function get_body() {

		$email_body = $this->get_default_body();

		/**
		 * Filters the sync completed email body.
		 *
		 * @since 2.0.0
		 *
		 * @param string $email_body the email body
		 * @param Sync_Completed $email the email object
		 */
		return $this->format_string( (string) apply_filters( "{$this->id}_body", $email_body, $this ) );
	}


	/**
	 * Gets the email body adjusted by sync job result status.
	 *
	 * @since 2.0.0
	 *
	 * @param string $status sync job status
	 * @param bool $html whether output should be HTML (true) or plain text (false)
	 * @return string may contain HTML
	 */
	private function get_body_by_job_status( $status, $html ) {

		$email_body = $this->get_default_body();

		if ( 'failed' === $status ) {

			if ( true === $html ) {

				$square       = wc_square();
				$settings_url = $square->get_settings_url();
				$records_url  = add_query_arg( [ 'section' => 'update' ], $settings_url );

				if ( $square->get_settings_handler()->is_debug_enabled() ) {
					$action = sprintf(
						/* translators: Placeholders: %1$s - opening <a> HTML link tag, %2$s - closing </a> HTML link tag */
						esc_html__( '%1$sInspect status logs%2$s', 'woocommerce-square' ),
						'<a href="' . esc_url( admin_url( 'admin.php?page=wc-status&tab=logs' ) ) . '">', '</a>'
					);
				} else {
					$action = sprintf(
						/* translators: Placeholders: %1$s - opening <a> HTML link tag, %2$s - closing </a> HTML link tag */
						esc_html__( '%1$sEnable logging%2$s', 'woocommerce-square' ),
						'<a href="' . esc_url( $settings_url ) .'">', '</a>'
					);
				}

				$email_body .= sprintf(
					/* translators: Placeholders: %1$s - opening <a> HTML link tag, %2$s - closing </a> HTML link tag, %3$s - additional action */
					'<br>' . esc_html__( 'The sync job has failed. %1$sClick for more details%2$s, or %3$s.', 'woocommerce-square' ),
					'<a href="' . esc_url( $records_url ) .'">', '</a>',
					strtolower( $action )
				);

			} else { // plain text

				if (  wc_square()->get_settings_handler()->is_debug_enabled() ) {
					$action = esc_html__( 'Inspect status logs', 'woocommerce-square' );
				} else {
					$action = esc_html__( 'Enable Logging', 'woocommerce-square' );
				}

				$email_body .= sprintf(
					/* translators: Placeholders: %s - additional action */
					esc_html__( 'The sync job has failed. Check sync records, or %s.', 'woocommerce-square' ),
					strtolower( $action )
				);
			}
		}

		/** @see Sync_Completed::get_body() for filter documentation */
		return $this->format_string( (string) apply_filters( "{$this->id}_body", $email_body, $this ) );
	}


	/**
	 * Gets the email's related sync job, if set.
	 *
	 * @since 2.0.0
	 *
	 * @return \stdClass|null
	 */
	private function get_job() {

		return $this->object && is_object( $this->object ) ? $this->object : null;
	}


	/**
	 * Determines if it's a customer email.
	 *
	 * @since 2.0.0
	 *
	 * @return false overrides parent method to always return false
	 */
	public function is_customer_email() {

		return false;
	}


	/**
	 * Determines if the email has valid recipients.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	protected function has_recipients() {

		return ! empty( $this->get_recipient() );
	}


	/**
	 * Triggers the email.
	 *
	 * @since 2.0.0
	 *
	 * @param string|object|\stdClass $job a sync job object or ID
	 */
	public function trigger( $job ) {

		if ( $this->is_enabled() && $this->has_recipients() ) {

			if ( is_string( $job ) || is_numeric( $job ) ) {
				$job = wc_square()->get_background_job_handler()->get_job( $job );
			}

			if ( $job && is_object( $job ) && isset( $job->manual, $job->status ) && $job->manual && 'completed' === $job->status ) {

				$this->object = $job;

				$this->parse_merge_tags();

				$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
			}
		}
	}


	/**
	 * Parses the email's body merge tags.
	 *
	 * @since 2.0.0
	 */
	protected function parse_merge_tags() {

		$job = $this->get_job();

		if ( ! $job ) {
			return;
		}

		$product_count = is_array( $job->processed_product_ids ) ? count( $job->processed_product_ids ) : absint( $job->processed_product_ids );
		/* translators: Placeholder: %d products count */
		$product_count = sprintf( _n( '%d product', '%d products', $product_count, 'woocommerce-square' ), $product_count );

		// placeholders
		$email_merge_tags = [
			'product_count'       => $product_count,
			'sync_started_date'   => isset( $job->started_at )   ? date( wc_date_format(), strtotime( $job->started_at ) )   : '',
			'sync_started_time'   => isset( $job->started_at )   ? date( wc_time_format(), strtotime( $job->started_at ) )   : '',
			'sync_completed_date' => isset( $job->completed_at ) ? date( wc_date_format(), strtotime( $job->completed_at ) ) : '',
			'sync_completed_time' => isset( $job->completed_at ) ? date( wc_time_format(), strtotime( $job->completed_at ) ) : '',
		];

		// TODO update handling when WooCommerce 3.2 is the minimum required version {FN 2019-05-03}
		if ( Framework\SV_WC_Plugin_Compatibility::is_wc_version_gte( '3.2' ) ) {

			foreach ( $email_merge_tags as $find => $replace ) {
				$this->placeholders[ '{' . $find . '}' ] = $replace;
			}

		} else {

			foreach ( $email_merge_tags as $find => $replace ) {
				$this->find[ $find ]    = '{' . $find . '}';
				$this->replace[ $find ] = $replace;
			}
		}
	}


	/**
	 * Gets the arguments that should be passed to an email template.
	 *
	 * @since 2.0.0
	 *
	 * @param array $args optional associative array with additional arguments
	 * @return array
	 */
	protected function get_template_args( $args = [] ) {

		$sync_job = $this->get_job();
		$html     = empty( $args['plain_text'] );

		if ( $sync_job && isset( $sync_job->status ) && 'failed' === $sync_job->status ) {
			$email_heading = $this->get_heading_by_job_status( 'failed' );
			$email_body    = $this->get_body_by_job_status( 'failed', $html );
		} else {
			$email_heading = $this->get_heading_by_job_status( 'completed' );
			$email_body    = $this->get_body_by_job_status( 'completed', $html );
		}

		return array_merge( $args, [
			'email'         => $this,
			'email_heading' => $email_heading,
			'email_body'    => $email_body,
			'sync_job'      => $sync_job,
		] );
	}


	/**
	 * Gets the email HTML content.
	 *
	 * @since 2.0.0
	 *
	 * @return string HTML
	 */
	public function get_content_html() {

		$args = [ 'plain_text' => false ];

		ob_start();

		wc_get_template( $this->template_html, array_merge( $args, $this->get_template_args( $args ) ) );

		return ob_get_clean();
	}


	/**
	 * Gets the email plain text content.
	 *
	 * @since 2.0.0
	 *
	 * @return string plain text
	 */
	public function get_content_plain() {

		$args = [ 'plain_text' => true ];

		ob_start();

		wc_get_template( $this->template_html, array_merge( $args, $this->get_template_args( $args ) ) );

		return ob_get_clean();
	}


}
