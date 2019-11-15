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

namespace WooCommerce\Square\Sync;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * Stepped Job abstract.
 *
 * Adds multi-step management to the job class.
 *
 * @since 2.0.0
 */
abstract class Stepped_Job extends Job {


	/**
	 * Executes the next step of this job.
	 *
	 * @since 2.0.0
	 *
	 * @return \stdClass the job object
	 */
	public function run() {

		parent::run();

		if ( empty( $this->get_attr( 'next_steps' ) ) && empty( $this->get_attr( 'completed_steps' ) ) ) {
			$this->assign_next_steps();
		}

		$this->do_next_step();

		return $this->job;
	}


	/**
	 * Assigns the next steps needed for this sync job.
	 *
	 * Adds the next steps to the 'next_steps' attribute.
	 *
	 * @since 2.0.0
	 */
	abstract protected function assign_next_steps();


	/**
	 * Gets the next step in the sync process.
	 *
	 * @since 2.0.0
	 *
	 * @return string|null
	 */
	protected function get_next_step() {

		$next_steps = $this->get_next_steps();

		return isset( $next_steps[0] ) ? $next_steps[0] : null;
	}


	/**
	 * Gets the next steps for the sync process.
	 *
	 * @since 2.0.0
	 *
	 * @return string[]
	 */
	protected function get_next_steps() {

		return $this->get_attr( 'next_steps' );
	}


	/**
	 * Performs the next step in the sync process.
	 *
	 * @since 2.0.0
	 */
	protected function do_next_step() {

		$next_step = $this->get_next_step();

		if ( is_callable( [ $this, $next_step ] ) ) {

			$this->start_step_cycle( $next_step );

			try {

				$this->$next_step();
				$this->complete_step_cycle( $next_step );

			} catch ( Framework\SV_WC_Plugin_Exception $exception ) {

				$this->complete_step_cycle( $next_step, false, $exception->getMessage() );
				$this->fail( $exception->getMessage() );
				return;
			}
		}

		if ( ! $this->get_next_step() ) {

			$this->complete();
		}
	}


	/**
	 * Records the beginning of a new step cycle, meaning a new loop on the job for a given step.
	 *
	 * @since 2.0.0
	 *
	 * @param string $step_name the step name
	 */
	protected function start_step_cycle( $step_name ) {

		$current_step_cycle = [
			'step_name'  => $step_name,
			'start_time' => microtime( true ),
		];

		wc_square()->log( "Starting step cycle: $step_name" );

		$this->set_attr( 'current_step_cycle', $current_step_cycle );
	}


	/**
	 * Records the completion of a step cycle.
	 *
	 * @since 2.0.0
	 *
	 * @param string $step_name the step name
	 * @param bool $is_successful (optional) whether the step completion is from a success or not
	 * @param string $error_message (optional) error message to include with failed step log
	 */
	protected function complete_step_cycle( $step_name, $is_successful = true, $error_message = '' ) {

		$current_step_cycle = $this->get_attr( 'current_step_cycle', [] );

		if ( ! empty( $current_step_cycle ) ) {

			$current_step_cycle['end_time'] = microtime( true );
			$current_step_cycle['runtime']  = number_format( $current_step_cycle['end_time'] - $current_step_cycle['start_time'], 2 ) . 's';
			$current_step_cycle['success']  = true === $is_successful;

			if ( true === $is_successful ) {

				wc_square()->log( "Completed step cycle: $step_name (${current_step_cycle['runtime']})" );

			} else {

				wc_square()->log( "Failed step cycle: $step_name (${current_step_cycle['runtime']}) - $error_message" );
			}

			$completed_cycles   = $this->get_attr( 'completed_step_cycles', [] );
			$completed_cycles[] = $current_step_cycle;
			$this->set_attr( 'completed_step_cycles', $completed_cycles );
		}
	}


	/**
	 * Completes the specified step (if it's the next step).
	 *
	 * @since 2.0.0
	 *
	 * @param string $step_name
	 */
	protected function complete_step( $step_name ) {

		$next_steps = $this->get_next_steps();

		if ( isset( $next_steps[0] ) && $step_name === $next_steps[0] ) {

			$this->add_completed_step( $step_name );
			array_shift( $next_steps );
			$this->set_attr( 'next_steps', $next_steps );
		}
	}


	/**
	 * Adds a step to the completed steps array.
	 *
	 * @since 2.0.0
	 *
	 * @param string $step_name
	 */
	protected function add_completed_step( $step_name ) {

		if ( empty( $step_name ) ) {
			return;
		}

		$completed_steps = $this->get_attr( 'completed_steps', [] );

		$completed_steps[] = [
			'name'            => $step_name,
			'completion_time' => current_time( 'mysql' ),
		];

		$this->set_attr( 'completed_steps', $completed_steps );

		wc_square()->log( 'Completed job step: ' . $step_name );
	}


}
