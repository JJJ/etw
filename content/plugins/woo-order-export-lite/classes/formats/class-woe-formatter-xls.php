<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'PHPExcel' ) ) {
	include_once dirname( __FILE__ ) . '/../PHPExcel.php';
}

class WOE_Formatter_Xls extends WOE_Formatter {
	var $rows;
	var $auto_format_dates = false;

	public function __construct( $mode, $filename, $settings, $format, $labels, $field_formats, $date_format ) {
		parent::__construct( $mode, $filename, $settings, $format, $labels, $field_formats, $date_format );


		if ( $mode != 'preview' ) {
			//more memory for XLS?
			ini_set('memory_limit', '512M');
			//fallback to PCLZip
			if( !class_exists('ZipArchive') )
				PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
			fclose( $this->handle );
			$this->filename = $filename;
			if ( filesize( $this->filename ) > 0 ) {
				$this->objPHPExcel = PHPExcel_IOFactory::load( $this->filename );
			} else {
				$this->objPHPExcel = new PHPExcel();
			}
			$this->objPHPExcel->setActiveSheetIndex( 0 );

			do_action('woe_xls_PHPExcel_setup', $this->objPHPExcel, $settings);

			$this->last_row = $this->objPHPExcel->getActiveSheet()->getHighestRow();

			//fix bug,  row=1  if we have 0 records
			if( $this->last_row == 1  AND $this->objPHPExcel->getActiveSheet()->getHighestColumn() == "A" )
				$this->last_row = 0;
				
			// Excel uses another format!	
			$this->date_format = apply_filters( 'woe_xls_date_format', $this->convert_php_date_format( $date_format ) );
		}
	}

	public function start( $data = '' ) {
		$data = apply_filters( "woe_xls_header_filter", $data );
		parent::start( $data );

		if ( $this->mode == 'preview' ) {
			$this->rows[] = $data;
			return;
		}

		if ( $this->settings['display_column_names'] AND $data ) {
			$this->last_row++;
			foreach ( $data as $pos => $text ) {
				$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $pos, $this->last_row, $text );
			}

			//make first bold
			$last_column = $this->objPHPExcel->getActiveSheet()->getHighestDataColumn();
			$this->objPHPExcel->getActiveSheet()->getStyle( "A1:" . $last_column . "1" )->getFont()->setBold( true );

			//freeze
			$this->objPHPExcel->getActiveSheet()->freezePane( 'A2' );
		}

		//rename Sheet1
		if( empty($this->settings['sheet_name']) )
			$this->settings['sheet_name'] = __( 'Orders', 'woo-order-export-lite' );
		$sheet_name = WC_Order_Export_Engine::make_filename( $this->settings['sheet_name'] );
		$this->objPHPExcel->getActiveSheet()->setTitle( $sheet_name );

		// right-to-left worksheet?
		if( $this->settings['direction_rtl'] )
			$this->objPHPExcel->getActiveSheet()->setRightToLeft(true);

		do_action ( 'woe_xls_print_header', $this->objPHPExcel, $this );

		//save only header or empty file on init
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->settings['use_xls_format'] ? 'Excel5' : 'Excel2007');
		$objWriter->save( $this->filename );
	}

	public function output( $rec ) {
		$rec = parent::output( $rec );
		if ( $this->has_output_filter ) {
			$rec = apply_filters( "woe_xls_output_filter", $rec, $this );
			if( !$rec )
				return;
		}

		if ( $this->mode == 'preview' ) {
			$rec = $this->format_dates( $rec );
			$this->rows[] = $rec;
		} else {
			$this->last_row ++;
			$pos = 0;
			foreach ( $rec as $field => $text ) {
				if( $this->string_format_force OR in_array($field, $this->string_format_fields) ) {
					$this->objPHPExcel->getActiveSheet()->setCellValueExplicitByColumnAndRow( $pos, $this->last_row, $text );
				} elseif( in_array($field, $this->date_format_fields) ) {// DATE!
					if( $text ) {
						if( empty($this->settings['global_job_settings']['time_format']) ) { // must remove time!
							$text = date( "Y-m-d", strtotime( $text ) );
						}
						$text = PHPExcel_Shared_Date::PHPToExcel( new DateTime($text) );
						$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $pos, $this->last_row, $text );
					}	
					$this->objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($pos, $this->last_row)->getNumberFormat()->setFormatCode( $this->date_format );
				} else {
					$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $pos, $this->last_row, $text );
				}
				$pos++;
			}
		}
	}

	public function finish() {
		if ( $this->mode == 'preview' ) {
			$max_columns  = 0;
			fwrite( $this->handle, '<table>' );
			if ( count( $this->rows ) < 2 ) {
				$this->rows[] = array( __( '<td colspan=10><b>No results</b></td>', 'woo-order-export-lite' ) );
			}
			foreach ( $this->rows as $num => $rec ) {
				$max_columns  = max( $max_columns  , count($rec) );

				//adds extra space for RTL
				if( $this->settings['direction_rtl'] ) {
					while( count($rec) < $max_columns  )
						$rec[] = '';
					$rec = array_reverse( $rec );
				}
				if ( $num == 0 AND $this->settings['display_column_names'] ) {
					fwrite( $this->handle, '<tr style="font-weight:bold"><td>' . join( '</td><td>', $rec ) . "</td><tr>\n" );
				} else {
					fwrite( $this->handle, '<tr><td>' . join( '</td><td>', $rec ) . "</td><tr>\n" );
				}
			}
			fwrite( $this->handle, '</table>' );
		} else {
			if ( $this->settings['auto_width'] ) {
				try {
					$sheet = $this->objPHPExcel->getActiveSheet();
					$cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
					$cellIterator->setIterateOnlyExistingCells(true);
					foreach ($cellIterator as $cell) {
						$sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
					}
					$sheet->calculateColumnWidths();
				} catch (Exception $e) {
					//do nothing here , adjustment failed gracefully
				}
			}
			do_action ( 'woe_xls_print_footer', $this->objPHPExcel, $this );
			$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->settings['use_xls_format'] ? 'Excel5' : 'Excel2007');
			$objWriter->save( $this->filename );
		}
	}
	
	//just save Excel file 
	public function finish_partial() {
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, $this->settings['use_xls_format'] ? 'Excel5' : 'Excel2007');
		$objWriter->save( $this->filename );
	}

	public function truncate() {
		$this->objPHPExcel->disconnectWorksheets();
		$this->objPHPExcel->createSheet();
		$this->last_row = 0;
	}
	
	public function convert_php_date_format( $date_format ) {
		$replacements = array(
			//Day
			'd'=>'dd',
			'D'=>'ddd',
			'j'=>'d',
			'l'=>'dddd',
			//Month
			'F'=>'mmmm',
			'm'=>'mm',
			'M'=>'mmm',
			'n'=>'m',
			//Year
			'Y'=>'yyyy',
			'y'=>'yy',
			// Time
			'A'=>'am/pm',
			'a'=>'am/pm',
			'G'=>'hh',
			'g'=>'h',//1-12
			'H'=>'hh',
			'h'=>'h',//1-12
			'i'=>'mm',
			's'=>'ss',
		);
		return strtr($date_format, $replacements);
	}

}
