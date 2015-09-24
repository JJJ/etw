<?php

WP_CLI::add_command('session', 'WP_Session_Manager_CLI');

class WP_Session_Manager_CLI extends WP_CLI_Command {

	var $ip = array(
		'196.6.34.249',
		'47.100.21.250',
		'145.181.76.111',
		'94.56.217.114',
		'126.74.172.210',
		'83.169.113.33',
		'72.92.155.240',
		'167.23.44.109',
		'28.78.104.74',
		'178.124.70.68',
		'51.145.179.144',
		'200.142.4.72',

	);

	var $ua = array(
		"Mozilla/4.0 (compatible; MSIE 9.0; Windows NT 5.1; Trident/5.0)",
		"Mozilla/4.0 (compatible; MSIE 9.0; Windows 98; .NET CLR 3.0.04506.30)",
		"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; yie8)",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:21.0) Gecko/20100101 Firefox/21.0",
		"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:18.0) Gecko/20100101 Firefox/18.0",
		"Mozilla/5.0 (X11; Ubuntu; Linux armv7l; rv:17.0) Gecko/20100101 Firefox/17.0",
		"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27",
		"Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_5_8; zh-cn) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27",
		"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; ja-jp) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27",
		"Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.21 (KHTML, like Gecko) Chrome/19.0.1041.0 Safari/535.21",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_3) AppleWebKit/535.20 (KHTML, like Gecko) Chrome/19.0.1036.7 Safari/535.20",
		"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/18.6.872.0 Safari/535.2 UNTRUSTED/1.0 3gpp-gba UNTRUSTED/1.0",
		"Mozilla/5.0 (Macintosh; AMD Mac OS X 10_8_2) AppleWebKit/535.22 (KHTML, like Gecko) Chrome/18.6.872",
		"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.17 Safari/537.36",
		"Mozilla/5.0 (X11; CrOS i686 4319.74.0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.57 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.2 Safari/537.36",
		"Opera/12.0(Windows NT 5.1;U;en)Presto/22.9.168 Version/12.00",
		"Opera/9.80 (Windows NT 6.0; U; pl) Presto/2.10.229 Version/11.62",
		// Mobile
		"Mozilla/5.0 (Linux; U; Android 4.0.3; ko-kr; LG-L160L Build/IML74K) AppleWebkit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
		"Mozilla/5.0 (Linux; U; Android 4.0.3; de-ch; HTC Sensation Build/IML74K) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30",
		"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; zh-TW) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+",
		"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; tr) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.246 Mobile Safari/534.1+",
		"Opera/9.80 (J2ME/MIDP; Opera Mini/9.80 (J2ME/23.377; U; en) Presto/2.5.25 Version/10.54",
		"Mozilla/5.0 (iPhone; U; CPU iPhone OS 5_1_1 like Mac OS X; en) AppleWebKit/534.46.0 (KHTML, like Gecko) CriOS/19.0.1084.60 Mobile/9B206 Safari/7534.48.3",
		"Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A543 Safari/419.3",
		"Mozilla/5.0 (Linux; Android 4.4; Nexus 5 Build/_BuildID_) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36",


	);

	var $seen = array(
		'-1 day',
		'-4 hours',
		'-8 minutes',
		'-18 minutes',
		'now',
		'-1 week 1 day 3 hours',
		'-1 week 2 days',
		'-2 days 8 hours',
		'-2 days'
	);

	var $expires = array(
		'+1 day',
		'+4 hours',
		'+8 minutes',
		'+1 week',
		'+2 days'
	);

	function seed( $args, $assoc_args ){
		require_once( ABSPATH . WPINC . '/session.php' );
		add_filter( 'attach_session_information',      array( $this, '_filter_collected_session_info' ), 20 );

		$count = isset( $assoc_args['count'] ) ? (int) $assoc_args['count'] : null;

		if ( isset( $assoc_args['user_id'])  ){
			$user = get_user_by( 'id', $assoc_args['user_id'] );
			$this->make_alot_of_sessions( $user, $count );
		} else {
			$users = get_users( );

			foreach( $users as $user ) {
				$this->make_alot_of_sessions( $user, $count );
			}
		}

	}

	/**
	 * @subcommand reset
	 */

	function reset_sessions( $args, $assoc_args ){
		require_once( ABSPATH . WPINC . '/session.php' );

		if ( isset( $assoc_args['user_id'])  ){
			$user = get_user_by( 'id', $assoc_args['user_id'] );
			$this->destroy_sessions( $user );
		} else {
			$users = get_users( );

			foreach( $users as $user ) {
				$this->destroy_sessions( $user );
			}
		}
	}

	function destroy_sessions( $user ) {
		$manager = WP_User_Meta_Session_Tokens::get_instance( $user->ID );	
		$manager->destroy_all();
		WP_CLI::line( 'Destroyed all sessions for user ' . $user->ID );

	}
	function make_alot_of_sessions( $user, $count = null ){
		$i = 0;
		if ( null === $count ){
			$count = rand(0,3);
		}
		if ( 0 === $count ){
			return;
		}

		while ( $i < $count ) {
			$manager = WP_User_Meta_Session_Tokens::get_instance( $user->ID );	
			$expiration = strtotime( $this->expires[ array_rand( $this->expires ) ] );
			$manager->create( $expiration );	

			$i++;
			
			WP_CLI::line( 'Session ' . $i . ' added for user ' . $user->ID );
		}
	}

	function _filter_collected_session_info( $info ) {
		$info['ip']   = $this->ip[ array_rand( $this->ip ) ];
		$info['ua']   = $this->ua[ array_rand( $this->ua ) ];

		$info['seen'] = strtotime( $this->seen[ array_rand( $this->seen ) ] );
		$info['login'] = strtotime( $this->seen[ array_rand( $this->seen ) ] );

		return $info;
	}

}

?>
