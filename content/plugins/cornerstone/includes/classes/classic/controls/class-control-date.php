<?php
class Cornerstone_Control_Date extends Cornerstone_Control {

	protected $default_options = array(
		'choose_format' => true,
		'default_format'   => 'Do MMMM YYYY',
		'available_formats' => array(

			'Do MMMM YYYY',
			'MMMM Do YYYY',
			'MMMM D YYYY',

			'M/D/YYYY',
			'M-D-YYYY',
			'M.D.YYYY',

			'M/D/YY',
			'M-D-YY',
			'M.D.YY',

			'D/M/YYYY',
			'D-M-YYYY',
			'D.M.YYYY',

			'D/M/YY',
			'D-M-YY',
			'D.M.YY',

			'YYYY/M/D',
			'YYYY-M-D',
			'YYYY.M.D',
			'YYYY-MM-DD',
		),
		'delimiter' => '|'
	);

	public function sanitize( $data ) {
		return Cornerstone_Control::sanitize_html( $data );
	}

}