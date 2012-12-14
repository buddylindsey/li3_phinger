<?php

require_once __DIR__ . '/../formatters/XmlFormatter.php';
require_once __DIR__ .'/../formatters/HtmlFormatter.php';

/**
 * Lithium test task for Phing.
 *
 * @author Buddy Lindsey, Jr. <percent20 at gmail.com>
 * @author forked from - Iain Cambridge <hiThere at icambridge dot me>
 * @license Unlicense http://unlicense.org/
 */

class TestTask extends Task
{

	/**
	 * The location of the lithium app.
	 *
	 * @var string
	 */
	protected $li3Base;

	/**
	 * Environment to run tests in default is 'test', but you can use others.
	 *
	 * @var string
	 */
	protected $li3Env;

	/**
	 * What tests are to be run. Based on the args send on the web interface.
	 *
	 * @var string
	 */
	protected $tests;

	/**
	 * Which formatter to use when ouputing results
	 *
	 * @var string
	 */
	protected $formatter;

	/**
	 * What location the all results output goes
	 *
	 * @var string
	 */
	protected $results;

	/**
	 * The main entry point for the task.
	 * @return bool
	 * @throws BuildException
	 */
	public function main()
	{
		if (empty($this->li3Base)) {
			throw new BuildException('"li3Base" is required');
		}

		if (empty($this->tests)) {
			throw new BuildException('"tests" is required');
		}

		if (empty($this->li3Env)) {
			$this->li3Env = 'test';
			putenv("LI3_ENV=test");
		}

		require_once($this->li3Base . '/app/config/bootstrap.php');

		if (!include_once LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
			$message = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
			$message .= __FILE__ . ".  It should point to the directory containing your ";
			$message .= "/libraries directory. " . LITHIUM_LIBRARY_PATH;
			throw new BuildException($message);
		}

		lithium\core\Libraries::add(basename(LITHIUM_APP_PATH), array(
			'default' => true,
			'path' => LITHIUM_APP_PATH
		));

		$group = ($this->tests == 'all') ? lithium\test\Group::all() : $this->tests;

		$report = new lithium\test\Report(array(
			'title' => 'Main Test Run',
			'group' => new lithium\test\Group(array('data' => array('app\tests'))),
			'format' => 'html',
		));

		$result = $report->run();

		$stats = $report->stats();

		$formatter = new HtmlFormatter($stats);
		$formatter->save_output($this->results);

		if (!$stats['success']) {
			throw new BuildException("Unit tests failed for {$this->tests}. {$stats['count']['passes']}/{$stats['count']['asserts']} passes. Check lithium's test suite for more information.");
		}

		return true;
	}

	public function setLi3Base($li3Base)
	{
		$li3Base = realpath($li3Base);
		if (!file_exists($li3Base)) {
			throw new BuildException('"li3Base" directory doesn\'t exist');
		}

		if (!file_exists($li3Base . '/app/config/bootstrap.php')) {
			throw new BuildException('Couldn\'t find the bootstrap');
		}
		define('LITHIUM_LIBRARY_PATH', $li3Base . '/libraries');
		define('LITHIUM_APP_PATH', $li3Base . '/app');
		$this->li3Base = $li3Base;
	}

	public function getFormatter()
	{
		return $this->formatter;
	}

	public function setFormatter($formatter)
	{
		$this->formatter = $formatter;
	}

	public function getResults()
	{
		return $this->results;
	}

	public function setResults($results)
	{
		$this->results = $results;
	}

	public function getLi3Base()
	{
		return $this->li3Base;
	}

	public function setLi3Env($li3Env)
	{
		putenv("LI3_ENV=test");
		$this->li3Env = $li3Env;
	}

	public function getLi3Env()
	{
		return $this->li3Env;
	}

	public function setTests($tests)
	{
		$this->tests = $tests;
	}

	public function getTests()
	{
		return $this->test;
	}
}
