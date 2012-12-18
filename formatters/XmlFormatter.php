<?php 

require_once __DIR__ . '/BaseFormatter.php';

use \SimpleXMLElement;

class XmlFormatter extends BaseFormatter {
	protected $doc;
	protected $testsuite;

	function __construct($stats) {
		parent::__construct($stats);
		$this->doc = new SimpleXMLElement("<testsuites></testsuites>");
		$this->testsuite = $this->doc->addChild("testsuite");
		$this->testsuite->addAttribute("id", 0);
		$this->testsuite->addAttribute("time", 0);
		$this->testsuite->addAttribute("name", "All Tests");
		$this->testsuite->addAttribute("package", "lithium");
		$this->testsuite->addAttribute("tests", $this->stats['count']['asserts']);
		$this->testsuite->addAttribute("errors", $this->stats['count']['errors']);
		$this->testsuite->addAttribute("failures", $this->stats['count']['fails']);
		$this->testsuite->addAttribute("hostname", "localhost");
		$this->testsuite->addAttribute("timestamp", "2012-01-01T01:01:01");
		$this->addAllErrors();
		$this->addAllFails();
		$this->addAllPasses();
	}

	public function addAllErrors(){
		foreach($this->stats['stats']['errors'] as $e){
			$element = $this->testsuite->addChild("testcase");
			$element->addAttribute("name", $e['method']);
			$element->addAttribute("classname", $e['class']);
			$element->addAttribute("time", "0");
			$fail = $element->addChild("error", "");
			$fail->addAttribute("type", $e["assertion"]);
			$fail->addAttribute("message", $e["message"]);
		}

		foreach($this->stats['stats']['exceptions'] as $e){
			$element = $this->testsuite->addChild("testcase");
			$element->addAttribute("name", $e['method']);
			$element->addAttribute("classname", $e['class']);
			$element->addAttribute("time", "0");
			$fail = $element->addChild("error", "");
			$fail->addAttribute("type", $e["assertion"]);
			$fail->addAttribute("message", $e["message"]);
		}
	}

	public function addAllFails(){
		foreach($this->stats['stats']['fails'] as $f){
			$element = $this->testsuite->addChild("testcase");
			$element->addAttribute("name", $f['method']);
			$element->addAttribute("classname", $f['class']);
			$element->addAttribute("time", "0");
			$fail = $element->addChild("failure");
			$fail->addAttribute("type", $f["assertion"]);
			$fail->addAttribute("message", $f["message"]);
		}
	}

	public function addAllPasses(){
		foreach($this->stats['stats']['passes'] as $p){
			$element = $this->testsuite->addChild("testcase");
			$element->addAttribute("name", $p['method']);
			$element->addAttribute("classname", $p['class']);
			$element->addAttribute("time", "0");
		}
	}

	public function save_output($results) {
		file_put_contents($results."/result.xml", $this->doc->asXML());
	}
}
