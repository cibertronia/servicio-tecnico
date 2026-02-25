<?php

namespace Common;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataExporter {
	private $_spreadsheet = null;
	private $_writer = null;
	private $_data = null;
	private $_format = 'csv';
	private $_columns = true;


	function __construct($data, $format = 'csv', $columns = true) {
		$this->_spreadsheet = new Spreadsheet();
		$this->_spreadsheet->setActiveSheetIndex(0);

		$this->_data = $data;
		$this->_format = $format;
		$this->_columns = $columns;

		if ($format == 'pdf') {
			$class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
			IOFactory::registerWriter('Pdf', $class);
		}

		$this->_setWriter();
	}

	public static function clean($value) {
		if (is_int($value) || is_null($value)) return $value;

		if (is_string($value)) $value = trim(preg_replace('/\s+/', ' ', $value));
		else {
			$is_array = is_array($value);
			foreach ($value as $index => $str) {
				if ($is_array) $value[$index] = self::clean($str);
				else $value->{$index} = self::clean($str);
			}
		}

		return $value;
	}

	public static function withToken($token, $session) {
		if (session_id()) {
			if ($data = get($token, $_SESSION)) {
				$calc = hash_hmac('sha256', get('token', $data), $session->token);
				if (hash_equals($calc, $token)) {
					return new self($data['data'], $data['format'], $data['columns']);
				}
			}
		}

		return false;
	}

	public static function getFormats() {
		return [
			'xlsx' => 'Excel',
			'csv' => 'CSV',
			// 'tsv' => 'Tab delimited',
			// 'psv' => 'Pipe delimited',
			'pdf' => 'PDF'
		];
	}

	public static function getFormatName($format) {
		$formats = self::getFormats();
		return isset($formats[$format]) ? $formats[$format] : null;
	}

	/**
	 * export short hand
	 * @param $name
	 * the format
	 *
	 * @example
	 * \Common\DataExporter::to_csv($data, 'file');
	*/
	public static function __callStatic($name, $args) {
		$func_parts = explode('_', $name);
		if (isset($func_parts[0]) && isset($func_parts[1]) && $func_parts[0] == 'to') {
			$format = $func_parts[1];
			$instance = null;

			if (!$args) {
				throw new \Exception('Empty arguments for export');
			}

			// args(data, [to = 'browser', filename = 'exportdata', columns = true])
			$data = $args[0];
			$output = $args[1] ?? 'browser';
			$filename = $args[2] ?? null;
			$columns = $args[3] ?? true;

			$exporter = new self($data, $format, $columns);

			$exporter->run($filename, $output);

		    return true;
		} else throw new \Exception('Invalid export method');
	}

	public function getUrl($session) {
		if (session_id()) {
			$token = token();
			$hashed_token = hash_hmac('sha256', $token, $session->token);

			$_SESSION[$hashed_token] = [
				'token' => $token,
				'data' => $this->_data,
				'format' => $this->_format,
				'columns' => $this->_columns
			];

			return APP_URL.'/export/'.$hashed_token;
		}

		return false;
	}

	private function _isTxtFormat() {
		return in_array($this->_format, array('tsv', 'psv'));
	}

	private function _setWriter() {
		if ($this->_isTxtFormat()) $writer_name = 'Csv';
		else $writer_name = ucwords($this->_format);

		$writer = IOFactory::createWriter($this->_spreadsheet, $writer_name);

		switch ($this->_format) {
			case 'tsv':
				$writer->setDelimiter("\t");
				$writer->setLineEnding("\r\n");
				break;
			case 'psv':
				$writer->setEnclosure('');
				$writer->setDelimiter('|');
				$writer->setLineEnding("\r\n");
				break;
		}

		$this->_writer = $writer;
	}

	public function getExtension() {
		if (in_array($this->_format, array('tsv', 'psv'))) $extension = '.txt';
		else $extension = '.'.$this->_format;

		return $extension;
	}

	private function _addRow($row_index, $row, $col_positions = null, $callback = null) {
		$active_sheet = $this->_spreadsheet->getActiveSheet();
		foreach ($row as $index => $value) {

			if ($col_positions) {
				$col_position = array_search($index, $col_positions);
				if ($col_position === false) continue;
			} else $col_position = $index;

			// rows and columns are 1 based index
			$cell = $active_sheet->getCellByColumnAndRow($col_position + 1, $row_index + 1, true);

			if ($this->_isTxtFormat()) {
				$delimiter = $this->_writer->getDelimiter();
				$value = trim(str_replace($delimiter, '\\'.$delimiter, $value));
			}

			$cell->setValue($value);

			if ($callback) $callback($cell);
		}
	}

	function run($filename = '', $output = 'browser') {
		$columns = $this->_columns;
		$format = $this->_format;

		$filename = $filename ?: APP_TMP_PATH.'/'.token().'_'.date('YmdHis').$this->getExtension();
		$col_positions = null;
		if (count($this->_data) > 0 && is_array($this->_data)) {
	        if ($columns) {
	        	$fields = array_keys(is_array($this->_data[0]) ? $this->_data[0] : get_object_vars($this->_data[0]));
	        	if (is_array($columns)) {
	        		$col_positions = [];
	        		foreach ($columns as $name => $column) {
	        			$key = array_search($name, $fields);
	        			if ($key !== false) {
	        				$fields[$key] = $column;
	        				$col_positions[] = $key;
	        			}
	        		}
	        	} else {
	        		$col_positions = array_keys($fields);
	        	}

	        	$this->_addRow(0, $fields, $col_positions, function($header_cell) use ($format) {
		        	$style_array = array(
		        		'font' => array('bold' => true)
		        	);

		        	if ($format == 'pdf') {
		        		$style_array['borders'] = array(
					        'outline' => array(
					            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					            'color' => array('argb' => '333333'),
					        ),
					    );
		        	}

		        	$style = $header_cell->getStyle();
		        	$style->applyFromArray($style_array);
		        });
	        }

	        foreach ($this->_data as $index => $row) {
	        	$raw_row = is_array($row) ? $row : get_object_vars($row);
	            $this->_addRow($index + ($columns ? 1 : 0), array_values($raw_row), $col_positions, function($cell) use ($format) {
	            	$style_array = array();

		        	if ($format == 'pdf') {
		        		$style_array['borders'] = array(
					        'outline' => array(
					            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					            'color' => array('argb' => '333333'),
					        ),
					    );
		        	}

		        	$style = $cell->getStyle();
		        	$style->applyFromArray($style_array);
	            });
	        }
	    }


	    if ($format == 'pdf') {
	    	$this->_writer->setTempDir(APP_TMP_PATH);
	    }

	    if ($output == 'browser') {
	    	$basename = pathinfo($filename, PATHINFO_BASENAME);
	    	header('Content-Disposition: attachment;filename="'.$basename.'"');
			header('Cache-Control: max-age=0');

	    	switch ($format) {
	    		case 'pdf':
	    			header('Content-Type: application/pdf');
	    			break;
	    		case 'xlsx':
	    			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	    			break;
	    		case 'csv':
	    			header("Content-type: text/csv");
	    			break;
	    		case 'tsv':
	    			header("Content-type: text/tab-separated-values");
	    			break;
	    		case 'psv':
	    			header("Content-type: text/pipe-separated-values");
	    			break;
	    	}

			$this->_writer->save('php://output');

	    } else {
	    	$this->_writer->save($filename);
	    }
	}

}