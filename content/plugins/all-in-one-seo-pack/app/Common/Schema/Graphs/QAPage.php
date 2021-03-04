<?php
namespace AIOSEO\Plugin\Common\Schema\Graphs;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * QAPage graph class.
 *
 * @since 4.0.0
 */
class QAPage extends WebPage {

	/**
	 * The graph type.
	 *
	 * @since 4.0.0
	 *
	 * @var string
	 */
	protected $type = 'QAPage';
}