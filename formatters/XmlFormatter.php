<?php 

require_once __DIR__ . '/BaseFormatter.php';

use \SimpleXMLElement;

class XmlFormatter extends BaseFormatter {
	protected $doc;

	function __construct($stats) {
		parent::__construct($stats);
		$this->doc = new SimpleXMLElement("<testsuites></testsuites>");
	}

	public function save_output($results) {
		file_put_contents($results."/result.txt", print_r($this->stats,true));
	}
}
