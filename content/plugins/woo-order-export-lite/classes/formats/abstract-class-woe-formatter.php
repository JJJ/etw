<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class WOE_Formatter {
	var $has_output_filter;
	var $mode;
	var $settings;
	var $labels;
	var $handle;
	var $format;
	var $field_formats;
	var $date_format;
	var $auto_format_dates = true;
	var $counter_value;
	
	public function __construct( $mode, $filename, $settings, $format, $labels, $field_formats, $date_format ) {
		$this->has_output_filter = has_filter( "woe_{$format}_output_filter" );
		$this->mode              = $mode;
		$this->filename          = $filename;
		$this->settings          = $settings;
		$this->labels            = $labels;
		$this->handle            = fopen( $filename, 'a' );
		if ( ! $this->handle ) {
			throw new Exception( $filename . __( 'can not open for output', 'woo-order-export-lite' ) );
		}
		$this->format            = $format;
		
		// format for cells
		$this->field_formats	 = $field_formats;
		$this->string_format_force = apply_filters( "woe_{$format}_string_format_force", false );
		$this->string_format_fields = apply_filters( "woe_{$format}_string_format_fields", $field_formats['string'] );
		$this->date_format_fields = apply_filters( "woe_{$format}_date_format_fields", $field_formats['date'] );
		$this->date_format = apply_filters( "woe_{$format}_date_format", $date_format );

		$this->counter_value = $this->get_counter();
		if ( !$this->counter_value ) {
			$this->counter_value = 1;
			$this->set_counter( $this->counter_value );
		}
	}

	function __destruct() {
		$this->set_counter( $this->counter_value );
	}

	public function start( $data = '' ) {
		do_action("woe_formatter_start", $data);
		do_action("woe_formatter_" .$this->format. "_start", $data);
	}

	public function output( $rec ) {
		$this->handle = apply_filters( "woe_formatter_set_handler_for_" . $this->format . "_row", $this->handle );
		if( $this->auto_format_dates ) 
			$rec = $this->format_dates( $rec );
		if ( isset( $rec['line_number'] ) ) {
			$rec['line_number'] = $this->counter_value;
			$this->counter_value++;
		}
		return $rec;
	}

	public function finish() {
		fclose( $this->handle );
		$this->delete_counter();
		do_action("woe_formatter_finish", $this);
		do_action("woe_formatter_" .$this->format. "_finished", $this);
	}
	
	public function finish_partial() {
		// child must fully implement this method
		fclose( $this->handle );
		do_action("woe_formatter_finish_partial", $this);
		do_action("woe_formatter_" .$this->format. "_finished_partially", $this);
	}

	public function truncate() {
		ftruncate( $this->handle, 0 );
	}

	protected function convert_literals( $s ) {
		$s = str_replace( '\r', "\r", $s );
		$s = str_replace( '\t', "\t", $s );
		$s = str_replace( '\n', "\n", $s );

		return $s;
	}
	
	protected function format_dates( $rec ) {
		foreach($rec as $field=>$value) {
			if( in_array($field,$this->field_formats['date']) ) {
				$ts = strtotime($value);
				if( $ts )
					$rec[$field] = date($this->date_format, $ts);
			}
		}
		return $rec;
	}
	
	
	protected function generate_key() {
		return $this->mode . '+' . $this->filename;
	}
	
	protected function delete_counter() {
		delete_transient( $this->generate_key() );
	}

	protected function set_counter( $count_value ) {
		$this->counter_value = $count_value;
		if ( $this->mode != 'preview' ) {
			set_transient( $this->generate_key(), $count_value );
		}
	}

	protected function get_counter() {
		if ( $this->mode == 'preview' ) {
			return false;
		} else {
			return get_transient( $this->generate_key() );
		}
	}
}