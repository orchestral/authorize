<?php namespace Authorize\Tests;

\Bundle::start('orchestra');
\Bundle::start('authorize');

class ConfigTest extends \Authorize\Testable\TestCase {
	
	/**
	 * Test configuration is properly map using memory.
	 *
	 * @test
	 */
	public function testConfigAttachToMemory()
	{
		$memory = \Orchestra::memory();

		$this->assertEquals(\Config::get('orchestra::orchestra.default_role'), 
			$memory->get('extension_authorize.default_role'));
		$this->assertEquals(\Config::get('orchestra::orchestra.member_role'), 
			$memory->get('extension_authorize.member_role'));
	}
}