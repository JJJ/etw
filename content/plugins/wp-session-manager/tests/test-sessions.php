<?php

class Test_WP_Session_Manager extends WP_UnitTestCase {

	public $wpdm   = null;
	public $user   = null;
	public $tokens = array();

	function setUp() {

		parent::setUp();

		$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

		$this->user    = $this->factory->user->create_and_get();
		$this->manager = WP_Session_Tokens::get_instance( $this->user->ID );
		$this->wpsm    = WP_Session_Manager::init();

		$expire  = strtotime( '+1 day' );

		// Add some sessions for the user:
		for ( $i = 0; $i <= 3; $i++ ) {
			$this->tokens[$i] = $this->manager->create( $expire );
		}

	}

	function testMultipleSessionsAreDestroyed() {

		// Destroy all but the second session:
		$this->wpsm->destroy_multiple_sessions( $this->user, $this->tokens[1] );

		// Test the session destruction:
		$this->assertEquals( array(
			$this->manager->get( $this->tokens[1] ),
		), $this->manager->get_all() );

	}

	function testAllSessionsAreDestroyed() {

		// Destroy all sessions:
		$this->wpsm->destroy_multiple_sessions( $this->user );

		// Test the session destruction:
		$this->assertEquals( array(), $this->manager->get_all() );

	}

}
