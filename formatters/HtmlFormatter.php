<?php

require_once __DIR__ . '/BaseFormatter.php';

class HtmlFormatter extends BaseFormatter{

	protected $doc;

	function __construct($stats){
		parent::__construct($stats);
		$this->buildReport();
	}

	private function buildReport(){
		$this->createHeader();
		$this->createBody();
	}

	private function createHeader(){
		$this->doc .= "<h2>Stats</h2>";
		$this->doc .= "<pre>";
		$this->doc .= print_r($this->stats['count'], true);
		$this->doc .= "</pre>";
	}

	private function createBody(){
		$this->doc .= "<h2>Results</h2>";
		foreach($this->stats['stats']['passes'] as $p){
			$this->doc .= "Pass: " . $p['method'] . "<br />";
		}
	}

	public function save_output($results){
		file_put_contents($results . "/final.html", $this->doc );
	}

}
