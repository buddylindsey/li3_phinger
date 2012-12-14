<?php 

use \SimpleXMLElement;

class XmlFormatter {
	protected $stats;
	protected $doc;

	function __construct($stats) {
		$this->stats = $stats;
		$this->$doc = new SimpleXMLElement("<testsuites></testsuites>");
	}

	function public save_output($results) {
		file_put_contents($results."/result.txt", $this->stats);
	}
}
