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
		$this->doc .= $this->stats['count']['asserts'] . " Assertions<br />";
		$this->doc .= $this->stats['count']['passes'] . " Passes<br />";
		$this->doc .= $this->stats['count']['fails'] . " Fails<br />";
		$this->doc .= $this->stats['count']['exceptions'] . " Exceptions<br />";
		$this->doc .= $this->stats['count']['errors'] . " Errors<br />";
		$this->doc .= $this->stats['count']['skips'] . " Skips";
	}

	private function createBody(){
		$this->doc .= "<h2>Results</h2>";

		$this->doc .= "<h3>Fails</h3>";
		foreach($this->stats['stats']['fails'] as $p){
			$this->doc .= "Fail: " . $p['method'] . "<br />";
		}

		$this->doc .= "<h3>Errors</h3>";
		foreach($this->stats['stats']['errors'] as $p){
			$this->doc .= "<div>";
			$this->doc .= "Class: " . $p['class'] . "<br />";
			$this->doc .= "Errors: " . $p['method'] . "<br />";
			$this->doc .= "Result: " . $p['result'] . "<br />";
			$this->doc .= "Message: " . $p['message'] . "<br />";
			$this->doc .= "File: " . $p['file'] . "<br />";
			$this->doc .= "Line: " . $p['line'] . "<br />";
			$this->doc .= "Trace: " . $p['trace'] . "<br />";
			$this->doc .= "</div>";
		}

		$this->doc .= "<h3>Exceptions</h3>";
		foreach($this->stats['stats']['exceptions'] as $p){
			$this->doc .= "<div>";
			$this->doc .= "Class: " . $p['class'] . "<br />";
			$this->doc .= "Line: " . $p['line'] . "<br />";
			$this->doc .= "Message: " . $p['message'] . "<br />";
			$this->doc .= "Exceptions: " . $p['method'] . "<br />";
			$this->doc .= "Trace: " . $p['trace'] . "<br />";
			$this->doc .= "</div>";
		}

		$this->doc .= "<h3>Passes</h3>";
		foreach($this->stats['stats']['passes'] as $p){
			$this->doc .= "Pass: " . $p['method'] . "<br />";
		}

	}
	public function save_output($results){
		file_put_contents($results . "/final.html", $this->doc );
	}

}
