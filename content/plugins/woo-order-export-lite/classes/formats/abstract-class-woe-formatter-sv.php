<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( class_exists( 'WOE_Formatter_sv' ) ) {
	return;
}

abstract class WOE_Formatter_sv extends WOE_Formatter {
	var $enclosure;
	var $linebreak;
	var $delimiter;
	var $encoding;
	var $rows;

	public function __construct( $mode, $filename, $settings, $format, $labels, $field_formats, $date_format ) {
		parent::__construct( $mode, $filename, $settings, $format, $labels, $field_formats, $date_format );

		$this->enclosure = $this->convert_literals( isset( $this->settings['enclosure'] ) ? $this->settings['enclosure'] : '' );
		$this->linebreak = $this->convert_literals( isset( $this->settings['linebreak'] ) ? $this->settings['linebreak'] : '' );
		$this->delimiter = $this->convert_literals( isset( $this->settings['delimiter'] ) ? $this->settings['delimiter'] : '' );
		$this->encoding  = isset( $this->settings['encoding'] ) ? $this->settings['encoding'] : '';

		// register the filter
		WOE_Formatter_sv_crlf_filter::set_linebreak( $this->linebreak );
		stream_filter_register( "WOE_Formatter_{$this->format}_crlf", 'WOE_Formatter_sv_crlf_filter' );
		// attach to stream 
		stream_filter_append( $this->handle, "WOE_Formatter_{$this->format}_crlf" );
	}

	public function start( $data = '' ) {
		$data = apply_filters( "woe_{$this->format}_header_filter", $data );
		$this->prepare_array( $data );
		parent::start( $data );

		if ( $this->settings['add_utf8_bom'] ) {
			fwrite( $this->handle, chr( 239 ) . chr( 187 ) . chr( 191 ) );
		}

		if ( $this->settings['display_column_names'] AND $data) {
			if ( $this->mode == 'preview' ) {
				$this->rows[] = $data;
			} else {
				do_action( "woe_before_{$this->format}_print_header", $this->handle, $data, $this);
				if( !apply_filters("woe_{$this->format}_custom_output_func",false, $this->handle, $data, $this->delimiter, $this->linebreak, $this->enclosure, true ) ) {
					if ( $this->enclosure !== '' ) {
						fputcsv( $this->handle, $data, $this->delimiter, $this->enclosure );
					} else {
						fwrite( $this->handle, implode( $this->delimiter, $data ) . $this->linebreak );
					}
				}
				do_action( "woe_{$this->format}_print_header", $this->handle, $data, $this);
			}
		}
	}

	public function output( $rec ) {
		$this->prepare_array( $rec );
		$rec = parent::output( $rec );

		if ( $this->has_output_filter ) {
			$rec = apply_filters( "woe_{$this->format}_output_filter", $rec, $rec );
			if( !$rec )
				return;
		}

		if ( $this->mode == 'preview' ) {
			$this->rows[] = $rec;
		} else {
			if( ! apply_filters("woe_{$this->format}_custom_output_func",false, $this->handle, $rec, $this->delimiter, $this->linebreak, $this->enclosure, false ) ) {
				if ( $this->enclosure !== '' ) {
					fputcsv( $this->handle, $rec, $this->delimiter, $this->enclosure );
				} else {
					fwrite( $this->handle, implode( $this->delimiter, $rec ) . $this->linebreak );
				}
			}
		}
	}

	public function finish() {
		if ( $this->mode == 'preview' ) {
			$this->rows = apply_filters( "woe_{$this->format}_preview_rows", $this->rows );
			fwrite( $this->handle, '<table>' );
			if ( count( $this->rows ) < 2 ) {
				$this->rows[] = array( __( '<td colspan=10><b>No results</b></td>', 'woo-order-export-lite' ) );
			}
			foreach ( $this->rows as $rec ) {
				$rec = array_map( function ( $a ) {
					return '<td>' . $a . '';
				}, $rec );
				fwrite( $this->handle, '<tr><td>' . join( '</td><td>', $rec ) . "</td><tr>\n" );
			}
			fwrite( $this->handle, '</table>' );
		} else {
			do_action( "woe_{$this->format}_print_footer", $this->handle, $this );
		}
		parent::finish();
	}

	protected function prepare_array( &$arr ) {
		if( apply_filters("woe_stop_csv_injection", true) ) {
			$arr = array_map( array( $this, 'stop_csv_injection' ), $arr );
		}	
			
		if ( ! in_array( $this->encoding, array( '', 'utf-8', 'UTF-8' ) ) ) {
			$arr = array_map( array( $this, 'encode_value' ), $arr );
		}
	}

	protected function stop_csv_injection( $value ) {
		$formula_chars = array( "=","+","-","@" );
		if ( in_array( substr($value,0,1), $formula_chars) )
			$value = " " . $value;
		return $value;
	}
	
	protected function encode_value( $value ) {
		return iconv( 'UTF-8', $this->encoding, $value );
	}
}

// filter class that applies CRLF line endings
class WOE_Formatter_sv_crlf_filter extends php_user_filter {
	protected static $linebreak;

	public static function set_linebreak( $linebreak ) {
		self::$linebreak = $linebreak;
	}

	function filter( $in, $out, &$consumed, $closing ) {
		while ( $bucket = stream_bucket_make_writeable( $in ) ) {
			// make sure the line endings aren't already CRLF
			$bucket->data = preg_replace( "/(?<!\r)\n/", self::$linebreak, $bucket->data );
			$consumed += $bucket->datalen;
			stream_bucket_append( $out, $bucket );
		}

		return PSFS_PASS_ON;
	}
}

