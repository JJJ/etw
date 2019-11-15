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

defined( 'ABSPATH' ) or exit;

/**
 * Square sync completed email template.
 *
 * @type string $email_heading email heading
 * @type string $email_body email body (may contain HTML)
 * @type \WooCommerce\Square\Emails\Sync_Completed $email email object
 * @type \stdClass $sync_job background job object
 *
 * @version 2.0.0
 * @since 2.0.0
 */

do_action( 'woocommerce_email_header', $email_heading, $email );

echo wpautop( wptexturize( $email_body ) );

do_action( 'woocommerce_email_footer', $email );
