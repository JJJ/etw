<?php

class Cornerstone_Admin_Notice {

	protected $class;
	protected $message;
	protected $dissmissable;
	protected $hook_priority;
	protected static $notices;

	public function __construct( $class = '', $message = '', $dissmissable = false ) {
		$this->class = $class;
		$this->message = $message;
		$this->dissmissable = $dissmissable;
	}

	public function get_notice() {

		if ( empty( $this->message ) ) {
			return '';
		}

		$classes = explode( ' ', $this->class );
		array_map( 'sanitize_html_class', $classes );

		$classes[] = 'notice';

		if ( $this->dissmissable ) {
			$classes[] = 'is-dismissible';
		}

		$class = implode( ' ', $classes );

		return sprintf( '<div class="%s"><p>%s</p></div>', $class, $this->message );

	}

	public function the_notice() {
		echo $this->get_notice();
	}

	public function conditional_notice() {

		if ( ! is_callable( $callback ) || ! call_user_func( $this->callback ) ) {
			return;
		}

		$this->the_notice();

	}

	public function hook( $hook_priority = 20, $callback = false ) {

		if ( did_action( 'admin_notices' ) ) {
			return false;
		}

		$this->hook_priority = $hook_priority;
		$method = 'the_notice';

		if ( $callback ) {
			$this->callback = $callback;
			$method = 'conditional_notice';
		}

		add_action( 'admin_notices', array( $this, $method ), $this->hook_priority );

	}

	public function unhook() {
		if ( ! isset( $this->hook_priority ) ) {
			return;
		}
		remove_action( 'admin_notices', array( $this, 'the_notice' ), $this->hook_priority );
	}

	public static function add( $class, $message, $dissmissable = false, $priority = 20 ) {
		$notice = new self( $class, $message, $dissmissable );
		$notice->hook( $priority );
		return $notice;
	}

	public static function updated( $message, $dissmissable = false, $priority = 20 ) {
		return self::add( 'updated', $message, $dissmissable, $priority );
	}

	public static function error( $message, $dissmissable = false, $priority = 20 ) {
		return self::add( 'error', $message, $dissmissable, $priority );
	}

	public static function nag( $message, $dissmissable = false, $priority = 20 ) {
		return self::add( 'update-nag', $message, $dissmissable, $priority );
	}

}
